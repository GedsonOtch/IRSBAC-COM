<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Ue;
use App\Models\Ecue;
use App\Models\Note;
use App\Models\Filiere;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FichierDelibController extends Controller
{
    // ⚠️ à ajuster une fois confirmé auprès de l'établissement
    private const SEUIL_MAX_REPRISE = 2;

    public function generer(Request $request)
    {
        $request->validate([
            'filliere_id'         => 'required',
            'annee_academique_id' => 'required',
        ]);

        $filliere = Filiere::findOrFail($request->filliere_id);
        $spreadsheet = new Spreadsheet();
        $premiereFeuille = true;
        $donneesParSemestre = [];

        foreach (range(1, 6) as $semestre) {
            $niveau = match (true) {
                $semestre <= 2 => 'LICENCE 1',
                $semestre <= 4 => 'LICENCE 2',
                default        => 'LICENCE 3',
            };

            $etudiants = Etudiant::where('filiere_id', $filliere->id)
                ->where('annee_etude', (int) ceil($semestre / 2)) // ⚠️ à confirmer selon le format réel en base
                ->orderBy('nom')
                ->get();

            if ($etudiants->isEmpty()) continue;

            $ues = Ue::whereHas('filieres', function ($q) use ($filliere) {
                    $q->where('filieres.id', $filliere->id);
                })
                ->where('semestre', $semestre)
                ->with('ecues')
                ->get();

            if ($ues->isEmpty()) continue;

            // -- feuille --
            if ($premiereFeuille) {
                $sheet = $spreadsheet->getActiveSheet();
                $premiereFeuille = false;
            } else {
                $sheet = $spreadsheet->createSheet();
            }
            $sheet->setTitle("S{$semestre}");

            // -- en-tête --
            $sheet->setCellValue('B1', "MINISTERE DE L'ENSEIGNEMENT SUPERIEUR ET DE LA RECHERCHE SCIENTIFIQUE");
            $sheet->setCellValue('B2', "IRSBAC. COM");
            $sheet->setCellValue('B3', "JURY DE DELIBERATION DES RESULTATS");
            $sheet->setCellValue('B4', $niveau);
            $sheet->setCellValue('D4', $filliere->nom);
            $sheet->setCellValue('G4', "SEMESTRE {$semestre}");

            // -- ligne d'en-tête du tableau --
            $ligne = 6;
            $sheet->setCellValue("A{$ligne}", 'N°');
            $sheet->setCellValue("B{$ligne}", 'UE');
            $sheet->setCellValue("C{$ligne}", 'CREDIT');
            $sheet->setCellValue("D{$ligne}", 'ECUE');
            $col = 'E';
            foreach ($etudiants as $etudiant) {
                $sheet->setCellValue("{$col}{$ligne}", "{$etudiant->nom} {$etudiant->prenom}");
                $col++;
            }
            $ligne++;

            // -- accumulateurs pour la synthèse --
            $sommeCredits = [];
            $sommePonderee = [];
            $totalValide = [];

            // -- boucle UE / ECU --
            $numeroUe = 1;
            foreach ($ues as $ue) {
                if ($ue->ecues->isEmpty()) continue;

                $ligneDebutUe = $ligne;

                foreach ($ue->ecues as $ecue) {
                    $col = 'E';
                    foreach ($etudiants as $etudiant) {
                        $note = Note::where('etudiant_id', $etudiant->id)
                            ->where('ecue_id', $ecue->id)
                            ->where('annee_academique_id', $request->annee_academique_id)
                            ->value('note');
                        $sheet->setCellValue("{$col}{$ligne}", $note);
                        $col++;
                    }
                    $sheet->setCellValue("D{$ligne}", $ecue->nom);
                    $ligne++;
                }

                // -- Moyenne de l'UE --
                $sheet->setCellValue("D{$ligne}", 'Moyenne');
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $id = $etudiant->id;
                    $moyenneUe = Note::where('etudiant_id', $id)
                        ->whereIn('ecue_id', $ue->ecues->pluck('id'))
                        ->where('annee_academique_id', $request->annee_academique_id)
                        ->avg('note');
                    $moyenneUe = $moyenneUe !== null ? round($moyenneUe, 2) : null;
                    $sheet->setCellValue("{$col}{$ligne}", $moyenneUe);

                    $sommeCredits[$id] = ($sommeCredits[$id] ?? 0) + $ue->credit;
                    $sommePonderee[$id] = ($sommePonderee[$id] ?? 0) + ($moyenneUe ?? 0) * $ue->credit;
                    if ($moyenneUe !== null && $moyenneUe >= 10) {
                        $totalValide[$id] = ($totalValide[$id] ?? 0) + 1;
                    }

                    $col++;
                }
                $ligne++;

                // -- OBSV du jury --
                $sheet->setCellValue("D{$ligne}", 'OBSV du jury');
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $moy = $sheet->getCell($col . ($ligne - 1))->getValue();
                    $sheet->setCellValue("{$col}{$ligne}", ($moy !== null && $moy >= 10) ? 'V' : 'NV');
                    $col++;
                }
                $ligne++;

                // -- fusion N° / UE / CREDIT --
                $sheet->mergeCells("A{$ligneDebutUe}:A" . ($ligne - 1));
                $sheet->mergeCells("B{$ligneDebutUe}:B" . ($ligne - 1));
                $sheet->mergeCells("C{$ligneDebutUe}:C" . ($ligne - 1));
                $sheet->setCellValue("A{$ligneDebutUe}", $numeroUe);
                $sheet->setCellValue("B{$ligneDebutUe}", $ue->nom);
                $sheet->setCellValue("C{$ligneDebutUe}", $ue->credit);

                $numeroUe++;
            }

            // -- synthèse : moyenne pondérée par étudiant --
            $moyennePonderee = [];
            foreach ($etudiants as $etudiant) {
                $id = $etudiant->id;
                $moyennePonderee[$id] = isset($sommeCredits[$id]) && $sommeCredits[$id] > 0
                    ? round($sommePonderee[$id] / $sommeCredits[$id], 2)
                    : null;
            }
            $totalUeSemestre = $numeroUe - 1;

            if ($semestre % 2 === 1) {
                // ================= SEMESTRE IMPAIR =================
                $sheet->setCellValue("B{$ligne}", 'TOTAL UE validé');
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $sheet->setCellValue("{$col}{$ligne}", $totalValide[$etudiant->id] ?? 0);
                    $col++;
                }
                $ligne++;

                $sheet->setCellValue("B{$ligne}", 'DECISION DU JURY');
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $valide = $totalValide[$etudiant->id] ?? 0;
                    $sheet->setCellValue("{$col}{$ligne}", $this->determinerDecision($totalUeSemestre, $valide));
                    $col++;
                }
                $ligne++;

                $sheet->setCellValue("B{$ligne}", 'Moyenne du semestre');
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $sheet->setCellValue("{$col}{$ligne}", $moyennePonderee[$etudiant->id]);
                    $col++;
                }
                $ligne++;

                $sheet->setCellValue("D{$ligne}", "PARAKOU LE " . now()->format('d/m/Y'));

                $donneesParSemestre[$semestre] = [
                    'moyennes' => $moyennePonderee,
                    'valide'   => $totalValide,
                    'totalUe'  => $totalUeSemestre,
                ];
            } else {
                // ================= SEMESTRE PAIR =================
                $semImpair = $semestre - 1;
                $precedent = $donneesParSemestre[$semImpair] ?? ['moyennes' => [], 'valide' => [], 'totalUe' => 0];

                $sheet->setCellValue("B{$ligne}", "TOTAL UE  validé S{$semImpair}");
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $sheet->setCellValue("{$col}{$ligne}", $precedent['valide'][$etudiant->id] ?? 0);
                    $col++;
                }
                $ligne++;

                $sheet->setCellValue("B{$ligne}", "TOTAL UE  validé S{$semestre}");
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $sheet->setCellValue("{$col}{$ligne}", $totalValide[$etudiant->id] ?? 0);
                    $col++;
                }
                $ligne++;

                $sheet->setCellValue("B{$ligne}", 'MOYENNE DU SEMESTRE');
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $sheet->setCellValue("{$col}{$ligne}", $moyennePonderee[$etudiant->id]);
                    $col++;
                }
                $ligne++;

                $moyenneAnnuelle = [];
                $sheet->setCellValue("B{$ligne}", 'MOYENNE ANNUELLE');
                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $id = $etudiant->id;
                    $mImpair = $precedent['moyennes'][$id] ?? null;
                    $mPair = $moyennePonderee[$id] ?? null;
                    $moyenneAnnuelle[$id] = ($mImpair !== null && $mPair !== null)
                        ? round(($mImpair + $mPair) / 2, 2) : null;
                    $sheet->setCellValue("{$col}{$ligne}", $moyenneAnnuelle[$id]);
                    $col++;
                }
                $ligne++;

                // -- DECISION DU JURY (mémorisée pour le classement) --
                $sheet->setCellValue("B{$ligne}", 'DECISION DU JURY');
                $col = 'E';
                $decisionAnnuelle = [];
                foreach ($etudiants as $etudiant) {
                    $id = $etudiant->id;
                    $valideAnnee = ($precedent['valide'][$id] ?? 0) + ($totalValide[$id] ?? 0);
                    $totalUeAnnee = $precedent['totalUe'] + $totalUeSemestre;
                    $decision = $this->determinerDecision($totalUeAnnee, $valideAnnee);
                    $decisionAnnuelle[$id] = $decision;
                    $sheet->setCellValue("{$col}{$ligne}", $decision);
                    $col++;
                }
                $ligne++;

                // -- RANG : priorité décision d'abord, moyenne ensuite --
                $sheet->setCellValue("B{$ligne}", 'RANG');

                $prioriteDecision = function (string $decision): int {
                    if ($decision === 'V') return 0;
                    if (str_contains($decision, 'REPRISE')) return 1;
                    return 2; // NV
                };

                $classement = [];
                foreach ($etudiants as $etudiant) {
                    $id = $etudiant->id;
                    $classement[$id] = [
                        'priorite' => $prioriteDecision($decisionAnnuelle[$id] ?? 'NV'),
                        'moyenne'  => $moyenneAnnuelle[$id] ?? null,
                    ];
                }

                uasort($classement, function ($a, $b) {
                    if ($a['priorite'] !== $b['priorite']) {
                        return $a['priorite'] <=> $b['priorite'];
                    }
                    return ($b['moyenne'] ?? -1) <=> ($a['moyenne'] ?? -1);
                });

                $rangs = [];
                $rangCourant = 0;
                $dernierCle = false;
                $i = 0;
                foreach ($classement as $etudiantId => $info) {
                    $i++;
                    $cle = $info['priorite'] . '|' . $info['moyenne'];
                    if ($cle !== $dernierCle) {
                        $rangCourant = $i;
                        $dernierCle = $cle;
                    }
                    $rangs[$etudiantId] = $rangCourant;
                }

                $col = 'E';
                foreach ($etudiants as $etudiant) {
                    $r = $rangs[$etudiant->id] ?? null;
                    $sheet->setCellValue("{$col}{$ligne}", $r === null ? null : ($r === 1 ? '1er' : "{$r}e"));
                    $col++;
                }
                $ligne++;

                $sheet->setCellValue("K{$ligne}", "Parakou le " . now()->format('d/m/Y'));
            }
        }

        if ($premiereFeuille) {
            return back()->withErrors('Aucun étudiant trouvé pour cette filière/année académique.');
        }

        $writer = new Xlsx($spreadsheet);
        $nomFichier = "PV_deliberation_{$filliere->nom}.xlsx";

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $nomFichier, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function determinerDecision(int $totalUe, int $valide): string
    {
        $nonValidees = $totalUe - $valide;

        if ($nonValidees === 0) {
            return 'V';
        }

        if ($nonValidees <= self::SEUIL_MAX_REPRISE) {
            return $nonValidees > 1 ? "{$nonValidees} REPRISES" : '1 REPRISE';
        }

        return 'NV';
    }
}