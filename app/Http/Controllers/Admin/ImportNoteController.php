<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\Ecue;
use App\Models\Note;
use App\Models\Filiere;
use App\Models\AnneeAcademique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class ImportNoteController extends Controller
{


private function semestresParNiveau(string $niveau): array
{
    $niveau = mb_strtoupper(trim($niveau));
    return match  ($niveau) {
        '1' => [1, 2],
        '2' => [3, 4],
        '3' => [5, 6],
    };
}




    // GET /admin/notes/modele → affiche le formulaire de sélection
    public function formulaireModele()
    {
        return view('admin.importationexcel', [
            'filieres' => Filiere::orderBy('nom')->get(),
            'annees'   => AnneeAcademique::orderByDesc('id')->get(),
        ]);
    }

    // GET /admin/notes/modele/telecharger → génère le fichier centralisé
   

public function modele(Request $request)
{
    $request->validate([
        'filiere_id'          => 'required',
        'annee_etude'          => 'required|in:1,2,3',
        
    ]);

    //dd($request->annee_etude, strlen($request->annee_etude));
    $semestres = $this->semestresParNiveau($request->annee_etude);

    $etudiants = Etudiant::where('filiere_id', $request->filiere_id)
        ->where('annee_etude', $request->annee_etude)
        ->orderBy('nom')
        ->get();

    if ($etudiants->isEmpty()) {
        return back()->withErrors('Aucun étudiant trouvé pour ces critères.');
    }

    $feuilles = [];

    foreach ($semestres as $s) {
        $ecus = Ecue::whereHas('ue', function ($q) use ($request, $s) {
            $q->where('semestre', $s)
              ->whereHas('filieres', fn ($q2) => $q2->where('filieres.id', $request->filiere_id));
        })->get();

        $feuilles["S{$s}"] = $etudiants->map(function ($e) use ($ecus) {
            $ligne = ['matricule' => $e->matricule, 'nom' => $e->nom, 'prenom' => $e->prenom];
            foreach ($ecus as $ecu) {
                $ligne["{$ecu->nom} [{$ecu->id}]"] = null;
            }
            return $ligne;
        });
    }
//$filier = Filiere::where('id', $request->filiere_id);
//$filiereNom = $filier->nom;

    $sheets = new SheetCollection($feuilles);
    $nomFichier = "notes_{$request->filiere_id}_{$request->annee_etude}.xlsx";

    // download() plutôt qu'export() : évite l'écriture dans /public,
    // et déclenche un vrai téléchargement sans quitter la page en cours
    return (new FastExcel($sheets))->download($nomFichier);
}

    // POST /admin/notes/import → traite le fichier renvoyé
   
public function import(Request $request)
{
    $request->validate([
        'fichier'              => 'required|mimes:xlsx,csv',
        'annee_academique_id'  => 'required',
    ]);

    $feuilles = (new FastExcel)->withSheetsNames()->importSheets($request->file('fichier'));

    $erreurs = [];
    $colonnesIgnorees = [];

    DB::transaction(function () use ($feuilles, $request, &$erreurs, &$colonnesIgnorees) {
        foreach ($feuilles as $nomFeuille => $rows) {
            if (!preg_match('/^S(\d)$/', trim($nomFeuille), $sm)) {
                continue; // ignore un onglet imprévu
            }

            foreach ($rows as $i => $row) {
                $ligne = $i + 2;

                $etudiant = Etudiant::where('matricule', $row['matricule'] ?? null)->first();
                if (!$etudiant) {
                    $erreurs[] = "Feuille {$nomFeuille}, ligne {$ligne} : matricule introuvable.";
                    continue;
                }

                foreach ($row as $colonne => $valeur) {
                    $colonneNettoyee = trim($colonne);

                    if (in_array(mb_strtolower($colonneNettoyee), ['matricule', 'nom', 'prenom', 'prénom'])) continue;

                    if (!preg_match('/\[(\d+)\]\s*$/', $colonneNettoyee, $m)) {
                        $colonnesIgnorees["{$nomFeuille}: {$colonne}"] = true;
                        continue;
                    }
                    $ecuId = $m[1];

                    if ($valeur === null || $valeur === '') continue;

                    if (!is_numeric($valeur) || $valeur < 0 || $valeur > 20) {
                        $erreurs[] = "Feuille {$nomFeuille}, ligne {$ligne} : note invalide pour ECU {$ecuId}.";
                        continue;
                    }

                    Note::updateOrCreate(
                        [
                            'etudiant_id'         => $etudiant->id,
                            'ecue_id'             => $ecuId,
                            'annee_academique_id'  => $request->annee_academique_id,
                        ],
                        ['note' => $valeur]
                    );
                }
            }
        }
    });

    return back()->with([
        'success'          => 'Import terminé.',
        'erreurs'          => $erreurs,
        'colonnesIgnorees' => array_keys($colonnesIgnorees),
    ]);
}

}

