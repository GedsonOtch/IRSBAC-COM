<?php
namespace App\Http\Controllers\Admin;
use App\Models\Etudiant;
use App\Models\Attestation;
use Illuminate\Http\Request;
use App\Services\AttestationPdfService;
use App\Http\Controllers\Controller;
use App\Models\AttestationTemplate;
use App\Models\Releve;
use App\Models\SignatureCachet;

class AttestationController extends Controller
{
    public function index()
    {
        $attestations =
            Attestation::with('etudiant')
            ->get();

        return view(
            'admin.attestations',
            compact('attestations')
        );
    }
public function generer(Request $request)


{
    $request->validate([

        'date_deliberation' =>
            'required|date',

        'date_document' =>
            'required|date',

       

        'numero_depart' =>
            'required|integer'
    ]);


$template = AttestationTemplate::first();

if (!$template) {
    return back()->with(
        'error',
        "Aucun modèle d'attestation n'a été configuré."
    );
}


    $etudiants =
        Etudiant::where(
            'annee_etude',
            3
        )->get();

    $service =
        new AttestationPdfService();

    $compteur =
        $request->numero_depart;

    foreach($etudiants as $etudiant)
    {

    $releveEtu = Releve::where('etudiant_id', $etudiant->id,)->where('semestre',6)->where('decision','VALIDE');
        if(
            Attestation::where(
                'etudiant_id',
                $etudiant->id
            )->exists()
        )
        {
            continue;
        }

        if(!$releveEtu->exists()){
            continue;
        }

        $numero =
            str_pad(
                $compteur,
                4,
                '0',
                STR_PAD_LEFT
            );

            $cachet = SignatureCachet::where('nom_responsable', 'Directeur')->first();

        $pdf =
            $service->generer(

                $etudiant,

                $numero,
                
            

                $request->date_deliberation,

                $request->date_document,

                
            );

        $nomFichier =
            'attestations/' .
            $etudiant->matricule .
            '.pdf';

        $pdf->Output(
            'F',
            storage_path(
                'app/public/' .
                $nomFichier
            )
        );

        Attestation::create([

            'etudiant_id' =>
                $etudiant->id,

            'numero_attestation' =>
                $numero,

            'pdf_path' =>
                $nomFichier,

            'date_deliberation' =>
                $request->date_deliberation,

            'date_document' =>
                $request->date_document,

           
        ]);

        $compteur++;
    }

    return back()->with(
        'success',
        'Attestations générées avec succès.'
    );
} }