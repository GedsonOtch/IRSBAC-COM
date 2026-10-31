<?php

namespace App\Services;

use App\Models\Ue;
use App\Models\Note;

class CalculNotesService
{
    /**
     * Calcule toutes les données d'un semestre
     */
    public function calculerSemestre(
        int $etudiantId,
        int $filiereId,
        int $anneeAcademiqueId,
        int $semestre
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Récupération des UE
        |--------------------------------------------------------------------------
        */

        $ues = Ue::with('ecues')

            ->where('semestre', $semestre)

            ->whereHas('filieres', function ($query) use ($filiereId) {

                $query->where('filieres.id', $filiereId);

            })

            ->orderBy('code')

            ->get();

        if ($ues->isEmpty()) {

            throw new \Exception(
                "Aucune UE trouvée pour le semestre {$semestre}."
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Initialisation
        |--------------------------------------------------------------------------
        */

        $lignes = [];

        $creditsTotal = 0;

        $creditsValides = 0;

        $sommePonderee = 0;

        $notesManquantes = [];

        /*
        |--------------------------------------------------------------------------
        | Parcours des UE
        |--------------------------------------------------------------------------
        */

        foreach ($ues as $ue) {

            if ($ue->ecues->isEmpty()) {

                continue;

            }

            $notes = [];

            $notesEcue = [];

            $sommeUE = 0;

            $nombreEcue = 0;
                        foreach ($ue->ecues as $ecue) {

                $note = Note::where(

                    'etudiant_id',

                    $etudiantId

                )

                ->where(

                    'ecue_id',

                    $ecue->id

                )

                ->where(

                    'annee_academique_id',

                    $anneeAcademiqueId

                )

                ->first();

                if (!$note) {

                    $notesManquantes[] = $ecue->nom;

                    continue;

                }

                $ecue->note = $note->note;

                $notes[] = $note->note;

                $notesEcue[] = [

                    'ecue' => $ecue,

                    'note' => $note->note

                ];

                $sommeUE += $note->note;

                $nombreEcue++;

            }

            /*
            |--------------------------------------------------------------------------
            | Notes manquantes
            |--------------------------------------------------------------------------
            */

            if ($nombreEcue != $ue->ecues->count()) {

                throw new \Exception(

                    "Notes manquantes : "

                    .

                    implode(", ", $notesManquantes)

                );

            }

            /*
            |--------------------------------------------------------------------------
            | Moyenne UE
            |--------------------------------------------------------------------------
            */

            $moyenneUE = round(

                $sommeUE /

                $nombreEcue,

                2

            );

            $validee =

                $moyenneUE >= 10;

            if ($validee) {

                $creditsValides +=

                    $ue->credit;

            }

            $creditsTotal +=

                $ue->credit;

            $sommePonderee +=

                (

                    $moyenneUE

                    *

                    $ue->credit

                );

                            /*
            |--------------------------------------------------------------------------
            | Ligne UE
            |--------------------------------------------------------------------------
            */

            $lignes[] = [

                'type' => 'ue',

                'nom' => $ue->nom,

                'moyenne' => $moyenneUE,

                'credit' => $ue->credit,

                'decision' =>

                    $validee

                    ?

                    'Validée'

                    :

                    'Non validée'

            ];

            /*
            |--------------------------------------------------------------------------
            | Lignes ECUE
            |--------------------------------------------------------------------------
            */

            foreach ($notesEcue as $ligne) {

                $lignes[] = [

                    'type' => 'ecue',

                    'nom' =>

                        $ligne['ecue']->nom,

                    'note' =>

                        $ligne['note']

                ];

            }

            /*
            |--------------------------------------------------------------------------
            | Sauvegarde sur l'objet UE
            |--------------------------------------------------------------------------
            */

            $ue->moyenne = $moyenneUE;

            $ue->validee = $validee;

        }

                $moyenneGenerale = round(

            $sommePonderee /

            $creditsTotal,

            2

        );

        return [

            'ues' => $ues,

            'lignes' => $lignes,

            'moyenne' => $moyenneGenerale,

            'credits_valides' => $creditsValides,

            'credits_total' => $creditsTotal,

            'decision' =>

                $moyenneGenerale >= 10

                ?

                'VALIDE'

                :

                'AJOURNE'

        ];

    }

}