<?php

namespace App\Http\Controllers\Etudiant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Releve;
use App\Models\Note;
use App\Models\Ue;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Auth;
use App\Models\AnneeAcademique;
use Illuminate\Support\Facades\Storage;

class EtudiantNotesController extends Controller
{
    //
public function index(Request $request)
{
    /*
    |--------------------------------------------------------------------------
    | Étudiant connecté
    |--------------------------------------------------------------------------
    */

    $etudiant = Auth::guard('etudiant')->user();

    /*
    |--------------------------------------------------------------------------
    | Semestre demandé
    |--------------------------------------------------------------------------
    */

    $semestre = $request->get(
        'semestre',
        ($etudiant->annee_etude * 2) - 1
    );

    $maxSemestre = $etudiant->annee_etude * 2;

    if ($semestre > $maxSemestre) {

        return redirect()->route(
            'etudiant.notes',
            [
                'semestre' => $maxSemestre
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Année académique courante
    |--------------------------------------------------------------------------
    */

    $anneeAcademique = AnneeAcademique::latest()->first();

    /*
    |--------------------------------------------------------------------------
    | UE du semestre de la filière
    |--------------------------------------------------------------------------
    */

    $ues = Ue::with([
            'ecues' => function ($query) {
                $query->orderBy('code');
            }
        ])
        ->where('semestre', $semestre)
        ->whereHas('filieres', function ($query) use ($etudiant) {

            $query->where(
                'filieres.id',
                $etudiant->filiere_id
            );

        })
        ->orderBy('code')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Notes de l'étudiant
    |--------------------------------------------------------------------------
    */

    $notes = Note::where(
            'etudiant_id',
            $etudiant->id
        )
        ->where(
            'annee_academique_id',
            $anneeAcademique->id
        )
        ->get()
        ->keyBy('ecue_id');

    /*
    |--------------------------------------------------------------------------
    | Relevé généré
    |--------------------------------------------------------------------------
    */

    $releve = Releve::where(
            'etudiant_id',
            $etudiant->id
        )
        ->where(
            'annee_academique_id',
            $anneeAcademique->id
        )
        ->where(
            'semestre',
            $semestre
        )
        ->first();

    /*
    |--------------------------------------------------------------------------
    | Variables de calcul
    |--------------------------------------------------------------------------
    */

    $creditsTotal = 0;

    $creditsValides = 0;

    $sommePonderee = 0;

    $notesCompletes = true;

    $nombreUE = 0;

    $nombreUEValidees = 0;

    $nombreEcues = 0;

    $nombreNotes = 0;

    /*
    |--------------------------------------------------------------------------
    | Calcul des UE
    |--------------------------------------------------------------------------
    */

    foreach ($ues as $ue) {

        $nombreUE++;

        $creditsTotal += $ue->credit;

        if ($ue->ecues->isEmpty()) {

            $ue->moyenne = null;

            $ue->decision = "Aucune ECUE";

            continue;
        }

        $sommeUE = 0;

        $nbNotesUE = 0;

        foreach ($ue->ecues as $ecue) {

            $nombreEcues++;

            $note = $notes->get($ecue->id);

            if ($note) {

                $ecue->note = $note->note;

                $sommeUE += $note->note;

                $nbNotesUE++;

                $nombreNotes++;

            } else {

                $ecue->note = null;

                $notesCompletes = false;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UE complète
        |--------------------------------------------------------------------------
        */

        if ($nbNotesUE == $ue->ecues->count()) {

            $ue->moyenne = round(
                $sommeUE / $nbNotesUE,
                2
            );

            $sommePonderee +=
                $ue->moyenne
                *
                $ue->credit;

            $ue->decision =
                $ue->moyenne >= 10
                ? "Validée"
                : "Non validée";

            if ($ue->moyenne >= 10) {

                $creditsValides +=
                    $ue->credit;

                $nombreUEValidees++;
            }

        } else {

            $ue->moyenne = null;

            $ue->decision = "En attente";
        }
    }

        /*
    |--------------------------------------------------------------------------
    | Moyenne générale
    |--------------------------------------------------------------------------
    */

    $moyenneGenerale = null;

    $decision = null;

    if ($notesCompletes && $creditsTotal > 0) {

        $moyenneGenerale = round(
            $sommePonderee / $creditsTotal,
            2
        );

        $decision =
        $nombreUEValidees == $nombreUE &&
            $moyenneGenerale >= 10
            ? "VALIDÉ"
            : "REFUSÉ";
    }

    /*
    |--------------------------------------------------------------------------
    | Cas d'affichage
    |--------------------------------------------------------------------------
    */

    $aucuneUE = ($nombreUE == 0);

    $aucuneNote = ($nombreNotes == 0);

    $resultatsComplets =
        !$aucuneUE
        &&
        !$aucuneNote
        &&
        $notesCompletes;

    /*
    |--------------------------------------------------------------------------
    | Vue
    |--------------------------------------------------------------------------
    */

    return view(
        'etudiant.mesnotetud',
        compact(
            'etudiant',
            'semestre',
            'anneeAcademique',

            'ues',
            'notes',
            'releve',

            'moyenneGenerale',
            'creditsValides',
            'creditsTotal',
            'decision',

            'notesCompletes',

            'nombreUE',
            'nombreUEValidees',

            'nombreEcues',
            'nombreNotes',

            'aucuneUE',
            'aucuneNote',
            'resultatsComplets'
        )
    );
}






   

}