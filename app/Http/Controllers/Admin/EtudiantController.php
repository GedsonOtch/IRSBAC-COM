<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtudiantRequest;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use App\Models\Filiere;
use App\Models\Infoirsbac;
use Illuminate\Support\Facades\Storage;
use App\Models\Releve;
use App\Models\AnneeAcademique;
class EtudiantController extends Controller
{
    public function create()
    {
$anneesAcademiques = AnneeAcademique::orderByDesc('id')->get();
       $filieres = Filiere::orderBy('nom')->get();
        return view('admin.etudiants.create', compact('filieres', 'anneesAcademiques'));
    }

    public function store(StoreEtudiantRequest $request)
    {
     

        Etudiant::create([
          ...$request->validated(),
            'password' => Hash::make('IRSBAC2026'),
            
        ]);

        return back()->with('success','Etudiant créé avec succès');
    }
  
    
 public function showLogin()
    {
        return view('etudiant.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'matricule' => 'required',
            'password' => 'required'
        ]);



        if (Auth::guard('etudiant')->attempt([
            'matricule' => $request->matricule,
            'password' => $request->password
        ])) {

            $request->session()->regenerate();

            return redirect()->route('etudiant.dashboard');      
        }   

        return back()->withErrors([
            'password' => 'Matricule ou mot de passe incorrect.'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('etudiant')->logout();

     
        return redirect()->route('etudiant.login');
    }



public function updateProfile(Request $request)
{


    $request->validate([
        'telephone' => 'nullable|string|max:20',
        'password' => 'nullable|min:6|confirmed',
    ]);

    
    /** @var \App\Models\Etudiant $etudiant  */
    $etudiant = auth('etudiant')->user();

    // Mise à jour du téléphone
    $etudiant->telephone = $request->telephone;

    // Mise à jour du mot de passe si renseigné
    if($request->filled('password')) {
        $etudiant->password = Hash::make($request->password);
    }

    $etudiant->save();

    return redirect()
            ->route('etudiant.profil')
            ->with('success', 'Profil mis à jour avec succès.');
}




public function index(Request $request)
{
    $query = Etudiant::query();
 $filieres = Filiere::orderBy('nom')->get();
$info = Infoirsbac::first();
    // Recherche par matricule, nom ou prénom
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('matricule', 'like', "%{$search}%")
              ->orWhere('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%");

        });
    }

    // Filtre par filière
   if ($request->filled('filiere')) {
    $query->where('filiere_id', $request->filiere);
}

    // Filtre par année d'étude
    if ($request->filled('annee_etude')) {
        $query->where('annee_etude', $request->annee_etude);
    }

    $etudiants = $query
                    ->latest()
                    ->paginate(5)
                    ->withQueryString();
$nombrEtudiants = Etudiant::count();
$etudiant = new Etudiant();

$anneesAcademiques = AnneeAcademique::orderByDesc('id')->get();
    return view('admin.gestionetudiant', compact( ['etudiants', 'nombrEtudiants', 'filieres','info', 'anneesAcademiques',
    'etudiant']));
}


public function destroy(Etudiant $etudiant)
{
    $etudiant->delete();

    return redirect()
        ->back()
        ->with('success', 'Étudiant supprimé avec succès.');
}




public function update(Request $request, Etudiant $etudiant)
{

     $request->validate([
        'nom' => 'required',
        'prenom' => 'required',
        'telephone' => 'nullable|max:20',
        'filiere' => 'required',
        'annee_etude' => 'required',
        'annee_entree_id' =>
'required|exists:annees_academiques,id',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'est_en_regle' => 'sometimes|boolean'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Gestion de la photo
    |--------------------------------------------------------------------------
    */

    $photoPath = $etudiant->photo;

  $estEnRegle = $request->boolean('est_en_regle');
 
   if ($request->hasFile('photo')) {

        if (
            $etudiant->photo &&
            Storage::disk('public')->exists($etudiant->photo)
        ) {
            Storage::disk('public')->delete($etudiant->photo);
        }

        $photoPath = $request
            ->file('photo')
            ->store(
                'photos-etudiants',
                'public'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Mise à jour
    |--------------------------------------------------------------------------
    */

    
$etudiant->update([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'telephone' => $request->telephone,
        'filiere_id' => $request->filiere, // si tu  stockes l'id de la filière
        'annee_etude' => $request->annee_etude,
        'annee_entree_id' => $request->annee_entree_id,
        'photo' => $photoPath,
        'est_en_regle' => $estEnRegle
        
    ]);


     
    return back()->with(
        'success',
        'Étudiant modifié avec succès.'
    );
}

public function modele(){
$exemples= collect( [
    [
'Matricule' => '2024-33',
'Nom'=> 'EXEMPLE',
'Prénoms' => 'Test',
'Téléphone'=> '95281856',
'Sexe'     => 'Masculin',
'Date_naissance'=> '18/05/2002',
'Lieu_naissance'=> 'Cotonou',
'Filiere' => 'Communication',
'Annee_etude' => '1',
'annee_entree' => '2024-2025'
],

[

'Matricule' => '2024-34',
'Nom'=> 'EXEMPLE',
'Prénoms' => 'Test2',
'Téléphone'=> '95281856',
'Sexe'     => 'Féminin',
'Date_naissance'=> '18/05/1998',
'Lieu_naissance'=> 'Abomey',
'Filiere' => 'Lettres Modernes',
'Annee_etude' => '2',
'annee_entree' => '2024-2025'

],

[

'Matricule' => '2024-35',
'Nom'=> 'EXEMPLE',
'Prénoms' => 'Test3',
'Téléphone'=> '95281856',
'Sexe'     => 'Masculin',
'Date_naissance'=> '18/05/2000',
'Lieu_naissance'=> 'Parakou',
'Filiere' => 'Arts Plastiques',
'Annee_etude' => '3',
'annee_entree' => '2024-2025'

], 
]);



return(new FastExcel($exemples))->download('modele_import_etudiant.xlsx');
}


public function import(Request $request)
{
    $request->validate([
        'excel_file' => 'required|mimes:xlsx,xls'
    ]);

    $rows = (new FastExcel)
        ->import($request->file('excel_file'));

    $importes = 0;
    $ignores = 0;
    $filieresIntrouvables = 0;
$anneeEntreeIntrouvable = 0;
    foreach ($rows as $row)
    {
        // Vérification du matricule
        if (
            Etudiant::where(
                'matricule',
                $row['Matricule']
            )->exists()
        )
        {
            $ignores++;
            continue;
        }

        // Recherche de la filière
        $filiere = Filiere::where(
            'nom',
            trim($row['Filiere'])
        )->first();

        // Si la filière n'existe pas, on ignore l'étudiant
        if (!$filiere)
        {
            $filieresIntrouvables++;
            continue;
        }

$anneeEntree = AnneeAcademique::where(
    'libelle',
    trim($row['annee_entree'])
)->first();
if (!$anneeEntree) {

    $anneeEntreeIntrouvable++;

    continue;
}


        Etudiant::create([
            'matricule'       => $row['Matricule'],
            'nom'             => $row['Nom'],
            'prenom'          => $row['Prénoms'],
            'telephone'       => $row['Téléphone'],
            'sexe'            => $row['Sexe'],
            'password'        => bcrypt('IRSBAC2026'),

            'date_naissance'  => Carbon::createFromFormat(
                'd/m/Y',
                $row['Date_naissance']
            )->format('Y-m-d'),

            'lieu_naissance'  => $row['Lieu_naissance'],
            'filiere_id'      => $filiere->id,
            'annee_etude'     => $row['Annee_etude'],
            'annee_entree_id' => $anneeEntree->id,
        ]);

        $importes++;
    }

    return back()->with(
        'success',
        "{$importes} étudiants importés, {$ignores} ignorés (matricule existant), {$filieresIntrouvables} ignorés (filière introuvable), {$anneeEntreeIntrouvable} ignorés (année académique introuvable)."
    );
}


}