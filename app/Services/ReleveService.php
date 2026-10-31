<?php

namespace App\Services;

use App\Models\AnneeAcademique;
use App\Models\Etudiant;
use App\Models\Releve;
use App\Models\SignatureCachet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReleveService
{
    protected CalculNotesService $calculNotes;

    public function __construct(CalculNotesService $calculNotes)
    {
        $this->calculNotes = $calculNotes;
    }

    /**
     * Génération d'une promotion entière
     */
    public function genererPromotion(Request $request): array
    {

        $etudiants = Etudiant::where(
            'filiere_id',
            $request->filiere_id
        )
        ->where( 
            'annee_etude',
            $request->annee_etude
        )
        ->orderBy('nom')
        ->orderBy('prenom')
        ->get();

        if($etudiants->isEmpty())
        {
            throw new \Exception(
                'Aucun étudiant trouvé.'
            );
        }

        $anneeAcademique =
            AnneeAcademique::findOrFail(
                $request->annee_academique_id
            );

        $signature =
            SignatureCachet::where(
                'type',
                'signature'
            )->first();

        $cachet =
            SignatureCachet::where(
                'type',
                'cachet'
            )->first();

        $generes = 0;

        $ignores = 0;

        $erreurs = [];

        DB::beginTransaction();

        try {

            foreach($etudiants as $etudiant)
            {

                $resultat = $this->genererEtudiant(

                    $etudiant,

                    $request->annee_academique_id,

                    $request->semestre,

                    $anneeAcademique,

                    $signature,

                    $cachet

                );

                if($resultat === true)
                {
                    $generes++;
                }
                elseif($resultat === false)
                {
                    $ignores++;
                }

            }

            DB::commit();

        } catch(\Exception $e){

            DB::rollBack();

            throw $e;

        }

        return [

            'generes'=>$generes,

            'ignores'=>$ignores,

            'erreurs'=>$erreurs

        ];

    }
    protected function genererEtudiant(
    Etudiant $etudiant,
    int $anneeAcademiqueId,
    int $semestre,
    AnneeAcademique $anneeAcademique,
    $signature,
    $cachet
)
{

    /*
    |--------------------------------------------------------------------------
    | Déjà généré ?
    |--------------------------------------------------------------------------
    */

    if(

        Releve::where(

            'etudiant_id',

            $etudiant->id

        )

        ->where(

            'annee_academique_id',

            $anneeAcademiqueId

        )

        ->where(

            'semestre',

            $semestre

        )

        ->exists()

    ){

        return false;

    }

    /*
    |--------------------------------------------------------------------------
    | Calcul officiel
    |--------------------------------------------------------------------------
    */

    $calcul =

        $this->calculNotes

        ->calculerSemestre(

            $etudiant->id,

            $etudiant->filiere_id,

            $anneeAcademiqueId,

            $semestre

        );