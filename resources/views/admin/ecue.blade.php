<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion UE & ECUE - Administration IRSBAC</title>
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

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .toast {
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toast.show {
            transform: translateX(0);
        }

        .a4-preview {
            width: 210mm;
            min-height: 297mm;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            padding: 20mm;
            position: relative;
            font-size: 11pt;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .a4-preview {
                width: 100%;
                min-height: auto;
                padding: 15px;
                transform: scale(0.6);
                transform-origin: top center;
            }
        }

        .drag-active {
            border-color: #2563eb !important;
            background-color: #eff6ff !important;
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
                <p class="text-xs text-blue-200">Espace Administration</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
            <a href="{{route('admin.dashboard')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                 Tableau de bord
            </a>
            <a href="{{route('admin.gestionetudiant')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                 Gestion des Étudiants
            </a>
            <a href="{{route('imports.create')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sheet-icon lucide-sheet"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="3" x2="21" y1="15" y2="15"/><line x1="9" x2="9" y1="9" y2="21"/><line x1="15" x2="15" y1="9" y2="21"/></svg> Importation Excel
            </a>
            <a href="{{route('admin.generationdoc')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                 Génération de Documents
            </a>
            <a href="{{route('admin.modele_signature')}}" class="flex items-center gap-3 px-4 py-3 hover:bg-primary-800  rounded-lg text-white font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-template-icon lucide-layout-template"><rect width="18" height="7" x="3" y="3" rx="1"/><rect width="9" height="7" x="3" y="14" rx="1"/><rect width="5" height="7" x="16" y="14" rx="1"/></svg>
                 Modèles & Signatures
            </a>
             
            <a href="{{ route('ues.store') }}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 text-white text-blue-200 font-medium rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
 UE & ECUE
            </a>
        </nav>
        <div class="p-4 border-t border-primary-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-red-300 hover:bg-red-500/20 hover:text-red-100 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg> Déconnexion
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
                        <h2 class="text-xl font-bold text-gray-900">Gestion des UE et ECUES</h2>
                        <p class="text-sm text-gray-500">Configurez les modèles de documents et les signatures officielles</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="hidden sm:block text-right">
                          @if($info->directeur_etudes )
                            <p class="text-sm font-semibold text-gray-900">{{ $info->directeur_etudes}}</p>
                            <p class="text-xs text-gray-500">Directeur des Études</p>
                            @endif
                    </div>
    
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-6">

            
                


          




            <div class="bg-white rounded-2xl shadow overflow-hidden">

                <div class="p-6 border-b flex justify-between items-center">

                    <h2 class="text-xl font-bold text-gray-800">
                        Unités d'Enseignement
                    </h2>

                    <button
                        type="button"
                        onclick="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>


                        Nouvelle UE

                    </button>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>

                            <tr class="bg-gray-50">

                                <th class="px-6 py-4 text-left">
                                    Nom
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Code
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Crédit
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Semestre
                                </th>

                                <th class="px-6 py-4 text-left">
                                    Filières
                                </th>

                                <th class="px-6 py-4 text-center">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($ues as $ue)

                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-6 py-4">

                                    {{ $ue->nom }}

                                </td>

                                <td class="px-6 py-4">

                                    {{ $ue->code }}

                                </td>

                                <td class="px-6 py-4">

                                    {{ $ue->credit }}

                                </td>

                                <td class="px-6 py-4">

                                    S{{ $ue->semestre }}

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex flex-wrap gap-2">

                                        @foreach($ue->filieres as $filiere)

                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs">

                                            {{ $filiere->nom }}

                                        </span>

                                        @endforeach

                                    </div>

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        <button

                                            type="button"

                                            class="editUeBtn p-2 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200"

                                            data-id="{{ $ue->id }}"
                                            data-nom="{{ $ue->nom }}"
                                            data-code="{{ $ue->code }}"
                                            data-credit="{{ $ue->credit }}"
                                            data-semestre="{{ $ue->semestre }}"
                                            data-filieres='@json($ue->filieres->pluck("id")->toArray())'>

                                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon lucide-pencil-line"><path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>

                                        </button>

                                        <form
                                            action="{{ route('ues.destroy',$ue->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Supprimer cette UE ?')"
                                                class="p-2 rounded-lg bg-red-100 text-red-600 hover:bg-red-200">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>


            <div
                class="flex justify-between items-center mb-4">

                <h1
                    class="text-2xl font-bold">

                    Gestion des ECUE

                </h1>

                <button
                    onclick="openEcueCreate()"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    Nouvelle ECUE

                </button>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="px-6 py-8 border-b bg-gray-50">

                    <h2 class="text-lg font-semibold text-gray-800">
                        Liste des ECUE
                    </h2>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full">

                        <thead>

                            <tr class="bg-gray-50">

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    ECUE
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Coef
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    UE
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($ecues as $ecue)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4">

                                    <div class="font-medium text-gray-800">
                                        {{ $ecue->nom }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-center">

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">

                                        {{ $ecue->coefficient }}

                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">

                                        {{ $ecue->ue->nom }}

                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center items-center gap-2">

                                        <button

                                            type="button"

                                            class="ecueEditBtn

                                    h-8 w-8

                                    flex items-center justify-center

                                    rounded-lg

                                    text-amber-600

                                    hover:bg-amber-50"

                                            data-id="{{ $ecue->id }}"
                                            data-nom="{{ $ecue->nom }}"
                                            data-coefficient="{{ $ecue->coefficient }}"
                                            data-ue="{{ $ecue->ue_id }}">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 24 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon lucide-pencil-line"><path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>


                                        </button>

                                        <form
                                            action="{{ route('ecues.destroy',$ecue->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button

                                                type="submit"

                                                onclick="return confirm('Supprimer cette ECUE ?')"

                                                class="

                                        h-8 w-8

                                        flex items-center justify-center

                                        rounded-lg

                                        text-red-600

                                        hover:bg-red-50">

                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td
                                    colspan="4"
                                    class="px-6 py-12 text-center text-gray-500">

                                    Aucune ECUE enregistrée

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


       




            <script>
                lucide.createIcons();

                let currentTab = 'templates';

                function toggleSidebar() {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('mobileOverlay');
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                }



                function openPreviewModal() {
                    document
                        .getElementById('previewModal')
                        .classList
                        .remove('hidden');
                }

                function closePreviewModal() {
                    document
                        .getElementById('previewModal')
                        .classList
                        .add('hidden');
                }


                function openUeModal() {
                    document
                        .getElementById('ueModal')
                        .classList
                        .remove('hidden');
                }

                function closeUeModal() {
                    document
                        .getElementById('ueModal')
                        .classList
                        .add('hidden');
                }

                function openEcueModal() {
                    document
                        .getElementById('ecueModal')
                        .classList
                        .remove('hidden');
                }

                function closeEcueModal() {
                    document
                        .getElementById('ecueModal')
                        .classList
                        .add('hidden');
                }
            </script>

           

               
                     

<!-- Modal Création UE -->
<div id="createModal"
    class="fixed inset-0 z-50 hidden">

    <!-- Overlay -->
    <div
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
        onclick="closeCreateModal()">
    </div>

    <!-- Contenu -->
    <div class="absolute inset-0 flex items-center justify-center p-4">

        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">

            <!-- En-tête -->
            <div class="flex items-center justify-between px-6 py-5 border-b bg-slate-50">

                <div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Nouvelle UE
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Créez une nouvelle Unité d'Enseignement.
                    </p>

                </div>

                <button
                    type="button"
                    onclick="closeCreateModal()"
                    class="text-slate-500 hover:text-red-500 transition">

                    <i data-lucide="x" class="w-6 h-6"></i>

                </button>

            </div>

            <!-- Formulaire -->
            <form
                id="createUEForm"
                action="{{ route('ues.store') }}"
                method="POST">

                @csrf

                <div class="p-6 space-y-5">

                    <!-- Nom -->
                    <div>

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nom de l'UE
                        </label>

                        <input
                            type="text"
                            name="nom"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                            placeholder="Ex : Mathématiques Générales">

                    
                    <p class="mt-1 text-xs text-red-500" id="error-nom">⚠</p>
                
                    </div>

                    <!-- Code -->
                    <div>

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Code
                        </label>

                        <input
                            type="text"
                            name="code"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                            placeholder="Ex : MAT101">

                      
                    </div>

                    <!-- Crédit + Semestre -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>

                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Crédit
                            </label>

                            <input
                                type="number"
                                min="1"
                                name="credit"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                                placeholder="Ex : 6">

                             @error('credit')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                Semestre
                            </label>

                            <select
                                name="semestre"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">

                                <option value="">Choisir...</option>

                                @for($i=1;$i<=6;$i++)
                                    <option value="{{ $i }}">
                                        Semestre {{ $i }}
                                    </option>
                                @endfor

                            </select>

                            @error('semestre')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                        </div>

                    </div>

                    <!-- Filières -->
                    <div>

                        <label class="block text-sm font-medium text-slate-700 mb-3">
                            Filières concernées
                        </label>

                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-52 overflow-y-auto border rounded-xl p-4">

                            @foreach($filieres as $filiere)

                                <label class="flex items-center gap-2 cursor-pointer">

                                    <input
                                        type="checkbox"
                                        name="filieres[]"
                                        value="{{ $filiere->id }}"
                                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">

                                    <span class="text-sm text-slate-700">
                                        {{ $filiere->nom }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                        @error('fillieres')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                    </div>

     <div>

                        <label class="block text-sm font-medium text-slate-700 mb-3">
                            Annee etude concernées
                        </label>

                      
                            
      <select
                                name="niveau"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none">

                                <option value="">Choisir...</option>

                                
                                    <option value="1">
                                        L1
                                    </option>
                                    <option value="2">
                                        L2
                                    </option>
                                    <option value="3">
                                        L3
                                    </option>
                                

                            </select>
                                

                                
                                

                        

                        </div>

               
                    




                </div>

                <!-- Pied -->
                <div class="flex justify-end gap-3 px-6 py-5 border-t bg-slate-50">

                    <button
                        type="button"
                        onclick="closeCreateModal()"
                        class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 transition">

                        Annuler

                    </button>

                    <button
                        type="submit"
                        id="saveUEBtn"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white font-medium transition">

                        <i data-lucide="save" class="w-4 h-4"></i>

                        Enregistrer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



            
            <div
                id="editModal"
                class="fixed inset-0 hidden z-50">

                <div
                    class="absolute inset-0 bg-black/50"
                    onclick="closeEditModal()">
                </div>

                <div
                    class="absolute inset-0 flex items-center justify-center p-4">

                    <div
                        class="bg-white rounded-2xl w-full max-w-2xl shadow-xl">

                        <div class="p-6 border-b">

                            <h2 class="text-xl font-bold">

                                Modifier UE

                            </h2>

                        </div>

                        <form
                            id="editForm"
                            method="POST">

                            @csrf
                            @method('PUT')
 <input type="hidden" name="open_modal" value="editModal">
                            <div class="p-6 space-y-4">

                                <input
                                    id="editNom"
                                    name="nom"
                                    class="w-full border rounded-lg px-4 py-3">
 @error('nom')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                <input
                                    id="editCode"
                                    name="code"
                                    class="w-full border rounded-lg px-4 py-3">

                                <input
                                    id="editCredit"
                                    type="number"
                                    name="credit"
                                    class="w-full border rounded-lg px-4 py-3">
  @error('credit')
                    <p class=" text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                <select
                                    id="editSemestre"
                                    name="semestre"
                                    class="w-full border rounded-lg px-4 py-3">

                                    <option value="1">Semestre 1</option>
                                    <option value="2">Semestre 2</option>
                                    <option value="3">Semestre 3</option>
                                    <option value="4">Semestre 4</option>
                                    <option value="5">Semestre 5</option>
                                    <option value="6">Semestre 6</option>

                                </select>
 @error('semestre')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                <div>

                                    <h3 class="font-semibold mb-3">

                                        Filières concernées

                                    </h3>

                                    <div class="grid grid-cols-2 gap-3">

                                        @foreach($filieres as $filiere)

                                        <label
                                            class="flex items-center gap-2">

                                            <input
                                                type="checkbox"
                                                class="edit-filiere"
                                                name="filieres[]"
                                                value="{{ $filiere->id}}">

                                            {{ $filiere->nom }}

                                        </label>

                                        @endforeach
 @error('filieres')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                    </div>

                                </div>

                            </div>

                            <div
                                class="p-6 border-t flex justify-end gap-3">

                                <button
                                    type="button"
                                    onclick="closeEditModal()"
                                    class="px-4 py-2 border rounded-lg">

                                    Annuler

                                </button>

                                <button
                                    class="px-4 py-2 bg-primary-600 text-white rounded-lg">

                                    Mettre à jour

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            

            <div
                id="ecueCreateModal"
                class="fixed inset-0 hidden z-50">

                <div
                    class="absolute inset-0 bg-black/50"
                    onclick="closeEcueCreate()">
                </div>

                <div
                    class="absolute inset-0 flex items-center justify-center p-4">

                    <div
                        class="bg-white rounded-xl w-full max-w-lg">

                        <form
                            action="{{ route('ecues.store') }}"
                            method="POST">

                            @csrf

                            <div class="p-6">

                                <h2 class="font-bold text-xl mb-4">

                                    Nouvelle ECUE

                                </h2>

                                <div class="space-y-4">

                                    <input
                                        type="text"
                                        name="nom"
                                        placeholder="Nom ECUE"
                                        class="w-full border rounded-lg p-3">
               @error('nom')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                    <input
                                        type="number"
                                        name="coefficient"
                                        placeholder="Coefficient"
                                        class="w-full border rounded-lg p-3">
 @error('coefficient')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                    <select
                                        name="ue_id"
                                        class="w-full border rounded-lg p-3">

                                        @foreach($ues as $ue)

                                        <option
                                            value="{{ $ue->id }}">

                                            {{ $ue->nom }}

                                        </option>

                                        @endforeach

                                    </select>
               @error('ue_id')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                </div>

                            </div>

                            <div
                                class="p-6 border-t flex justify-end gap-2">

                                <button
                                    type="button"
                                    onclick="closeEcueCreate()"
                                    class="px-4 py-2 border rounded-lg">

                                    Annuler

                                </button>

                                <button
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg">

                                    Enregistrer

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            <div
                id="ecueEditModal"
                class="fixed inset-0 hidden z-50">

                <div
                    class="absolute inset-0 bg-black/50"
                    onclick="closeEcueEdit()">
                </div>

                <div
                    class="absolute inset-0 flex items-center justify-center p-4">

                    <div
                        class="bg-white rounded-xl w-full max-w-lg">

                        <form
                            id="ecueEditForm"
                            method="POST">

                            @csrf
                            @method('PUT')

                            <div class="p-6">

                                <h2 class="font-bold text-xl mb-4">

                                    Modifier ECUE

                                </h2>

                                <div class="space-y-4">

                                    <input
                                        id="ecueEditNom"
                                        name="nom"
                                        class="w-full border rounded-lg p-3">

                                    <input
                                        id="ecueEditCoefficient"
                                        name="coefficient"
                                        class="w-full border rounded-lg p-3">

                                    <select
                                        id="ecueEditUe"
                                        name="ue_id"
                                        class="w-full border rounded-lg p-3">

                                        @foreach($ues as $ue)

                                        <option
                                            value="{{ $ue->id }}">

                                            {{ $ue->nom }}

                                        </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            <div
                                class="p-6 border-t flex justify-end gap-2">

                                <button
                                    type="button"
                                    onclick="closeEcueEdit()"
                                    class="px-4 py-2 border rounded-lg">

                                    Annuler

                                </button>

                                <button
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">

                                    Modifier

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

            <script>




    

     













                const ecueSelect =
                    document.getElementById('ecue_id');


                function openCreateModal() {
                    document
                        .getElementById('createModal')
                        .classList.remove('hidden');
                }

                function closeCreateModal() {
                    document
                        .getElementById('createModal')
                        .classList.add('hidden');
                }

                function closeEditModal() {
                    document
                        .getElementById('editModal')
                        .classList.add('hidden');
                }

                document
                    .querySelectorAll('.editUeBtn')
                    .forEach(button => {
                        button.addEventListener(
                            'click',
                            function() {
                                document
                                    .getElementById('editModal')
                                    .classList.remove('hidden');

                                document
                                    .getElementById('editForm')
                                    .action =
                                    '/ues/' +
                                    this.dataset.id;

                                document
                                    .getElementById('editNom')
                                    .value =
                                    this.dataset.nom;

                                document
                                    .getElementById('editCode')
                                    .value =
                                    this.dataset.code;

                                document
                                    .getElementById('editCredit')
                                    .value =
                                    this.dataset.credit;

                                document
                                    .getElementById('editSemestre')
                                    .value =
                                    this.dataset.semestre;

                                let filieres =
                                    JSON.parse(
                                        this.dataset.filieres
                                    );

                                document
                                    .querySelectorAll('.edit-filiere')
                                    .forEach(cb => {
                                        cb.checked =
                                            filieres.includes(
                                                parseInt(cb.value)
                                            );
                                    });
                            }
                        );
                    });

                

                const ecueEditModal =
                    document.getElementById(
                        'ecueEditModal'
                    );

                function openEcueCreate() {
                    document
                        .getElementById(
                            'ecueCreateModal'
                        )
                        .classList.remove(
                            'hidden'
                        );
                }

                function closeEcueCreate() {
                    document
                        .getElementById(
                            'ecueCreateModal'
                        )
                        .classList.add(
                            'hidden'
                        );
                }


                function closeEcueEdit() {
                    ecueEditModal
                        .classList.add(
                            'hidden'
                        );
                }

                document
                    .querySelectorAll(
                        '.ecueEditBtn'
                    )

                    .forEach(btn => {
                        btn.onclick = () => {
                            ecueEditModal
                                .classList.remove(
                                    'hidden'
                                );

                            document
                                .getElementById(
                                    'ecueEditForm'
                                )

                                .action =
                                `/ecues/${btn.dataset.id}`;

                            document
                                .getElementById(
                                    'ecueEditNom'
                                )

                                .value =
                                btn.dataset.nom;

                            document
                                .getElementById(
                                    'ecueEditCoefficient'
                                )

                                .value =
                                btn.dataset.coefficient;

                            document
                                .getElementById(
                                    'ecueEditUe'
                                )

                                .value =
                                btn.dataset.ue;
                        };
                    });

                


                function openSignatureCachetCreateModal() {
                    document
                        .getElementById('signatureCachetCreateModal')
                        .classList.remove('hidden');

                    document
                        .getElementById('signatureCachetCreateModal')
                        .classList.add('flex');
                }


                function closeSignatureCachetCreateModal() {
                    document
                        .getElementById('signatureCachetCreateModal')
                        .classList.add('hidden');
                }

                function openSignatureCachetEditModal(id, type, nom) {
                    let form =
                        document.getElementById('signatureCachetEditForm');

                    form.action =
                        '/signature-cachets/' + id;

                    document.getElementById(
                        'editSignatureCachetType'
                    ).value = type;

                    document.getElementById(
                        'editSignatureCachetNom'
                    ).value = nom;

                    document
                        .getElementById('signatureCachetEditModal')
                        .classList.remove('hidden');

                    document
                        .getElementById('signatureCachetEditModal')
                        .classList.add('flex');
                }

                function closeSignatureCachetEditModal() {
                    document
                        .getElementById('signatureCachetEditModal')
                        .classList.add('hidden');
                }

                lucide.createIcons();
            </script>
</body>

</html>