<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Releve;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Etudiant;
use Illuminate\Support\Facades\File;
use App\Models\Attestation;
class EtudiantDocController extends Controller
{
    //

    public function documents()
{
     $etudiant = Auth::guard('etudiant')->user();

    $documents = collect();

    $releves = Releve::where(
        'etudiant_id',
        $etudiant->id
    )
    ->orderBy(
        'semestre'
    )
    ->get();

    foreach($releves as $releve)
    {
        $documents->push([

            'nom' =>
                'Relevé Semestre ' .
                $releve->semestre . ' '. $releve->anneeAcademique->libelle,

            'type' =>
                'Relevé de notes',
                



            'date' =>
                $releve->created_at,

            'preview_route' =>
                route(
                    'etudiant.releve.preview',
                    $releve->id
                ),

            'download_route' =>
                route(
                    'etudiant.releve.download',
                    $releve->id
                )

        ]);
    }


$nbDoc=0;


    if($etudiant->annee_etude == 3)
    {
        $path =
            'attestations/' .'Attestation'.
            $etudiant->matricule .
            '.pdf';

        if(
            Storage::disk('public')
            ->exists($path)
        )
        {
            $documents->push([

                'nom' =>
                    'Attestation de réussite',

                'type' =>
                    'Attestation',

                    

                'date' =>
                    now(),

                'preview_route' =>
                    route(
                        'etudiant.attestation.preview'
                    ),

                'download_route' =>
                    route(
                        'etudiant.attestation.download'
                    )

            ]);
        }

$nbAttestation= Attestation::where('etudiant_id', $etudiant->id)->count();
$nbReleve= Releve::where('etudiant_id', $etudiant->id)->count();

$nbDoc = $nbAttestation + $nbReleve;


    }

    return view(
        'etudiant.docetudiant',
        compact(
            'documents',
            'nbDoc',
            'etudiant'
        )
    );
}



public function previewReleve(
    Releve $releve
)
{
    if(
        $releve->etudiant_id
        !=
        Auth::guard('etudiant')->user()->id
    )
    {
        abort(403);
    }

    return response()->file(

        storage_path(
            'app/public/' .
            $releve->pdf_path
        )

    );
}

public function downloadReleve(
    Releve $releve
)
{
    if(
        $releve->etudiant_id
        !=  Auth::guard('etudiant')->user()->id
        
    )
    {
        abort(403);
    }

    return response()->download(

        storage_path(
            'app/public/' .
            $releve->pdf_path
        )

    );
}


public function previewAttestation()
{
     $etudiant = Auth::guard('etudiant')->user();
    

    $path = storage_path(

        'app/public/attestations/' .'Attestation'.
        $etudiant->matricule .
        '.pdf'

    );

    if(!file_exists($path))
    {
        abort(
            404,
            'Attestation introuvable'
        );
    }

    return response()->file(
        $path
    );
}


public function downloadAttestation()
{
    $etudiant = Auth::guard('etudiant')->user();

    $path = storage_path(
        'app/public/attestations/'. 'Attestation'.
        $etudiant->matricule .
        '.pdf'
    );

    if (!file_exists($path)) {
        abort(404, 'Attestation introuvable');
    }

    return response()->download($path);
}

//preview et supprimer doc coté admin

public function previewAttestationAdmin(Attestation $attestation)
{
    $path = storage_path(
        'app/public/' . $attestation->pdf_path
    );

    abort_unless(file_exists($path), 404);

    return response()->file($path);
}




public function previewReleveAdmin(Releve $releve)
{
    $path = storage_path(
        'app/public/' . $releve->pdf_path
    );

    abort_unless(file_exists($path), 404);

    return response()->file($path);
}





public function destroyAttestation(Attestation $attestation)
{
    $path = storage_path(
        'app/public/' . $attestation->pdf_path
    );

    if (File::exists($path)) {
        File::delete($path);
    }

    $attestation->delete();

    return back()->with(
        'success',
        'Attestation supprimée avec succès.'
    );
}



public function destroyReleve(Releve $releve)
{
    $path = storage_path(
        'app/private/public/' . $releve->pdf_path
    );

    if (File::exists($path)) {
        File::delete($path);
    }

    $releve->delete();

    return back()->with(
        'success',
        'Relevé supprimé avec succès.'
    );
}








}
