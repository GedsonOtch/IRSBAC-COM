<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, DB, Log, Storage};
use App\Models\Etudiant;
use App\Models\Attestation;
use App\Models\SignatureCachet;

class AtestaController extends Controller
{
    //

private const DISQUE_PDF = 'public';

      public function generer(Request $request)
    {
        $data = $request->validate([
            'date_deliberation' => ['required', 'date'],
            'date_document'     => ['required', 'date', 'after_or_equal:date_deliberation'],
            'numero_depart'    => ['required', 'integer', 'min:1'],
        ]);

        set_time_limit(0); // beaucoup de PDF à produire

        // Empêche deux générations simultanées (double clic, deux admins)
        $verrou = Cache::lock('attestations:generation', 600);
        if (! $verrou->get()) {
            return back()->with('error', 'Une génération est déjà en cours, réessaie dans un instant.');
        }

        try {
            $rapport = $this->genererPourTous($data);
        } finally {
            $verrou->release();
        }

        return back()->with('rapport', $rapport);
    }

    public function telecharger(Attestation $attestation)
    {
    $disque = Storage::disk(self::DISQUE_PDF);
    // Régénère le fichier s'il a disparu (toutes les données sont en base)
        if (! $attestation->pdf_path || ! $disque->exists($attestation->pdf_path)) {
            $attestation->update(['pdf_path' => $this->stockerPdf($attestation)]);
        }

        return $disque->response($attestation->pdf_path, "attestation_{$attestation->etudiant_id}.pdf");
    }

    private function genererPourTous(array $data): array
    {
        $generees = 0;
        $refus = [];

        $etudiants = Etudiant::whereDoesntHave('attestation')   // condition 1 : pas déjà générée
            ->with(['releveS6', 'filiere'])
            ->orderBy('nom')->orderBy('prenom')
            ->get();

        foreach ($etudiants as $etudiant) {
            $releve = $etudiant->releveS6;

            // condition 2 : relevé du semestre 6 disponible
            if (! $releve) {
                $refus[] = "{$etudiant->nom} : relevé du semestre 6 indisponible.";
                continue;
            }

            // condition 3 : décision "valide"
            if ((trim($releve->decision)) !== 'VALIDE') {
                $refus[] = "{$etudiant->nom} : décision du semestre 6 non valide.";
                continue;
            }

            try {
                $this->creerAttestation($etudiant, $data);
                $generees++;
            } catch (\Throwable $e) {
                Log::error("Attestation échouée (étudiant {$etudiant->id})", ['erreur' => $e->getMessage()]);
                $refus[] = "{$etudiant->nom} : erreur technique, réessaie.";
            }
        }

        return ['generees' => $generees, 'refus' => $refus];
    }

    private function creerAttestation(Etudiant $etudiant, array $data): void
    {
        $chemin = null;

        try {
            DB::transaction(function () use ($etudiant, $data, &$chemin) {
                // Premier numéro du formulaire = plancher, puis incrément
                $numero = max((int) $data['numero_depart'], (int) Attestation::max('numero_attestation') + 1);

                $attestation = Attestation::create([
                    'etudiant_id'        => $etudiant->id,
                    'numero_attestation' => $numero,
                    'date_deliberation'  => $data['date_deliberation'],
                    'date_document'      => $data['date_document'],
                ]);

                $chemin = $this->stockerPdf($attestation);
                $attestation->update(['pdf_path' => $chemin]);
            });
        } catch (\Throwable $e) {
            if ($chemin) {
                Storage::disk(self::DISQUE_PDF)->delete($chemin); // pas de fichier orphelin
            }
            throw $e;
        }
    }

    private function stockerPdf(Attestation $attestation): string
    {
        $attestation->loadMissing('etudiant.filiere');

  $signatureDirecteur =
                SignatureCachet::get('directeur', 'signature');

                 $cachetDirecteur =
                SignatureCachet::get(
                    'directeur',
                    'cachet'
                );

$signatureDirecteur_etude =
                SignatureCachet::get('directeur_etudes', 'signature');

                   $cachetDirecteur_etude =
                SignatureCachet::get(
                    'directeur_etudes',
                    'cachet'
                );



        $chemin = "attestations/Attestation{$attestation->etudiant->matricule}.pdf";

        Storage::disk(self::DISQUE_PDF)->put($chemin, Pdf::loadView('admin.releves.pdf.attestation',
         [
'attestation' => $attestation,
 'cachetDirecteurPath' => $cachetDirecteur ? Storage::disk('public')->path($cachetDirecteur->image_path) : null,
'signatureDirecteurPath' => $signatureDirecteur ? Storage::disk('public')->path($signatureDirecteur->image_path) : null,
'cachetDirecteur_etu_Path' => $cachetDirecteur_etude ? Storage::disk('public')->path($cachetDirecteur_etude->image_path) : null,
'signatureDirecteur_etu_Path' => $signatureDirecteur_etude ? Storage::disk('public')->path($signatureDirecteur_etude->image_path) : null,


         ])
            ->setPaper('a4', 'portrait')
            ->output());

        return $chemin;
    }
}

