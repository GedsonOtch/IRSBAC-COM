<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SignatureCachet;
use Illuminate\Support\Facades\Storage;
use App\Models\AttestationTemplate;
use App\Models\Ue;
use App\Models\Filiere;
use App\Models\AnneeAcademique;
use App\Models\Ecue;
use App\Models\Infoirsbac;

class SignatureCachetController extends Controller
{
    //



public function upload(Request $request)
{
   

    $request->validate([
        'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        'type' => 'required'
    ]);

    $ancienneImage = SignatureCachet::where(
        'type',
        $request->type
    )->first();

    if ($ancienneImage) {

        Storage::disk('public')
            ->delete($ancienneImage->image_path);

        $ancienneImage->delete();
    }

    $path = $request->file('image')
        ->store('signatures', 'public');

    SignatureCachet::create([
        'type' => $request->type,
        'nom_responsable' => $request->type,
        'image_path' => $path
    ]);




$signatureDe = SignatureCachet::where('type', 'signature_de')->first();
$cachetDe = SignatureCachet::where('type', 'cachet_de')->first();
$signatureDirecteur = SignatureCachet::where('type', 'signature_directeur')->first();
$cachetDirecteur = SignatureCachet::where('type', 'cachet_directeur')->first();

return redirect()->route('admin.modele_signature', compact(
    'signatureDe',
    'cachetDe',
    'signatureDirecteur',
    'cachetDirecteur'
));





}








public function index()
{

  $elements = SignatureCachet::latest()->get();
     $template =
            AttestationTemplate::first();

             $ues = Ue::with('filieres')
            ->orderBy('semestre')
            ->get();

            $filieres = Filiere::all();
 $ecues = Ecue::with(
    'ue.filieres'
)->get();

            
    $filieres = Filiere::orderBy('nom')
        ->get();

      $ecues = Ecue::with(
    'ue.filieres'
)->get();

    $annees = AnneeAcademique::orderByDesc('id')
        ->get();

        $info = Infoirsbac::first();
    
    return view('admin.modele_signature', compact(
        'template',
        
        'info',
        
        'filieres',
        'annees',
        
        'elements'
    ));
}




public function delete($type)
{
    $image = SignatureCachet::where(
        'type',
        $type
    )->first();

    if ($image) {

        Storage::disk('public')
            ->delete($image->image_path);

        $image->delete();
    }

    return redirect()->route('admin.modele_signature'
    )->with(
        'success',
        'Image supprimée avec succès.'
    );
}


}
