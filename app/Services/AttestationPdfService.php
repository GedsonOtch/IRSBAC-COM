<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Etudiant;
use App\Models\AttestationTemplate;
use App\Models\SignatureCachet;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class AttestationPdfService
{
    private function dateFrancaise($date)
    {
        $mois = [

            1 => 'Janvier',
            2 => 'Février',
            3 => 'Mars',
            4 => 'Avril',
            5 => 'Mai',
            6 => 'Juin',
            7 => 'Juillet',
            8 => 'Août',
            9 => 'Septembre',
            10 => 'Octobre',
            11 => 'Novembre',
            12 => 'Décembre'
        ];

        $date = Carbon::parse($date);

        return
            $date->day . ' ' .
            $mois[$date->month] . ' ' .
            $date->year;
    }

   

    public function generer(
    Etudiant $etudiant,
    $numero,
    $dateDeliberation,
    $dateDocument,
    

)
{
    $template = AttestationTemplate::first();

    if (!$template) {
    throw new \Exception("Aucun modèle d'attestation n'a été configuré.");
}

if (!$template->pdf_path || !file_exists(storage_path('app/public/' . $template->pdf_path))) {
    throw new \Exception("Le fichier PDF du modèle est introuvable.");
}
    $pdf = new Fpdi();

    /*
    |--------------------------------------------------------------------------
    | Chargement du template
    |--------------------------------------------------------------------------
    */

$pageCount = $pdf->setSourceFile(
    storage_path('app/public/'.$template->pdf_path)
);

    $tpl = $pdf->importPage(1);

    /*
    |--------------------------------------------------------------------------
    | Récupération automatique des dimensions du PDF
    |--------------------------------------------------------------------------
    */

    $size = $pdf->getTemplateSize($tpl);

    

    /*
    |--------------------------------------------------------------------------
    | Création d'une page identique au PDF source
    |--------------------------------------------------------------------------
    */

    $pdf->AddPage(
        $size['orientation'],
        [$size['width'], $size['height']]
    );

    /*  
    |--------------------------------------------------------------------------
    | Insertion du template
    |--------------------------------------------------------------------------
    */

    $pdf->useTemplate(
        $tpl,
        0,
        0,
        $size['width'],
        $size['height']
    );

    /*
    |--------------------------------------------------------------------------
    | Configuration police
    |--------------------------------------------------------------------------
    */

    $pdf->SetFont(
        'Arial',
        'B',
        11
    );

    $pdf->SetTextColor(0, 0, 0);

  /*
|--------------------------------------------------------------------------
| NUMERO
|--------------------------------------------------------------------------
*/

$pdf->SetXY(7, 58.5);
$pdf->Cell(60, 6, $numero, 0, 0, 'C');

$anneeCourte = Carbon::parse($dateDocument)->format('y');

$pdf->SetXY(21, 58.5);
$pdf->Cell(60, 6, $anneeCourte, 0, 0, 'C');

/*
|--------------------------------------------------------------------------
| DATE DELIBERATION
|--------------------------------------------------------------------------
*/

$pdf->SetXY(115, 113.5);
$pdf->Cell(
    0,
    0,
    Carbon::parse($dateDeliberation)->format('d/m/Y'),
    0,
    0,
    'L'
);

/*
|--------------------------------------------------------------------------
| NOM PRENOM
|--------------------------------------------------------------------------
*/
$prenom = $etudiant->prenom;
$prenom = mb_convert_encoding($prenom, 'ISO-8859-1', 'UTF-8');
   
$pdf->SetXY(184, 113.5);
$pdf->Cell(
    0,
    0,
    $etudiant->nom . ' ' . $prenom,
    0,
    0,
    'L'
);

/*
|--------------------------------------------------------------------------
| DATE NAISSANCE
|--------------------------------------------------------------------------
*/

$pdf->SetXY(245, 113.5);
$pdf->Cell(
    0,
    0, 
    Carbon::parse(
        $etudiant->date_naissance
    )->format('d/m/Y'),
    0,
    0,
    'L'
);

/*
|--------------------------------------------------------------------------
| LIEU DE NAISSANCE
|--------------------------------------------------------------------------
*/

$pdf->SetXY(30, 120.2);
$pdf->Cell(
    0,
    0,
    $etudiant->lieu_naissance,
    0,
    0,
    'L'
);

/*
|--------------------------------------------------------------------------
| MATRICULE
|--------------------------------------------------------------------------
*/

$pdf->SetXY(130, 120.2);
$pdf->Cell(
    0,
    0,
    $etudiant->matricule,
    0,
    0,
    'L'
);

/*
|--------------------------------------------------------------------------
| ANNEE ACADEMIQUE entree
|--------------------------------------------------------------------------
*/

$anneeEntree = $etudiant->anneeEntree?->libelle ?? 'Non renseignée';

$pdf->SetXY(205, 120.2);
$pdf->Cell(
    0,
    0,
       mb_convert_encoding($anneeEntree, 'ISO-8859-1', 'UTF-8'),
    0,
    0,
    'L'
);


//filiere

$pdf->SetXY(67.5, 140.8);
$pdf->Cell(
    0,
    0,
    $etudiant->filiere->nom.'.',
    0,
    0,
    'L'
);




 $pdf->SetXY(243,154);

        $pdf->Cell(
            0,
            0,
            $this->dateFrancaise(
                $dateDocument
            ),
            0,
            0,
            'L'
            
            );


            $this->placerSignatureCachet($pdf, 'directeur_etudes', x:25, y:170);
             $this->placerSignatureCachet($pdf, 'directeur', x:230, y:170);
    

    return $pdf;
}

private function placerSignatureCachet(\setasign\Fpdi\Fpdi $pdf, string $fonction, float $x, float $y): void{
$cachet= SignatureCachet::get($fonction, 'cachet');
$signature= SignatureCachet::get($fonction, 'signature');

if($cachet){
    $cachetPath = Storage::disk('public')->path($cachet->image_path);
    $pdf->Image($cachetPath, $x, $y, 25);
}

if($signature){
    $signaturePath = Storage::disk('public')->path($signature->image_path);
    $pdf->Image($signaturePath, $x +10, $y +5, 20);
}

}
}