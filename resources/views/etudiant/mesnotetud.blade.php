<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Notes - IRSBAC</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/400.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/500.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/600.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/700.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>


    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .tab-active {
            border-bottom: 2px solid #2563eb;
            color: #2563eb;
            font-weight: 600;
        }

        .tab-inactive {
            border-bottom: 2px solid transparent;
            color: #6b7280;
        }

        .tab-inactive:hover {
            color: #374151;
            border-bottom-color: #d1d5db;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-primary-900 text-white z-40 sidebar-transition transform -translate-x-full lg:translate-x-0 flex flex-col">
        <div class="p-6 flex items-center gap-3 border-b border-primary-800">
           <img src="{{asset('storage/logo_irsbac/logo.png')}}" alt="IRSBAC Logo" class="w-13 h-13 object-contain  rounded-lg p-1">
            <div>
                  <h1 class="text-lg font-bold tracking-wide">IRSBAC</h1>
                <p class="text-xs text-blue-200">Espace Étudiant</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
            <a href="{{ route('etudiant.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
 Tableau de bord
            </a>
            <a href="{{ route('etudiant.profil') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg> Mon Profil
            </a>
            <a href="{{ route('etudiant.documents') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
 Mes Documents
            </a>
            <a href="{{ route('etudiant.notes') }}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium  ">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
              Mes Notes
            </a>
          
        </nav>
        <div class="p-4 border-t border-primary-800">
                     <form action="{{ route('etudiant.logout') }}"
      method="POST">

    @csrf
            <button type="submit" class="flex items-center gap-3 px-4 py-3 text-red-300 hover:bg-red-500/20 hover:text-red-100 rounded-lg transition-colors">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
 Déconnexion
            </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-20">
            <div class="flex items-center justify-between px-4 lg:px-8 py-4">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
                        <i data-lucide="menu" class="w-6 h-6 text-gray-600"></i>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Mes Notes et Relevés</h2>
                        <p class="text-sm text-gray-500">Consultez vos résultats académiques par semestre</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-gray-900">{{$etudiant->nom}} {{$etudiant->prenom}}</p>
                        <p class="text-xs text-gray-500">Mat: {{$etudiant->matricule}}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                          <img src="{{ auth()->guard('etudiant')->user()->photo_url }}" alt="" class="w-9 h-9 rounded-full object-cover border-2 border-primary-100">
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-6">

            <!-- Global Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 fade-in">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg"><i data-lucide="trending-up" class="w-6 h-6 text-primary-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Moyenne Générale</p>

                        <div class="text-3xl font-bold text-slate-800 mt-2">

                            @if($moyenneGenerale !== null)

                            {{ number_format($moyenneGenerale,2) }}/20

                            @elseif($notes->isEmpty())

                            --

                            @else

                            En attente

                            @endif

                        </div>

                        <p class="text-sm text-slate-500 mt-2">

                            @if($moyenneGenerale !== null)

                            Moyenne calculée

                            @elseif($notes->isEmpty())

                            Aucune note disponible

                            @else

                            Notes incomplètes

                            @endif

                        </p>


                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 rounded-lg"><i data-lucide="award" class="w-6 h-6 text-emerald-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Crédits Validés</p>
                        <div class="text-3xl font-bold text-slate-800 mt-2">

                            {{ $creditsValides }}

                            /

                            {{ $creditsTotal }}

                        </div>

                        <p class="text-sm text-slate-500 mt-2">

                            @if($creditsTotal>0)

                            {{ round(($creditsValides/$creditsTotal)*100) }} %

                            des crédits obtenus

                            @else

                            Aucun crédit disponible

                            @endif

                        </p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-amber-50 rounded-lg"><i data-lucide="layers" class="w-6 h-6 text-amber-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Niveau Actuel</p>
                        <div class="text-2xl font-bold text-slate-800 mt-2">

                            {{ $etudiant->annee_etude }}ème Année

                        </div>

                        <p class="text-sm text-slate-500 mt-2">

                            @switch($etudiant->annee_etude)

                            @case(1)

                            Licence 1

                            @break

                            @case(2)

                            Licence 2

                            @break

                            @case(3)

                            Licence 3

                            @break

                            @default

                            Niveau inconnu

                            @endswitch

                        </p>
                    </div>
                </div>
            </div>

            <!-- Semester Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 fade-in" style="animation-delay: 0.1s;">
                <div class="border-b border-gray-200 overflow-x-auto scrollbar-hide">
                    <div class="flex min-w-max" id="">
                        @php
                        $semestres = [1,2,3,4,5,6];
                        @endphp

                        <div class="flex gap-2 mb-6">

                            @foreach($semestres as $s)

                            <a

                                href="{{ route('etudiant.notes',['semestre'=>$s]) }}"

                                class="px-5 py-2 rounded-lg font-medium transition

{{ $semestre == $s
    ? 'bg-primary-900 text-white'
    : 'bg-white border border-slate-300 hover:bg-slate-100'
}}">

                                Semestre {{ $s }}

                            </a>

                            @endforeach

                        </div>


                        <!-- Tabs injected by JS -->
                    </div>
                </div>

                <!-- Semester Content -->


                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                    <!-- Header -->
                    <div class="flex items-start justify-between p-6 border-b">

                        <div>

                            <h2 class="text-3xl font-bold text-slate-900">

                                Relevé de Notes - Semestre {{ $semestre }}

                            </h2>

                            <p class="mt-2 text-slate-500 text-lg">

                                {{ $etudiant->annee_etude }}ème année •

                                {{ $etudiant->filiere->nom }} •

                                Année Universitaire

                                {{ $anneeAcademique->libelle }}

                            </p>

                        </div>

                        @if($releve && $etudiant->est_en_regle)

                   <a href="{{ route('etudiant.releve.download', $releve) }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-white font-semibold hover:bg-blue-700 transition"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg> Télécharger le PDF </a>

                        @endif

                    </div>

                    <!-- Informations étudiant -->

                    <div class="p-6">

                        <div class="grid grid-cols-4 border rounded-xl overflow-hidden">

                            <div class="border-r p-5">

                                <p class="uppercase text-xs tracking-wider text-slate-500">

                                    Nom

                                </p>

                                <p class="font-bold text-xl">

                                    {{ strtoupper($etudiant->nom) }}

                                </p>

                            </div>

                            <div class="border-r p-5">

                                <p class="uppercase text-xs tracking-wider text-slate-500">

                                    Prénoms

                                </p>

                                <p class="font-bold text-xl">

                                    {{ $etudiant->prenom }}

                                </p>

                            </div>

                            <div class="border-r p-5">

                                <p class="uppercase text-xs tracking-wider text-slate-500">

                                    Matricule

                                </p>

                                <p class="font-bold text-xl">

                                    {{ $etudiant->matricule }}

                                </p>

                            </div>

                            <div class="p-5">

                                <p class="uppercase text-xs tracking-wider text-slate-500">

                                    Filière

                                </p>

                                <p class="font-bold text-xl">

                                    {{ $etudiant->filiere->nom }}

                                </p>

                            </div>

                        </div>

                    </div>



                    <!-- Tableau des notes -->
                    <div class="px-6 pb-6">

                        <div class="overflow-hidden rounded-xl border border-slate-200">

                            <table class="w-full">

                                <thead class="bg-slate-100">

                                    <tr class="text-xs uppercase tracking-wider text-slate-600">

                                        <th class="px-5 py-4 text-left w-72">
                                            Unité d'Enseignement (UE)
                                        </th>

                                        <th class="px-5 py-4 text-left">
                                            Élément Constitutif (ECUE)
                                        </th>

                                        <th class="px-5 py-4 text-center w-28">
                                            Note /20
                                        </th>

                                        <th class="px-5 py-4 text-center w-28">
                                            Moy. UE
                                        </th>

                                        <th class="px-5 py-4 text-center w-24">
                                            Crédit
                                        </th>

                                        <th class="px-5 py-4 text-center w-32">
                                            Décision
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-200 bg-white">

                                    @forelse($ues as $ue)

                                    @php
                                    $nbEcues = $ue->ecues->count();
                                    @endphp

                                    @foreach($ue->ecues as $index => $ecue)

                                    <tr class="hover:bg-slate-50">

                                        {{-- UE --}}

                                        @if($index==0)

                                        <td rowspan="{{ $nbEcues }}"
                                            class="px-5 py-5 align-top font-bold text-slate-900">

                                            {{ $ue->nom }}

                                        </td>

                                        @endif


                                        {{-- ECUE --}}

                                        <td class="px-5 py-5 text-slate-600">

                                            @if($index>0)

                                            <span class="text-slate-400">

                                                ↳

                                            </span>

                                            @endif

                                            {{ $ecue->nom }}

                                        </td>


                                        {{-- NOTE --}}

                                        <td class="px-5 py-5 text-center font-semibold text-slate-900">

                                            @if($ecue->note!==null)

                                            {{ number_format($ecue->note,2) }}

                                            @else

                                            —

                                            @endif

                                        </td>


                                        {{-- MOYENNE UE --}}

                                        @if($index==0)

                                        <td rowspan="{{ $nbEcues }}"
                                            class="px-5 py-5 text-center align-top">

                                            <span class="font-bold text-blue-600">

                                                {{ number_format($ue->moyenne,2) }}

                                            </span>

                                        </td>

                                        @endif


                                        {{-- CREDIT --}}

                                        @if($index==0)

                                        <td rowspan="{{ $nbEcues }}"
                                            class="px-5 py-5 text-center align-top">

                                            {{ $ue->credit }}

                                        </td>

                                        @endif


                                        {{-- DECISION --}}

                                        @if($index==0)

                                        <td rowspan="{{ $nbEcues }}"
                                            class="px-5 py-5 text-center align-top">

                                            @if($ue->decision=="Validée")

                                            <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-1 text-sm font-medium text-green-700">

                                                Validée

                                            </span>

                                            @elseif($ue->decision=="En attente")

                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-1 text-sm font-medium text-yellow-700">

                                                En attente

                                            </span>

                                            @else

                                            <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-1 text-sm font-medium text-red-700">

                                                Non validée

                                            </span>

                                            @endif

                                        </td>

                                        @endif

                                    </tr>

                                    @endforeach

                                    @empty

                                    <tr>

                                        <td colspan="6"
                                            class="py-12 text-center text-slate-500">

                                            Aucune note disponible.

                                        </td>

                                    </tr>

                                    @endforelse




                                </tbody>




                            </table>
                            @if($resultatsComplets)
                            <!-- Résumé du semestre -->
                            <div class="border border-t-0 border-slate-200 rounded-b-xl overflow-hidden">

                                <!-- Total UE validées -->
                                <div class="bg-slate-50 px-8 py-5">

                                    <div class="flex justify-end">

                                        <p class="text-lg font-semibold text-slate-700">

                                            Total UE validées :

                                            <span class="ml-6 font-bold text-slate-900">

                                                {{ $nombreUEValidees }}

                                                sur

                                                {{ $nombreUE }}

                                            </span>

                                        </p>

                                    </div>

                                </div>

                                <!-- Moyenne -->
                                <div class="border-t px-8 py-6 text-center">

                                    <h2 class="text-3xl font-bold text-blue-600">

                                        Moyenne du semestre :

                                        {{ number_format($moyenneGenerale,2) }}/20

                                    </h2>

                                </div>

                                <!-- Décision -->
                                <div class="border-t px-8 py-6">

                                    <div class="flex justify-center items-center gap-6">

                                        <span class="text-2xl font-semibold">

                                            Décision du Jury :

                                        </span>

                                        @if($decision=="VALIDÉ")

                                        <span
                                            class="inline-flex items-center gap-2 rounded-full bg-green-100 px-6 py-3 text-xl font-bold text-green-700">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 13l4 4L19 7" />

                                            </svg>

                                            Validé

                                        </span>

                                        @else

                                        <span
                                            class="inline-flex items-center gap-2 rounded-full bg-red-100 px-6 py-3 text-xl font-bold text-red-700">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor">

                                                <path stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />

                                            </svg>

                                            Refusé

                                        </span>

                                        @endif

                                    </div>

                                </div>

                            </div>


@endif
                        </div>

                    </div>


                </div>

        </main>
    </div>

    <script>
        lucide.createIcons();

        const studentInfo = {
            nom: "OTCHOUN",
            prenoms: "Gedeon",
            matricule: "16942224",
            filiere: "Arts Plastiques",
            anneeUniv: "2024-2025"
        };

        const semestersData = {
            S1: {
                annee: "1ère année",
                moyenne: 12.42,
                credits: 30,
                ueValidees: 8,
                ueTotal: 8,
                decision: "Validé",
                data: [{
                        ue: "Communication et Enseignement",
                        eque: "Introduction à la communication",
                        note: 12.00,
                        moyUE: 12.50,
                        credit: 3,
                        decision: "Validée"
                    },
                    {
                        ue: "Communication et Enseignement",
                        eque: "Niveaux de langues et expression",
                        note: 13.00,
                        moyUE: 12.50,
                        credit: 3,
                        decision: "Validée"
                    },
                    {
                        ue: "Culture générale",
                        eque: "Culture Générale",
                        note: 13.00,
                        moyUE: 13.00,
                        credit: 2,
                        decision: "Validée"
                    },
                    {
                        ue: "Genres littéraires",
                        eque: "La Notion de genres littéraires",
                        note: 12.00,
                        moyUE: 12.25,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Genres littéraires",
                        eque: "Des considérations de genres aux oeuvres",
                        note: 12.50,
                        moyUE: 12.25,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature Française",
                        eque: "La littérature française jusqu'au 15e siècle",
                        note: 10.00,
                        moyUE: 10.00,
                        credit: 5,
                        decision: "Validée"
                    },
                    {
                        ue: "Méthodologie des études françaises",
                        eque: "Contraction de texte",
                        note: 12.00,
                        moyUE: 12.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Méthodologie des études françaises",
                        eque: "Dissertation",
                        note: 12.00,
                        moyUE: 12.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Linguistique générale",
                        eque: "Phonétique et Phonologie",
                        note: 15.00,
                        moyUE: 12.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Linguistique générale",
                        eque: "Introduction à la linguistique générale",
                        note: 10.00,
                        moyUE: 12.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Société et Education",
                        eque: "Aspect conceptuel de l'éducation",
                        note: 12.00,
                        moyUE: 14.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Société et Education",
                        eque: "Introduction à la sociologie de l'éducation",
                        note: 17.00,
                        moyUE: 14.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Pédagogie générale",
                        eque: "Introduction à la didactique",
                        note: 13.00,
                        moyUE: 13.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Pédagogie générale",
                        eque: "Les grands courants pédagogiques",
                        note: 14.00,
                        moyUE: 13.50,
                        credit: 4,
                        decision: "Validée"
                    }
                ]
            },
            S2: {
                annee: "1ère année",
                moyenne: 12.03,
                credits: 30,
                ueValidees: 6,
                ueTotal: 6,
                decision: "Validé",
                data: [{
                        ue: "Stylistique",
                        eque: "Initiation à la stylistique française",
                        note: 10.00,
                        moyUE: 10.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature africaine",
                        eque: "Littérature africaine jusqu'en 1960",
                        note: 10.00,
                        moyUE: 10.00,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Méthodologie",
                        eque: "Technique de composition",
                        note: 11.00,
                        moyUE: 12.50,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Méthodologie",
                        eque: "TEOO",
                        note: 14.00,
                        moyUE: 12.50,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Les niveaux de langue",
                        eque: "Anglais",
                        note: 17.00,
                        moyUE: 14.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Les niveaux de langue",
                        eque: "Langues nationales",
                        note: 11.00,
                        moyUE: 14.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Didactique spécifique",
                        eque: "Appropriation du programme du français",
                        note: 12.00,
                        moyUE: 12.00,
                        credit: 8,
                        decision: "Validée"
                    },
                    {
                        ue: "Technologie et Enseignement",
                        eque: "Initiation à l'informatique",
                        note: 17.00,
                        moyUE: 17.00,
                        credit: 2,
                        decision: "Validée"
                    }
                ]
            },
            S3: {
                annee: "2ème année",
                moyenne: 11.45,
                credits: 30,
                ueValidees: 9,
                ueTotal: 9,
                decision: "Validé",
                data: [{
                        ue: "Didactique spécifique",
                        eque: "Didactique de la lecture au collège",
                        note: 10.00,
                        moyUE: 11.50,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Didactique spécifique",
                        eque: "Evaluation de la production écrite",
                        note: 13.00,
                        moyUE: 11.50,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Grammaire",
                        eque: "Didactique de la grammaire et syntaxe",
                        note: 10.00,
                        moyUE: 11.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Grammaire",
                        eque: "Syntaxe du verbe et typologie",
                        note: 12.00,
                        moyUE: 11.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature française",
                        eque: "Renaissance et Humanisme au XVIe siècle",
                        note: 10.00,
                        moyUE: 10.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature béninoise",
                        eque: "Littérature de jeunesse au Bénin",
                        note: 10.00,
                        moyUE: 12.00,
                        credit: 3,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature béninoise",
                        eque: "Roman et société au Bénin",
                        note: 14.00,
                        moyUE: 12.00,
                        credit: 3,
                        decision: "Validée"
                    },
                    {
                        ue: "Culture générale",
                        eque: "Genre et éducation",
                        note: 13.00,
                        moyUE: 13.00,
                        credit: 2,
                        decision: "Validée"
                    }
                ]
            },
            S4: {
                annee: "2ème année",
                moyenne: 11.73,
                credits: 30,
                ueValidees: 7,
                ueTotal: 7,
                decision: "Validé",
                data: [{
                        ue: "Communication et Enseignement",
                        eque: "Animation et dynamique des groupes",
                        note: 12.00,
                        moyUE: 12.00,
                        credit: 2,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature française",
                        eque: "Classicisme et littérature française",
                        note: 10.00,
                        moyUE: 12.00,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature française",
                        eque: "Littérature et société au XVIIème siècle",
                        note: 14.00,
                        moyUE: 12.00,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Pédagogie",
                        eque: "Finalités, objectifs et méthodes",
                        note: 12.00,
                        moyUE: 13.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Pédagogie",
                        eque: "Observations et analyse des situations",
                        note: 15.00,
                        moyUE: 13.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Roman et Nouvelle en Afrique",
                        eque: "Le roman et la nouvelle en Afrique",
                        note: 10.00,
                        moyUE: 10.00,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Théâtre",
                        eque: "Théâtre colonial en Afrique francophone",
                        note: 11.00,
                        moyUE: 11.00,
                        credit: 6,
                        decision: "Validée"
                    }
                ]
            },
            S5: {
                annee: "3ème année",
                moyenne: 13.20,
                credits: 30,
                ueValidees: 8,
                ueTotal: 8,
                decision: "Validé",
                data: [{
                        ue: "Enseignement et Epistémologie",
                        eque: "Introduction à l'enseignement et épistémologie",
                        note: 14.00,
                        moyUE: 14.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Didactique",
                        eque: "Appropriation du programme du français",
                        note: 13.00,
                        moyUE: 13.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Didactique",
                        eque: "Didactique de la production écrite",
                        note: 14.00,
                        moyUE: 13.50,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature Africaine",
                        eque: "Le conte Africain comme genre littéraire",
                        note: 15.00,
                        moyUE: 14.50,
                        credit: 2,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature Africaine",
                        eque: "Littérature Africaine Anglophone",
                        note: 14.00,
                        moyUE: 14.50,
                        credit: 2,
                        decision: "Validée"
                    },
                    {
                        ue: "La poésie négro-africaine",
                        eque: "La poésie négro-africaine",
                        note: 13.00,
                        moyUE: 13.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Pédagogie",
                        eque: "Animation et gestion de la classe",
                        note: 12.00,
                        moyUE: 12.50,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Pédagogie",
                        eque: "Evaluation de la production écrite",
                        note: 13.00,
                        moyUE: 12.50,
                        credit: 6,
                        decision: "Validée"
                    }
                ]
            },
            S6: {
                annee: "3ème année",
                moyenne: 14.10,
                credits: 30,
                ueValidees: 6,
                ueTotal: 6,
                decision: "Validé",
                data: [{
                        ue: "Psychologie et Education",
                        eque: "Psychologie de l'enfant",
                        note: 14.00,
                        moyUE: 14.00,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Psychologie et Education",
                        eque: "Psychologie de l'adolescent",
                        note: 14.00,
                        moyUE: 14.00,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Technique de rédaction",
                        eque: "Méthodologie de rédaction de mémoire",
                        note: 15.00,
                        moyUE: 15.00,
                        credit: 2,
                        decision: "Validée"
                    },
                    {
                        ue: "Littérature comparée",
                        eque: "Le 19e siècle français: roman et poésie",
                        note: 13.00,
                        moyUE: 13.00,
                        credit: 4,
                        decision: "Validée"
                    },
                    {
                        ue: "Soutenance de mémoire",
                        eque: "Soutenance de mémoire",
                        note: 16.00,
                        moyUE: 16.00,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Inspection de qualification",
                        eque: "Note du Directeur de l'école",
                        note: 14.00,
                        moyUE: 14.50,
                        credit: 6,
                        decision: "Validée"
                    },
                    {
                        ue: "Inspection de qualification",
                        eque: "Note du tuteur de stage",
                        note: 15.00,
                        moyUE: 14.50,
                        credit: 6,
                        decision: "Validée"
                    }
                ]
            }
        };

        let currentSemester = 'S1';

        function renderTabs() {
            const tabsContainer = document.getElementById('semesterTabs');
            tabsContainer.innerHTML = '';
            Object.keys(semestersData).forEach(key => {
                const isActive = key === currentSemester;
                const btn = document.createElement('button');
                btn.className = `px-6 py-4 text-sm font-medium transition-colors whitespace-nowrap ${isActive ? 'tab-active' : 'tab-inactive'}`;
                btn.textContent = `Semestre ${key.replace('S', '')}`;
                btn.onclick = () => switchSemester(key);
                tabsContainer.appendChild(btn);
            });
        }

        function switchSemester(semesterKey) {
            currentSemester = semesterKey;
            renderTabs();
            renderContent();
            lucide.createIcons();
        }

        function renderContent() {
            const container = document.getElementById('semesterContent');
            const data = semestersData[currentSemester];
            const semNum = currentSemester.replace('S', '');

            let tableRows = '';
            let lastUE = '';

            data.data.forEach((row, index) => {
                const showUE = row.ue !== lastUE;
                lastUE = row.ue;

                const decisionColor = row.decision === 'Validée' ? 'text-emerald-700 bg-emerald-50' : 'text-red-700 bg-red-50';

                tableRows += `
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-sm text-gray-900 ${showUE ? 'font-semibold' : 'text-gray-500 pl-8'}">
                            ${showUE ? row.ue : '<span class="text-gray-400">↳</span> ' + row.eque}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">${showUE ? row.eque : ''}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 text-center">${row.note !== undefined ? row.note.toFixed(2) : '-'}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-primary-700 text-center">${row.moyUE.toFixed(2)}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-center">${row.credit}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${decisionColor}">
                                ${row.decision}
                            </span>
                        </td>
                    </tr>
                `;
            });

            container.innerHTML = `
                <div class="fade-in">
                    <!-- Header Info -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-200">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Relevé de Notes - Semestre ${semNum}</h3>
                            <p class="text-sm text-gray-500 mt-1">${data.annee} • ${studentInfo.filiere} • Année Universitaire ${studentInfo.anneeUniv}</p>
                        </div>
                        <button class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                            <i data-lucide="download" class="w-4 h-4"></i> Télécharger le PDF
                        </button>
                    </div>

                    <!-- Student Info Banner -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Nom</p>
                            <p class="text-sm font-semibold text-gray-900">${studentInfo.nom}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Prénoms</p>
                            <p class="text-sm font-semibold text-gray-900">${studentInfo.prenoms}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Matricule</p>
                            <p class="text-sm font-semibold text-gray-900">${studentInfo.matricule}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Filière</p>
                            <p class="text-sm font-semibold text-gray-900">${studentInfo.filiere}</p>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 text-xs uppercase tracking-wider">
                                    <th class="px-4 py-3 font-semibold border-b border-gray-200">Unité d'Enseignement (UE)</th>
                                    <th class="px-4 py-3 font-semibold border-b border-gray-200">Élément Constitutif (ECUE)</th>
                                    <th class="px-4 py-3 font-semibold border-b border-gray-200 text-center">Note /20</th>
                                    <th class="px-4 py-3 font-semibold border-b border-gray-200 text-center">Moy. UE</th>
                                    <th class="px-4 py-3 font-semibold border-b border-gray-200 text-center">Crédit</th>
                                    <th class="px-4 py-3 font-semibold border-b border-gray-200 text-center">Décision</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                ${tableRows}
                            </tbody>
                            <tfoot class="bg-gray-50 font-semibold text-gray-900">
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-right text-sm">Total UE validées :</td>
                                    <td colspan="3" class="px-4 py-4 text-sm">${data.ueValidees} sur ${data.ueTotal}</td>
                                </tr>
                                <tr class="border-t-2 border-gray-300">
                                    <td colspan="3" class="px-4 py-4 text-right text-base text-primary-700">Moyenne du semestre :</td>
                                    <td colspan="3" class="px-4 py-4 text-base text-primary-700">${data.moyenne.toFixed(2)} / 20</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="px-4 py-4 text-right text-sm">Décision du Jury :</td>
                                    <td colspan="3" class="px-4 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-bold ${data.decision === 'Validé' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'}">
                                            <i data-lucide="${data.decision === 'Validé' ? 'check-circle' : 'x-circle'}" class="w-4 h-4"></i>
                                            ${data.decision}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Signature Block -->
                    <div class="mt-8 flex justify-end">
                        <div class="text-center">
                            <p class="text-sm text-gray-500 mb-8">Signature et cachet du Directeur</p>
                            <p class="text-sm font-semibold text-gray-900">Dr Julien Chambi ATCHADE</p>
                            <p class="text-xs text-gray-500">Directeur de l'IRSBAC</p>
                        </div>
                    </div>

                    <!-- QR Info -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-lg flex items-start gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-sm font-medium text-primary-900">Authenticité du document</p>
                            <p class="text-xs text-primary-700 mt-1">Ce relevé de notes est doté d'un QR Code de vérification. Scannez-le pour confirmer son authenticité auprès de l'IRSBAC sans nécessiter de connexion.</p>
                        </div>
                    </div>
                </div>
            `;
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Initial render
        renderTabs();
        renderContent();
    </script>
</body>

</html>