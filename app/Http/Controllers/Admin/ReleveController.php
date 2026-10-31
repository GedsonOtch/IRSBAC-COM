<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use App\Models\AnneeAcademique;
use App\Models\Releve;
use App\Models\Ue;
use App\Models\Note;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Filiere;
use App\Models\SignatureCachet;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Attestation;
use App\Models\Infoirsbac;

class ReleveController extends Controller
{


    public function index(Request $request)
    {
        try {

            $search = strtolower(trim($request->search ?? ''));

            $type = $request->type;

            /*
        |--------------------------------------------------------------------------
        | Données du formulaire
        |--------------------------------------------------------------------------
        */

            $filieres = Filiere::orderBy('nom')->get();

            $anneesAcademiques = AnneeAcademique::latest()->get();

            /*
        |--------------------------------------------------------------------------
        | Attestations
        |--------------------------------------------------------------------------
        */

            $attestations = Attestation::with('etudiant')

                ->get()

                ->map(function ($attestation) {

                    return [

                        'id' => $attestation->id,

                        'type' => 'Attestation de réussite',
                        'semestre' => null,

                        'matricule' => $attestation->etudiant->matricule,

                        'nom' => $attestation->etudiant->nom,

                        'prenom' => $attestation->etudiant->prenom,

                        'date' => $attestation->created_at,

                        'status' => 'Disponible',

                        'pdf_path' => $attestation->pdf_path,

                        'route_preview' => route(
                            'attestations.preview.admin',
                            $attestation->id
                        ),

                        'route_delete' => route(
                            'attestations.destroy',
                            $attestation->id
                        ),

                    ];
                });

            /*
        |--------------------------------------------------------------------------
        | Relevés
        |--------------------------------------------------------------------------
        */

            $releves = Releve::with('etudiant')

                ->get()

                ->map(function ($releve) {

                    return [

                        'id' => $releve->id,

                        'type' => 'Relevé de notes',
                        'semestre' => $releve->semestre,

                        'matricule' => $releve->etudiant->matricule,

                        'nom' => $releve->etudiant->nom,

                        'prenom' => $releve->etudiant->prenom,

                        'date' => $releve->created_at,

                        'status' => 'Disponible',

                        'pdf_path' => $releve->pdf_path,

                        'route_preview' => route(
                            'releves.preview.admin',
                            $releve->id
                        ),

                        'route_delete' => route(
                            'releves.destroy',
                            $releve->id
                        ),

                    ];
                });

            /*
        |--------------------------------------------------------------------------
        | Fusion
        |--------------------------------------------------------------------------
        */

            $documents = $attestations

                ->concat($releves);

            /*
        |--------------------------------------------------------------------------
        | Recherche
        |--------------------------------------------------------------------------
        */

            if (!empty($search)) {

                $documents = $documents->filter(function ($document) use ($search) {

                    return

                        str_contains(strtolower($document['nom']), $search)

                        ||

                        str_contains(strtolower($document['prenom']), $search)

                        ||

                        str_contains(strtolower($document['matricule']), $search);
                });
            }

            /*
        |--------------------------------------------------------------------------
        | Filtre type
        |--------------------------------------------------------------------------
        */

            if (!empty($type)) {

                $documents = $documents->where('type', $type);
            }

            /*
        |--------------------------------------------------------------------------
        | Tri
        |--------------------------------------------------------------------------
        */

            $documents = $documents

                ->sortByDesc('date')

                ->values();

            /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

            $page = LengthAwarePaginator::resolveCurrentPage();

            $perPage = 10;

            $items = $documents

                ->slice(($page - 1) * $perPage, $perPage)

                ->values();

            $documents = new LengthAwarePaginator(

                $items,

                $documents->count(),

                $perPage,

                $page,

                [

                    'path' => request()->url(),

                    'query' => request()->query(),

                ]

            );

            $totalAttestations = Attestation::count();
            $totalReleves = Releve::count();
            $documentsGeneres = $totalAttestations + $totalReleves;
            $info = Infoirsbac::first();

            return view(

                'admin.generationdoc',

                compact(
                    'info',
                    'filieres',

                    'anneesAcademiques',

                    'documents',
                    'documentsGeneres'

                )

            );
        } catch (\Throwable $e) {

            report($e);

            return redirect()

                ->back()

                ->with(

                    'error',

                    'Une erreur est survenue lors du chargement des documents.'

                );
        }
    }






    public function generer(Request $request)
    {
        $request->validate([


            'filiere_id' => 'required|exists:filieres,id',

            'annee_etude' => 'required',

            'annee_academique_id' => 'required|exists:annees_academiques,id',

            'semestre' => 'required'
        ]);

        $etudiants = Etudiant::where(
            'filiere_id',
            $request->filiere_id
        )
            ->where(
                'annee_etude',
                $request->annee_etude
            )
            ->get();

        if ($etudiants->isEmpty()) {
            return back()->with(
                'error',
                'Aucun étudiant trouvé.'
            );
        }





        $ues = Ue::with('ecues')
            ->where(
                'semestre',
                $request->semestre
            )
            ->get();

        if ($ues->isEmpty()) {
            return back()->with(
                'error',
                'Aucune UE trouvée pour ce semestre.'
            );
        }

        $generes = 0;

        $ignores = 0;

        $erreurs = [];

        foreach ($etudiants as $etudiant) {
            $releveExiste = Releve::where(
                'etudiant_id',
                $etudiant->id
            )
                ->where(
                    'annee_academique_id',
                    $request->annee_academique_id
                )
                ->where(
                    'semestre',
                    $request->semestre
                )
                ->exists();

            if ($releveExiste) {
                $ignores++;

                continue;
            }

            $lignes = [];

            $sommePonderee = 0;

            $totalCredits = 0;

            $creditsValides = 0;

            $notesManquantes = false;

            foreach ($ues as $ue) {
                if ($ue->ecues->count() == 0) {
                    continue;
                }

                $sommeNotesUE = 0;

                $nombreEcues = 0;

                $notesEcue = [];

                foreach ($ue->ecues as $ecue) {
                    $note = Note::where(
                        'etudiant_id',
                        $etudiant->id
                    )
                        ->where(
                            'ecue_id',
                            $ecue->id
                        )
                        ->where(
                            'annee_academique_id',
                            $request->annee_academique_id
                        )
                        ->first();

                    if (!$note) {
                        $notesManquantes = true;

                        break;
                    }

                    $notesEcue[] = [

                        'ecue' => $ecue,

                        'note' => $note->note
                    ];

                    $sommeNotesUE += $note->note;

                    $nombreEcues++;
                }

                if ($notesManquantes) {
                    break;
                }

                $moyenneUE = round(

                    $sommeNotesUE
                        /
                        $nombreEcues,

                    2
                );

                $decisionUE =
                    $moyenneUE >= 10

                    ? 'Validée'

                    : 'Non validée';

                if ($moyenneUE >= 10) {
                    $creditsValides +=
                        $ue->credit;
                }

                $sommePonderee +=
                    (
                        $moyenneUE
                        *
                        $ue->credit
                    );

                $totalCredits +=
                    $ue->credit;

                $lignes[] = [

                    'type' => 'ue',

                    'nom' => $ue->nom,

                    'moyenne' => $moyenneUE,

                    'credit' => $ue->credit,

                    'decision' => $decisionUE
                ];

                foreach ($notesEcue as $ligne) {
                    $lignes[] = [

                        'type' => 'ecue',

                        'nom' =>
                        $ligne['ecue']->nom,

                        'note' =>
                        $ligne['note']
                    ];
                }
            }



            if ($notesManquantes) {
                $erreurs[] =
                    $etudiant->matricule;

                continue;
            }

            $moyenneGenerale = round(

                $sommePonderee
                    /
                    $totalCredits,

                2
            );



            $signature =
                SignatureCachet::get('directeur', 'signature');

            $cachet =
                SignatureCachet::get(
                    'directeur',
                    'cachet'
                );

            $anneeAcademique =
                AnneeAcademique::find(
                    $request->annee_academique_id
                );

$decisionFinale=
   $creditsValides == $totalCredits && $moyenneGenerale >= 10

                ? 'VALIDE'

                : 'REFUSE';
                 
            /*$decisionFinale =
            $moyenneGenerale >= 10

                ? 'VALIDE'

                : 'NON VALIDE';*/
             
            $numero =

                'IRSBAC/' .

                date('Y') .

                '/' .

                str_pad(

                    Releve::count() + 1,

                    5,

                    '0',

                    STR_PAD_LEFT
                );

            $nomPdf =
'Relevé Semestre'. $request->semestre .'_' . $etudiant->matricule
              
                . '.pdf';

            

            $pdf = Pdf::loadView(

                'admin.releves.releve',

                [
                    'anneeAcademique' => $anneeAcademique,
                    'signature' => $signature,
                    'cachet' => $cachet,

                    'etudiant' =>
                    $etudiant,

                    'numero' =>
                    $numero,

                    'semestre' =>
                    $request->semestre,

                    'lignes' =>
                    $lignes,

                    'moyenneGenerale' =>
                    $moyenneGenerale,

                    'creditsValides' =>
                    $creditsValides,

                    'decision' =>
                    $decisionFinale,

                    'cachetPath' => $cachet ? Storage::disk('public')->path($cachet->image_path) : null,
                    'signaturePath' => $signature ? Storage::disk('public')->path($signature->image_path) : null,
                    'nomDirecteur' => $cachet->nom_responsable ?? '',
                ]
            );

            Storage::disk('public')->put(

                '/releves/' .
                    $nomPdf,

                $pdf->output()
            );

            Releve::create([

                'etudiant_id' =>
                $etudiant->id,

                'annee_academique_id' =>
                $request->annee_academique_id,

                'semestre' =>
                $request->semestre,

                'numero' =>
                $numero,

                'pdf_path' =>
                'releves/' .
                    $nomPdf,

                'moyenne' =>
                $moyenneGenerale,

                'credits_valides' =>
                $creditsValides,

                'decision' =>
                $decisionFinale
            ]);

            $generes++;

            
            
        }

        return back()->with(

            'success',

            $generes .

                ' relevés générés | '

                .

                $ignores .

                ' déjà existants | '

                .

                count($erreurs)

                .

                ' étudiants avec notes manquantes'
        );
    }
}
