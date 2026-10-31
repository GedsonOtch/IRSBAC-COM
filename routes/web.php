<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EtudiantController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ParametreAdmincontroller;
use App\Http\Controllers\Admin\SignatureCachetController;
use App\Models\Etudiant;
use App\Http\Controllers\Admin\SecuritySettingController;
use App\Http\Controllers\Admin\InfoIrsbacController;
use App\Http\Controllers\Admin\AttestationTemplateController;
use App\Http\Controllers\Admin\AttestationController;
use App\Http\Controllers\Admin\CachetSignatureController;
use App\Models\Attestation;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UeController;
use App\Http\Controllers\Admin\EcueController;
use App\Http\Controllers\Admin\ImportNoteController;
use App\Http\Controllers\Admin\ReleveController;
use App\Http\Controllers\Admin\EtudiantDocController;
use App\Http\Controllers\Admin\FichierDelibController;
use App\Http\Controllers\Admin\AnneeController;
use App\Http\Controllers\Admin\AttestationController as AdminAttestationController;
use App\Models\Filiere;
use App\Models\AnneeAcademique;
use App\Http\Controllers\Etudiant\EtudiantNotesController;
use App\Models\Releve;
use App\Models\Ue;
use App\Models\Infoirsbac;
use App\Http\Controllers\Admin\AtestaController;
Route::get('/', function () {
    return view('welcome');
});



Route::get('/admin/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/admin/login', [AuthController::class, 'login'])
    ->name('admin.login.submit');

Route::middleware('auth:admin')->group(function () {

    Route::get('/admin/dashboard', function () {

        $nombreEtudiants = Etudiant::count();
 $releves = Releve::with('etudiant')
    ->latest()
    ->take(5)
    ->get()
    ->map(function ($item) {
        $item->type = 'Relevé';
        return $item;
    });

$attestations = Attestation::with('etudiant')
    ->latest()
    ->take(5)
    ->get()
    ->map(function ($item) {
        $item->type = 'Attestation';
        return $item;
    });

$derniersDocuments = $releves
    ->merge($attestations)
    ->sortByDesc('created_at')
    ->take(5);
$totalAttestations = Attestation::count();
$totalReleves = Releve::count();
$documentsGeneres = $totalAttestations + $totalReleves;
$info = Infoirsbac::first();
        return view('admin.dashboard', compact('nombreEtudiants','derniersDocuments','documentsGeneres','info'));
    })->name('admin.dashboard');


    Route::post('/admin/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');
});



Route::prefix('admin/notes')->middleware('auth:admin')->group(function () {
    Route::get('/modele', [ImportNoteController::class, 'formulaireModele'])->name('imports.create');
     Route::get('/modele/telecharger', [ImportNoteController::class, 'modele'])->name('notes.modele');
      Route::post('/import', [ImportNoteController::class, 'import'])->name('notes.import');
});

Route::middleware('auth:admin')->group(function () {






    Route::get(
        '/admin/gestionetudiant',
        [EtudiantController::class, 'index']
    )->name('admin.gestionetudiant');

    


    Route::get(
        '/admin/generationdoc',
        [ReleveController::class, 'index']
    )->name('admin.generationdoc');


    Route::get(
        '/admin/parametres',
        [ParametreAdmincontroller::class, 'index']
    )->name('admin.parametres');

// gestion des membres admins
    Route::put('/admins/{admin}', [ParametreAdmincontroller::class, 'update'])
        ->name('admins.update');

    Route::delete('/admins/{admin}', [ParametreAdmincontroller::class, 'destroy'])
        ->name('admins.destroy');

//gestion parametres université
    Route::get(
        '/admin/parametres',
        [InfoIrsbacController::class, 'index']
    )->name('admin.parametres');

    Route::post(
        '/admin/parametres/update',
        [InfoIrsbacController::class, 'update']
    )->name('admin.parametres.update');


    Route::post(
        '/admin/security-settings',
        [SecuritySettingController::class, 'update']
    )->name('security.update');



    Route::get(
        '/modele-signature',
        [SignatureCachetController::class, 'index']
    )->name('admin.modele_signature');






    /* generation des attestations */
Route::post('/generer', [AtestaController::class, 'generer'])->name('generer');






/* gestion annee academique */

    Route::post('/annees', [AnneeController::class, 'store'])->name('annees.store');



/*Gestion des etudiants par admins */



Route::get('/documents/verifier/{token}', function ($token) {
    return "Document : ".$token;
})->name('documents.verify');


 Route::post(
        '/admin/gestionetudiant',
        [EtudiantController::class, 'store']
    )
        ->name('etudiants.store');

    //Importation des etudiants depuis fichier excel

Route::get('/admin/etudiant/modele', [EtudiantController::class, 'modele'])->name('etudiants.modele');


    Route::post(
        '/deliberation/fichier',
        [FichierDelibController::class, 'generer']
    )->name('deliberation.generer');

    Route::post(
        '/admin/import',
        [EtudiantController::class, 'import']
    )->name('admin.import');

    Route::delete(
        '/admin/etudiants/{etudiant}',
        [EtudiantController::class, 'destroy']
    )->name('etudiants.destroy');


    Route::put(
        '/admin/etudiants/{etudiant}',
        [EtudiantController::class, 'update']
    )->name('etudiants.update');




    Route::post(
        '/documents/upload',
        [SignatureCachetController::class, 'upload']
    )
        ->name('documents.upload');

    Route::delete(
        '/documents/delete/{type}',
        [SignatureCachetController::class, 'delete']
    )
        ->name('documents.delete');


    Route::post(
        '/admins/store',
        [AuthController::class, 'store']
    )->name('admins.store');

    // gestion des modeles d'atestation

    Route::get(
        '/admin/templates',
        [AttestationTemplateController::class, 'index']
    )->name('templates.index');

    Route::post(
        '/admin/templates',
        [AttestationTemplateController::class, 'store']
    )->name('templates.store');

    Route::delete(
        '/admin/templates',
        [AttestationTemplateController::class, 'destroy']
    )->name('templates.destroy');


    //gestion des ue pour relevés de notes

    Route::resource(
        'ues',
        UeController::class
    );

    Route::resource(
        'ecues',
        EcueController::class
    );


/* gestion de l'importation des notes   
    Route::get(
        '/imports',
        [ImportNoteController::class, 'create']
    )->name('imports.create');


    Route::post(
        '/imports/notes',
        [ImportNoteController::class, 'store']
    )->name('notes.import.store');*/


    // gestion de cachet et signature de Directeur
    Route::resource('signature-cachets', CachetSignatureController::class);

    
 /*Gestion des attestations des etudiants*/

    Route::get(
        '/admin/attestations/{attestation}/preview',
        [EtudiantDocController::class, 'previewAttestationAdmin']
    )->name('attestations.preview.admin');

    Route::delete(
        '/admin/attestations/{attestation}',
        [EtudiantDocController::class, 'destroyAttestation']
    )->name('attestations.destroy');


 /*Gestion des relevés*/

    Route::get(
        '/admin/releves/{releve}/preview',
        [EtudiantDocController::class, 'previewReleveAdmin']
    )->name('releves.preview.admin');

    Route::delete(
        '/admin/releves/{releve}',
        [EtudiantDocController::class, 'destroyReleve']
    )->name('releves.destroy');
});


Route::get('/admin/attestations', function () {
    return view('admin.attestation');
})->name('attestations.index');

Route::post(
    '/admin/attestations/generer',
    [AttestationController::class, 'generer']
)->name('attestations.generer');


/* gestion generation relevé */
Route::get(
    '/releves',
    [ReleveController::class, 'index']
)->name('releves.index');

Route::post(
    '/releves/generer',
    [ReleveController::class, 'generer']
)->name('releves.generer');



/* Authentification Etudiant */

Route::get(
    '/etudiant/login',
    [EtudiantController::class, 'showLogin']
)
    ->name('etudiant.login');

Route::post(
    '/etudiant/login',
    [EtudiantController::class, 'login']
)
    ->name('etudiant.login.submit');

Route::post(
    '/etudiant/logout',
    [EtudiantController::class, 'logout']
)
    ->name('etudiant.logout');


Route::middleware(['etudiant.auth', 'maintenance.mode'])->group(function () {

    Route::get('/etudiant/dashboard', function () {

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
                $releve->semestre . ' 2025-2026',

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





    if($etudiant->annee_etude == 3)
    {
        $path =
            'attestations/' .
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
    }





        $anneeAcademique = AnneeAcademique::latest('id')->first();
        $anneeEtude = max(1, min(3, (int) $etudiant->annee_etude));
        $semestreActuel = ($anneeEtude * 2) - 1;

        $relevesParSemestre = Releve::where('etudiant_id', $etudiant->id)
            ->orderByDesc('annee_academique_id')
            ->orderByDesc('created_at')
            ->get()
            ->unique('semestre')
            ->keyBy('semestre');

        $uesParSemestre = Ue::with([
            'ecues.notes' => function ($query) use ($etudiant, $anneeAcademique) {
                $query->where('etudiant_id', $etudiant->id)
                    ->where('annee_academique_id', $anneeAcademique?->id);
            },
        ])
            ->whereHas('filieres', function ($query) use ($etudiant) {
                $query->where('filieres.id', $etudiant->filiere_id);
            })
            ->orderBy('semestre')
            ->get()
            ->groupBy('semestre');

        $semestres = collect(range(1, 6))->mapWithKeys(function ($semestre) use ($uesParSemestre, $relevesParSemestre) {
            $ues = $uesParSemestre->get($semestre, collect());
            $creditsTotal = $ues->sum('credit');
            $creditsValidesCalcul = 0;
            $sommePonderee = 0;
            $creditsAvecNotes = 0;
            $toutesLesNotesSontSaisies = $ues->isNotEmpty();

            foreach ($ues as $ue) {
                $ecues = $ue->ecues;
                $notes = $ecues->map(fn ($ecue) => $ecue->notes->first())->filter();

                if ($ecues->isEmpty() || $notes->count() !== $ecues->count()) {
                    $toutesLesNotesSontSaisies = false;
                    continue;
                }

                $moyenneUe = $notes->avg('note');
                $sommePonderee += $moyenneUe * $ue->credit;
                $creditsAvecNotes += $ue->credit;

                if ($moyenneUe >= 10) {
                    $creditsValidesCalcul += $ue->credit;
                }
            }

            $releve = $relevesParSemestre->get($semestre);
            $aDesResultats = $releve !== null || $creditsAvecNotes > 0;

            return [$semestre => [
                'moyenne' => $releve?->moyenne ?? ($creditsAvecNotes > 0 ? round($sommePonderee / $creditsAvecNotes, 2) : null),
                'credits_total' => $creditsTotal,
                'credits_valides' => $releve?->credits_valides ?? $creditsValidesCalcul,
                'a_des_resultats' => $aDesResultats,
                'est_complet' => $releve !== null || ($toutesLesNotesSontSaisies && $creditsTotal > 0),
            ]];
        });

        $semestresEvalues = $semestres->filter(fn ($resultat) => $resultat['a_des_resultats']);
        $moyenneGenerale = $semestresEvalues->isNotEmpty()
            ? round($semestresEvalues->avg('moyenne'), 2)
            : null;
        $creditsTotaux = $uesParSemestre
            ->filter(fn ($ues, $semestre) => $semestre <= $semestreActuel)
            ->flatten(1)
            ->sum('credit');
        $creditsValides = $semestres
            ->filter(fn ($resultat, $semestre) => $semestre <= $semestreActuel)
            ->sum('credits_valides');
        $anneesProgression = collect(range(1, 3))->map(function ($annee) use ($semestres, $anneeEtude) {
            $premierSemestre = ($annee * 2) - 1;
            $secondSemestre = $annee * 2;
            $nombreSemestresEvalues = collect([$semestres->get($premierSemestre), $semestres->get($secondSemestre)])
                ->where('a_des_resultats', true)
                ->count();
            $moyenne1 = $semestres->get($premierSemestre)['moyenne'];
            $moyenne2 = $semestres->get($secondSemestre)['moyenne'];

            if ($moyenne1 !== null && $moyenne2 !== null) {
                $statut = $moyenne1 >= 10 && $moyenne2 >= 10 ? 'Validée' : 'À reprendre';
            } elseif ($nombreSemestresEvalues > 0) {
                $statut = 'En cours';
            } else {
                $statut = $annee < $anneeEtude ? 'En attente' : ($annee === $anneeEtude ? 'En cours' : 'À venir');
            }

            return [
                'annee' => $annee,
                'pourcentage' => $nombreSemestresEvalues * 50,
                'statut' => $statut,
                'moyenne1' => $moyenne1,
                'moyenne2' => $moyenne2,
            ];
        });

        return view('etudiant.dashboard', compact(
            'anneeAcademique',
            'anneeEtude',
            'anneesProgression',
            'creditsTotaux',
            'creditsValides',
            'moyenneGenerale',
            'semestreActuel'
        ));
    })->name('etudiant.dashboard');


    Route::get('/etudiant/profil', function () {

        return view('etudiant.profil');
    })->name('etudiant.profil');

/*  Accès de l'etudiant a ces notes*/
    Route::get('/etudiant/notes', function () {

        return view('etudiant.mesnotetud');
    })->name('etudiant.notes');


    Route::get(
        '/etudiant/notes',
        [EtudiantNotesController::class, 'index']
    )->name('etudiant.notes');



    Route::get('/etudiant/telechargerdoc', function () {


        $etudiant = Auth::guard('etudiant')->user();

        $attestation = Attestation::where(
            'etudiant_id',
            $etudiant->id
        )->first();
        return view('etudiant.telechargedocetd', compact('attestation', 'etudiant'));
    })->name('etudiant.telechargedocument');




    Route::post(
        '/etudiant/profil/update',
        [EtudiantController::class, 'updateProfile']
    )->name('etudiant.profile.update');



    Route::get(
        '/etudiant/documents',
        [EtudiantDocController::class, 'documents']
    )->name(
        'etudiant.documents'
    );


    Route::get(
        '/etudiant/releve/{releve}/preview',
        [EtudiantDocController::class, 'previewReleve']
    )->name(
        'etudiant.releve.preview'
    );

    Route::get(
        '/etudiant/releve/{releve}/download',
        [EtudiantDocController::class, 'downloadReleve']
    )->name(
        'etudiant.releve.download'
    );

    Route::get(
        '/etudiant/attestation/preview',
        [EtudiantDocController::class, 'previewAttestation']
    )->name(
        'etudiant.attestation.preview'
    );

    Route::get(
        '/etudiant/attestation/download',
        [
            EtudiantDocController::class,
            'downloadAttestation'
        ]
    )->name(
        'etudiant.attestation.download'
    );
});




use setasign\Fpdi\Fpdi;

Route::get('/test-coordonnees', function () {

    $templatePath = storage_path(
        'app/public/attestations/6s5Yk0x2P7UM0bICRsGLKVsyeoFPZUri8w4wfqVw.pdf'
    );

    $pdf = new Fpdi();

    $pdf->setSourceFile($templatePath);

    $tpl = $pdf->importPage(1);

    $size = $pdf->getTemplateSize($tpl);

    $pdf->AddPage(
        $size['orientation'],
        [$size['width'], $size['height']]
    );

    $pdf->useTemplate(
        $tpl,
        0,
        0,
        $size['width'],
        $size['height']
    );

    $pdf->SetAutoPageBreak(false);

    /*
    |--------------------------------------------------------------------------
    | Informations PDF
    |--------------------------------------------------------------------------
    */

    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->SetTextColor(255, 0, 0);

    $pdf->SetXY(10, 10);

    $pdf->Cell(
        120,
        8,
        "PDF : {$size['width']} x {$size['height']}"
    );

    /*
    |--------------------------------------------------------------------------
    | Grille horizontale
    |--------------------------------------------------------------------------
    */

    for ($y = 0; $y <= $size['height']; $y += 5) {

        $pdf->SetDrawColor(220, 100, 100);

        $pdf->Line(
            0,
            $y,
            $size['width'],
            $y
        );

        if ($y % 10 == 0) {

            $pdf->SetFont(
                'Helvetica',
                'B',
                5
            );

            $pdf->SetTextColor(
                200,
                0,
                0
            );

            $pdf->SetXY(
                1,
                $y + 0.5
            );

            $pdf->Cell(
                10,
                3,
                "Y=$y"
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Grille verticale
    |--------------------------------------------------------------------------
    */

    for ($x = 0; $x <= $size['width']; $x += 5) {

        $pdf->SetDrawColor(
            100,
            100,
            220
        );

        $pdf->Line(
            $x,
            0,
            $x,
            $size['height']
        );

        if ($x % 10 == 0) {

            $pdf->SetFont(
                'Helvetica',
                'B',
                4
            );

            $pdf->SetTextColor(
                0,
                0,
                200
            );

            foreach ([20, 50, 80, 110, 140, 170, 200] as $yy) {

                $pdf->SetXY(
                    $x + 0.5,
                    $yy
                );

                $pdf->Cell(
                    10,
                    3,
                    "X=$x"
                );
            }
        }
    }

    return response(
        $pdf->Output('', 'S'),
        200,
        [
            'Content-Type' => 'application/pdf'
        ]
    );
});



Route::get('/test-remplissage', function () {

    $templatePath = storage_path('app/public/attestations/rIz0tAGK5IiuU0aiQ6nZY2Iozq7zDdJaaimLE6Fq.pdf');

    $pdf = new \setasign\Fpdi\Fpdi('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(false);

    $pdf->setSourceFile($templatePath);
    $tpl = $pdf->importPage(1);

    $pdf->AddPage('P', 'A4');
    $pdf->useTemplate($tpl, 0, 0, 210, 297);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetXY(171, 218.5);
    $pdf->Cell(0, 0, '20 juillet 2026', 0, 0, 'L');


    $pdf->SetXY(22, 88);
    $pdf->Cell(0, 0, '005', 0, 0, 'L');

    $pdf->SetXY(33, 88);
    $pdf->Cell(0, 0, '26', 0, 0, 'L');


    // Date → x=75, y=163
    $pdf->SetXY(81, 161);
    $pdf->Cell(0, 0, '15/03/2026', 0, 0, 'L');

    // Nom/Prénom → x=103, y=163
    $pdf->SetXY(130, 161);
    $pdf->Cell(0, 0, 'KOUASSI Baptiste', 0, 0, 'L');

    // Naissance → x=103, y=163
    $pdf->SetXY(172, 161);
    $pdf->Cell(0, 0, '01/01/2006', 0, 0, 'L');

    // lieu naissance → x=103, y=163
    $pdf->SetXY(22, 171);
    $pdf->Cell(0, 0, 'kandi', 0, 0, 'L');

    // matricule → x=103, y=163
    $pdf->SetXY(90, 171);
    $pdf->Cell(0, 0, '2022-035', 0, 0, 'L');

    // annee académique → x=103, y=163
    $pdf->SetXY(144, 171);
    $pdf->Cell(0, 0, '2025-2026', 0, 0, 'L');

    $pdfContent = $pdf->Output('', 'S');

    return response($pdfContent, 200, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="test_remplissage.pdf"',
        'Content-Length'      => strlen($pdfContent),
    ]);
});
