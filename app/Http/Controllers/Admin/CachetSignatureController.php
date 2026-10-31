<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SignatureCachet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SecuritySetting;
use App\Models\Admin;
use App\Models\AttestationTemplate;
use App\Models\AnneeAcademique;
use App\Models\Ecue;
use App\Models\Ue;
use App\Models\Filiere;
use App\Models\Infoirsbac;

class CachetSignatureController extends Controller
{
    //

    public function index()
{

 $template =
            AttestationTemplate::first();

    $elements = SignatureCachet::latest()->get();

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
$info = Infoirsbac::first();
    $annees = AnneeAcademique::orderByDesc('id')
        ->get();

    return view('admin.modele_signature', compact('elements','template','annees','ecues','filieres','ues','info'));
}



/*public function store(Request $request)
{
    $request->validate([
        'type' => 'required|in:signature,cachet',
        'nom_responsable' => 'required|string|max:255',
        'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048'
    ]);

    $path = $request->file('image')->store(
        'signatures_cachets',
        'public'
    );

    SignatureCachet::create([
        'type' => $request->type,
        'nom_responsable' => $request->nom_responsable,
        'image_path' => $path
    ]);

    return redirect()
        ->route('signature-cachets.index')
        ->with('success', 'Image enregistrée');
}*/

























public function store(Request $request)
{
    $validated = $request->validate([
        'directeur_nom' => 'nullable|string|max:255',
        'directeur_signature' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        'directeur_cachet' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',

        'directeur_etudes_nom' => 'nullable|string|max:255',
        'directeur_etudes_signature' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
        'directeur_etudes_cachet' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
    ], [
        'mimes' => 'Le fichier doit être une image (png, jpg, jpeg).',
        'max' => 'Le fichier ne doit pas dépasser 2 Mo.',
    ]);

    // Vérifie qu'au moins un fichier a été envoyé
    if (!$request->hasAny([
        'directeur_signature', 'directeur_cachet',
        'directeur_etudes_signature', 'directeur_etudes_cachet',
    ])) {
        return back()->withErrors(['fichier' => 'Veuillez importer au moins un fichier.']);
    }

    foreach (['directeur', 'directeur_etudes'] as $fonction) {
        foreach (['signature', 'cachet'] as $type) {
            $fileField = "{$fonction}_{$type}";

            if ($request->hasFile($fileField)) {
                // Supprime l'ancien fichier s'il existe, pour éviter les orphelins
                $existing = SignatureCachet::get($fonction, $type);
                if ($existing) {
                    Storage::disk('public')->delete($existing->image_path);
                }

                $path = $request->file($fileField)->store("signatures/{$fonction}", 'public');

                SignatureCachet::updateOrCreate(
                    ['fonction' => $fonction, 'type' => $type],
                    [
                        'nom_responsable' => $request->input("{$fonction}_nom"),
                        'image_path' => $path,
                    ]
                );
            }
        }
    }

    return back()->with('success', 'Signatures et cachets enregistrés.');
}







public function update(Request $request, $id)
{
    $element = SignatureCachet::findOrFail($id);

    $validated = $request->validate([
        'type'            => 'required|in:signature,cachet',
        'nom_responsable' => 'required|string|max:255',
        'fonction'        => 'required|string|max:255',
        'image'           => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
    ]);

    // Nouvelle image : on supprime l'ancienne et on stocke la nouvelle
    if ($request->hasFile('image')) {
        if ($element->image_path) {
            Storage::disk('public')->delete($element->image_path);
        }
        $validated['image_path'] = $request->file('image')->store('signatures-cachets', 'public');
    }

    unset($validated['image']);
    $element->update($validated);

    return back()->with('success', 'Élément modifié avec succès.');
}






public function destroy($id)
{
    $element = SignatureCachet::findOrFail($id);

    if(Storage::disk('public')->exists($element->image_path))
    {
        Storage::disk('public')->delete($element->image_path);
    }

    $element->delete();

    return redirect()
        ->route('signature-cachets.index')
        ->with('success', 'Élément supprimé avec succès.');
}

}
