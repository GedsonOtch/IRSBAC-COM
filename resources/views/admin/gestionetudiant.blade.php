<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants - Administration IRSBAC</title>
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

        #toast {
            animation: slideIn 0.4s ease-out,
                fadeOut 0.5s ease-in 3.5s forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-primary-900 text-white z-40 sidebar-transition transform -translate-x-full lg:translate-x-0 flex flex-col">
        <div class="p-6 flex items-center gap-3 border-b border-primary-800">
           <img src="{{asset('storage/logo_irsbac/logo.png')}}" alt="IRSBAC Logo" class="w-13 h-13 object-contain rounded-lg p-1">
            <div>
                <h1 class="text-lg font-bold tracking-wide">IRSBAC</h1>
                <p class="text-xs text-blue-200">Espace Administration</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                 Tableau de bord
            </a>
            <a href="{{route('admin.gestionetudiant')}}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                 Gestion des Étudiants
            </a>
            <a href="{{route('imports.create')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sheet-icon lucide-sheet"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="3" x2="21" y1="15" y2="15"/><line x1="9" x2="9" y1="9" y2="21"/><line x1="15" x2="15" y1="9" y2="21"/></svg>
 Importation Excel
            </a>
            <a href="{{ route('admin.generationdoc') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
  Génération de Documents
            </a>
            <a href="{{ route('admin.modele_signature') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-template-icon lucide-layout-template"><rect width="18" height="7" x="3" y="3" rx="1"/><rect width="9" height="7" x="3" y="14" rx="1"/><rect width="5" height="7" x="16" y="14" rx="1"/></svg> Modèles & Signatures
            </a>
             <a href="{{ route('ues.store') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                 UE & ECUE
            </a>
           <!-- <a href="#" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <i data-lucide="shield-check" class="w-5 h-5"></i> Journal d'audit
            </a>-->
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
                        <h2 class="text-xl font-bold text-gray-900">Gestion des Étudiants</h2>
                        <p class="text-sm text-gray-500">Gérez les inscriptions, les profils et les imports de masse</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="hidden sm:block text-right">
                          @if($info->directeur)
                            <p class="text-sm font-semibold text-gray-900">{{ $info->directeur}}</p>
                            <p class="text-xs text-gray-500">Directeur</p>
                            @endif
                    </div>
                  
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-6">

            <!-- Stats & Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 fade-in">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg"><i data-lucide="users" class="w-6 h-6 text-primary-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Total Étudiants</p>
                        <p class="text-2xl font-bold text-gray-900"> {{ $nombrEtudiants }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 rounded-lg"><i data-lucide="user-check" class="w-6 h-6 text-emerald-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Actifs cette année</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $nombrEtudiants }}</p>
                    </div>
                </div>
                <div class="lg:col-span-2 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-end">
                    <button onclick="openModal('importModal')" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-upload-icon lucide-cloud-upload"><path d="M12 13v8"/><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="m8 17 4-4 4 4"/></svg>
 Importer via Excel
                    </button>
                    <button onclick="openModal('addStudentModal')" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus-icon lucide-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
 Ajouter un étudiant
                    </button>
                </div>
            </div>

            <!-- Filters & Search -->

            <form id="filterForm" method="GET"
                action="{{ route('admin.gestionetudiant') }}">

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 fade-in">
                    <div class="flex flex-col md:flex-row gap-4">

                        <div class="flex-1 relative">
                            <i data-lucide="search"
                                class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                            <input
                                type="text"
                                id="searchInput"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Rechercher par nom, prénom ou matricule..."
                                class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                        </div>

                        <div class="flex gap-3">

                            <select id="filterYear"
                                name="annee_etude"
                                class="px-4 py-2.5 border border-gray-200 rounded-lg  focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm bg-white">

                                <option value="">Toutes les années</option>

                                <option value="1"
                                    {{ request('annee_etude') == 1 ? 'selected' : '' }}>
                                    1ère année
                                </option>

                                <option value="2"
                                    {{ request('annee_etude') == 2 ? 'selected' : '' }}>
                                    2ème année
                                </option>

                                <option value="3"
                                    {{ request('annee_etude') == 3 ? 'selected' : '' }}>
                                    3ème année
                                </option>

                            </select>

<select id="filterFiliere"
    name="filiere"
    class="px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm bg-white">

    <option value="">Toutes les filières</option>

    @foreach($filieres as $filiere)
        <option value="{{ $filiere->id }}"
            {{ request('filiere') == $filiere->id ? 'selected' : '' }}>

            {{ $filiere->nom }}

        </option>
    @endforeach

</select>
                        </div>

                    </div>
                </div>

            </form>


            <!-- Students Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden fade-in" style="animation-delay: 0.2s;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Matricule</th>
                                <th class="px-6 py-4 font-semibold">Nom & Prénoms</th>
                                <th class="px-6 py-4 font-semibold">Filière</th>
                                <th class="px-6 py-4 font-semibold">Année d'étude</th>
                                <th class="px-6 py-4 font-semibold">Statut</th>
                                <th class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm" id="studentsTableBody">
                            
                            @forelse($etudiants as $etudiant)

                            <tr class="hover:bg-gray-50 transition-colors">

                                <td class="px-6 py-4 font-mono text-sm text-gray-900 font-medium">
                                    {{ $etudiant->matricule }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">

                                        <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs">
                                            <img src="{{ $etudiant->photo_url }}" alt="">
                                        </div>

                                        <div>
                                            <p class="font-medium text-gray-900">
                                                {{ $etudiant->nom }} {{ $etudiant->prenom }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{  $etudiant->filiere->nom  }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">

                                    @if($etudiant->annee_etude == 1)
                                    1ère année
                                    @elseif($etudiant->annee_etude == 2)
                                    2ème année
                                    @else
                                    3ème année
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">

                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                        Actif

                                    </span>

                                </td>

                                <td class="px-6 py-4 text-right">

                                    <div class="flex items-center justify-end gap-2">

                                        <!-- Voir -->

                                        <button
    type="button"
    onclick="openViewModal(
        '{{ $etudiant->matricule }}',
        '{{ $etudiant->nom }}',
        '{{ $etudiant->prenom }}',
        '{{ $etudiant->filiere->nom }}',
        '{{ $etudiant->annee_etude }}',
        `{{ $etudiant->anneeEntree?->libelle ?? '' }}`,
        '{{ $etudiant->telephone }}',
        '{{ $etudiant->sexe }}'
    )"
                            class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Voir">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>

                                        </button>

                                        <!-- Modifier -->

   <button
    type="button"

    data-id="{{ $etudiant->id }}"
    data-nom="{{ $etudiant->nom }}"
    data-prenom="{{ $etudiant->prenom }}"
    data-telephone="{{ $etudiant->telephone }}"
    data-filiere="{{ $etudiant->filiere_id }}"
    data-annee="{{ $etudiant->annee_etude }}"
    
   data-annee-entree="{{ $etudiant->annee_entree_id ?? '' }}"
    data-photo="{{ $etudiant->photo ? asset('storage/'.$etudiant->photo) : '' }}"
                                            class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors  edit-btn"
                                            title="Modifier">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 24 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon lucide-pencil-line"><path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>

                                        </button>

                                        <!-- Supprimer -->

                                        <button
                                            type="button"
                                            onclick="openDeleteModal(
        `{{ route('etudiants.destroy', $etudiant->id) }}`,
        `{{ $etudiant->nom }} {{ $etudiant->prenom }}`
    )"
                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Supprimer">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                           

                                        </button>


                                    </div>

                                </td>

                            </tr>

                            
           @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="py-16 text-center">

                                    <i
                                        data-lucide="folder-open"
                                        class="w-10 h-10 mx-auto text-slate-300 mb-3">
                                    </i>

                                    <p class="text-slate-500">

                                        Aucun étudiant trouvé.

                                    </p>

                                </td>

                            </tr>
@endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between bg-gray-50">
                    <p id="paginationText"
                        class="text-sm text-gray-500 transition-all duration-300">

                        Affichage de

                        <span class="font-medium text-gray-900">
                            {{ $etudiants->firstItem() ?? 0 }}
                        </span>

                        à

                        <span class="font-medium text-gray-900">
                            {{ $etudiants->lastItem() ?? 0 }}
                        </span>

                        sur

                        <span class="font-medium text-gray-900">
                            {{ $etudiants->total() }}
                        </span>

                        résultats

                    </p>
                    <div class="flex gap-2">

                        @if($etudiants->onFirstPage())

                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-400 opacity-50 cursor-not-allowed">
                            Précédent
                        </button>

                        @else

                        <a href="{{ $etudiants->previousPageUrl() }}"
                            class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-all duration-200">
                            Précédent
                        </a>

                        @endif

                        @if($etudiants->hasMorePages())

                        <a href="{{ $etudiants->nextPageUrl() }}"
                            class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-all duration-200">
                            Suivant
                        </a>

                        @else

                        <button
                            class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-400 opacity-50 cursor-not-allowed">
                            Suivant
                        </button>

                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="text-center py-6 text-sm text-gray-500">
                <p> © 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication.</p>
            </footer>
        </main>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute inset-0" onclick="closeModal('addStudentModal')"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col pointer-events-auto fade-in">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Ajouter un nouvel étudiant</h3>
                    <button onclick="closeModal('addStudentModal')" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>

                    </button>
                </div>
                <div class="p-6 overflow-y-auto">
                    <form method="POST" action="{{ route('etudiants.store') }}" id="addStudentForm" class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Matricule <span class="text-red-500">*</span></label>
                            <input type="text" value="{{old('matricule')}}" required placeholder="Ex: 2024-LM-0043" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2   {{ $errors->has('matricule') 
                             ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                             : 'border-gray-300 focus:ring-blue-300' }} focus:ring-primary-500 focus:border-transparent text-sm" name="matricule">
       @error('matricule')
                <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                    <span>⚠</span> {{ $message }}
                </p>
            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom <span class="text-red-500">*</span></label>
                            <input type="text" value="{{old('nom')}}"  required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500   {{ $errors->has('nom') 
                                 ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                                 : 'border-gray-300 focus:ring-blue-300' }} focus:border-transparent text-sm" name="nom">
                                               @error('nom')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Prénoms <span class="text-red-500">*</span></label>
                            <input type="text" value="{{old('prenom')}}"  required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2   {{ $errors->has('prenom') 
                                 ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                                 : 'border-gray-300 focus:ring-blue-300' }}focus:ring-primary-500 focus:border-transparent text-sm" name="prenom">
                                      @error('prenom')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Date de naissance</label>
                            <input type="date"  value="{{ old('date_naissance') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg   {{ $errors->has('date_naissance') 
                                 ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                                 : 'border-gray-300 focus:ring-blue-300' }} focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm" name="date_naissance">
                                       @error('date_naissance')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Lieu de naissance</label>
                            <input type="text"   value="{{ old('lieu_naissance') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2   {{ $errors->has('lieu_naissance') 
                                 ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                                 : 'border-gray-300 focus:ring-blue-300' }}focus:ring-primary-500 focus:border-transparent text-sm" name="lieu_naissance">
                             @error('lieu_naissance')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                                </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Sexe <span class="text-red-500">*</span></label>
                            <select required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500   {{ $errors->has('sexe') 
                                 ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                                 : 'border-gray-300 focus:ring-blue-300' }} focus:border-transparent text-sm bg-white" name="sexe">
                                <option value="">Sélectionner...</option>
                                <option value="Masculin" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="Féminin" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                                @error('sexe')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Telephone</label>
                            <input type="tel"  value="{{ old('telephone') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500    {{ $errors->has('telephone') 
                             ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                             : 'border-gray-300 focus:ring-blue-300' }} focus:border-transparent text-sm" name="telephone">
                                @error('telephone')
                <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Filière <span class="text-red-500">*</span></label>
                            <select required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none   {{ $errors->has('filiere_id') 
                              ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                              : 'border-gray-300 focus:ring-blue-300' }} focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm bg-white" name="filiere_id">
                                <option value="">
                                    Choisir une filière
                                </option>

                                @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}"   {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                     {{ $filiere->nom }}
                                </option>
                                @endforeach

                            </select>
   @error('filiere_id')
                <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
            @enderror

                        </div>


                        <div>

    <label class="block mb-2 text-sm font-medium">

        Année académique d'entrée

    </label>

    <select
        name="annee_entree_id"
        class="w-full border rounded-lg px-4 py-3">

        <option value="">

            Sélectionner...

        </option>

        @foreach($anneesAcademiques as $annee)

            <option
                value="{{ $annee->id }}">

                {{ $annee->libelle }}

            </option>

        @endforeach

    </select>

</div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Année d'étude <span class="text-red-500">*</span></label>
                            <select required class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500   {{ $errors->has('annee_etude') 
                                  ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                                  : 'border-gray-300 focus:ring-blue-300' }} focus:border-transparent text-sm bg-white" name="annee_etude">
                                <option value="">Sélectionner...</option>
                                <option value="1">1ère année (Semestres 1 & 2)</option>
                                <option value="2">2ème année (Semestres 3 & 4)</option>
                                <option value="3">3ème année (Semestres 5 & 6)</option>
                            </select>
                                @error('annee_etude')
                    <p class="mt-1 text-xs text-red-500">⚠ {{ $message }}</p>
                @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe par défaut</label>
                            <div class="flex gap-2">
                                <input type="text" value="IRSBAC2024!" readonly class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600 text-sm font-mono">
                                <button type="button" class="px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">Générer</button>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">L'étudiant pourra modifier ce mot de passe lors de sa première connexion.</p>
                        </div>

                </div>
                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end gap-3">
                    <button onclick="closeModal('addStudentModal')" class="px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-colors text-sm">Annuler</button>
                    <button type="submit" class="px-4 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors text-sm flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i> Enregistrer l'étudiant
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Excel Modal -->


    <div id="importModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute inset-0" onclick="closeModal('importModal')"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">

            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg pointer-events-auto fade-in">

                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">
                        Importer des étudiants via Excel
                    </h3>

                    <button onclick="closeModal('importModal')"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">

                        
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>


                    </button>
                </div>

                <form action="{{ route('admin.import') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="p-6 space-y-5">


                        <div
                            class="border-2 border-dashed border-gray-300 rounded-xl p-6 sm:p-8 text-center hover:border-primary-500 hover:bg-primary-50 transition-colors cursor-pointer"
                            onclick="document.getElementById('excelFile').click()">

                            <i data-lucide="file-spreadsheet"
                                class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400 mx-auto mb-3">
                            </i>

                            <p class="text-sm sm:text-base font-medium text-gray-900">
                                Cliquez pour sélectionner un fichier Excel
                            </p>

                            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                Formats acceptés : .xlsx, .xls (Max 5MB)
                            </p>

                            <input
                                type="file"
                                name="excel_file"
                                id="excelFile"
                                class="hidden"
                                accept=".xlsx,.xls"
                                onchange="handleFileSelect(this)"
                                required>
                        </div>

                        <div id="fileNameDisplay"
                            class="hidden flex items-center gap-2 p-3 bg-emerald-50 border border-emerald-200 rounded-lg">

                            <i data-lucide="check-circle"
                                class="w-4 h-4 text-emerald-600">
                            </i>

                            <span id="fileNameText"
                                class="font-medium text-sm text-emerald-800 truncate">
                            </span>

                        </div>

                        <a href="{{route('etudiants.modele')}}"
                            class="flex items-center justify-center gap-2 text-sm text-primary-600 hover:text-primary-700 font-medium">

                             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>

                            Télécharger le modèle Excel 

                        </a>

                    </div>

                    <div
                        class="p-4 sm:p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl flex flex-col sm:flex-row justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeModal('importModal')"
                            class="w-full sm:w-auto px-4 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-colors">

                            Annuler

                        </button>

                        <button
                            type="submit"
                            id="importBtn"
                            disabled
                            class="w-full sm:w-auto px-4 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">

                            Lancer l'importation

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>



    <!-- Toast Notification -->
    @if(session('success'))
    <div id="toast"
        class="fixed top-4 right-4 z-50 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3">

        <i data-lucide="check-circle-2" class="w-5 h-5"></i>

        <div>
            <p class="font-semibold">Succès</p>
            <p class="text-sm text-emerald-100">
                {{ session('success') }}
            </p>
        </div>

    </div>
    @endif



    <!-- Modal de lecture d'information etudiants -->

    <div id="viewStudentModal" class="fixed inset-0 z-50 hidden">

        <div class="absolute inset-0 bg-black/50"
            onclick="closeViewModal()">
        </div>

        <div class="absolute inset-0 flex items-center justify-center p-4">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden">

                <!-- Header -->
                <div class="flex justify-between items-center p-3 border-b">

                    <h2 class="text-xl font-bold text-gray-800">
                        Informations de l'étudiant
                    </h2>

                    <button onclick="closeViewModal()"
                        class="text-gray-500 hover:text-red-500">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>

                    </button>

                </div>

                <!-- Contenu -->
                <div class="p-6 space-y-2">

                    <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Matricule
                        </label>

                        <p id="viewMatricule"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Nom
                        </label>

                        <p id="viewNom"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Prénom
                        </label>

                        <p id="viewPrenom"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Filière
                        </label>

                        <p id="viewFiliere"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Année d'étude
                        </label>

                        <p id="viewAnnee"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>


                            <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Année d'entrrée académique
                        </label>

                        <p id="viewAnneeEntree"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Téléphone
                        </label>

                        <p id="viewTelephone"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-semibold text-gray-500">
                            Sexe
                        </label>

                        <p id="viewSexe"
                            class="text-gray-800 font-medium">
                        </p>
                    </div>

                </div>

                <!-- Footer -->
                <div class="p-3 border-t bg-gray-50 flex justify-end">

                    <button
                        onclick="closeViewModal()"
                        class="px-5 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">

                        Fermer

                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- Modal d'edition -->
     
    <div id="editStudentModal" class="fixed inset-0 z-50 hidden">

        <div class="absolute inset-0 bg-black/50"
            onclick="closeEditModal()">
        </div>

        <div class="absolute inset-0 flex items-center justify-center p-4">

            <div class="bg-white rounded-2xl shadow-2xl
                    w-full max-w-3xl
                    max-h-[90vh]
                    overflow-y-auto">

                <!-- Header -->
                <div class="flex justify-between items-center p-6 border-b">

                    <h2 class="text-xl font-bold text-gray-800">
                        Modifier l'étudiant
                    </h2>

                    <button onclick="closeEditModal()">

                        <i data-lucide="x"
                            class="w-6 h-6 text-gray-500 hover:text-red-500">
                        </i>

                    </button>

                </div>

                <!-- Formulaire -->
                <form id="editForm" method="POST" action="" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div>
                                <label class="block mb-2 text-sm font-medium">
                                    Nom
                                </label>

                                <input
                                    type="text"
                                    name="nom"
                                    id="editNom"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium">
                                    Prénom
                                </label>

                                <input
                                    type="text"
                                    name="prenom"
                                    id="editPrenom"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium">
                                    Téléphone
                                </label>

                                <input
                                    type="text"
                                    name="telephone"
                                    id="editTelephone"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium">
                                    Filière
                                </label>

                                <select
                                    name="filiere"
                                    id="editFiliere"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                      @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}">
                                     {{ $filiere->nom }}
                                </option>
                                @endforeach

                                </select>
                            </div>


     <div>
                                <label class="block mb-2 text-sm font-medium">
                                    Année académique d'entrée
                                </label>                        
<select
    name="annee_entree_id">

    @foreach($anneesAcademiques as $annee)

        <option
            value="{{ $annee->id }}"

            @selected($etudiant->annee_entree_id==$annee->id ?? '')>

            {{ $annee->libelle }}

        </option>

    @endforeach

</select>

</div>
   <div>
                                <label class=" mb-2 text-sm font-medium">
                                    En règle
                                </label>

                                <input
                                    type="checkbox"
                                    name="est_en_regle"
                                    value="1"
                                    id="editStatut"
                                    class=" border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500"
                                    {{$etudiant->est_en_regle ? 'checked': ''}}
                                    >
                            </div>

                            <div class="md:col-span-2">

    <label class="block mb-2 text-sm font-medium">
        Photo de profil
    </label>

    <div class="flex items-center gap-6">

        <div>
            <img
                id="photoPreview"
                src="https://via.placeholder.com/120x120?text=Photo"
                class="w-28 h-28 rounded-full object-cover border-4 border-gray-200 shadow">
        </div>

        <div class="flex-1">

            <input
                type="file"
                name="photo"
                id="editPhoto"
                accept="image/*"
                onchange="previewPhoto(event)"
                class="block w-full text-sm text-gray-500
                file:mr-4
                file:py-2
                file:px-4
                file:rounded-lg
                file:border-0
                file:text-sm
                file:font-semibold
                file:bg-primary-50
                file:text-primary-700
                hover:file:bg-primary-100">

            <p class="text-xs text-gray-500 mt-2">
                JPG, JPEG ou PNG - Maximum 2 Mo
            </p>

        </div>

    </div>

</div>

                            <div class="md:col-span-2">
                                <label class="block mb-2 text-sm font-medium">
                                    Année d'étude
                                </label>

                                <select
                                    name="annee_etude"
                                    id="editAnnee"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                    <option value="1">1ère année</option>
                                    <option value="2">2ème année</option>
                                    <option value="3">3ème année</option>

                                </select>
                            </div>

                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="border-t bg-gray-50 p-6 flex flex-col sm:flex-row justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeEditModal()"
                            class="px-5 py-3 border border-gray-300 rounded-lg">

                            Annuler

                        </button>

                        <button
                            type="submit"
                            class="px-5 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700">

                            Enregistrer

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- Modal de suppression -->
    <div id="deleteModal"
        class="fixed inset-0 z-50 hidden">

        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">

            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md animate-fadeIn">

                <div class="p-6 text-center">

                    <div class="mx-auto mb-4 w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                        <i data-lucide="trash-2"
                            class="w-8 h-8 text-red-600"></i>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900">
                        Supprimer l'étudiant
                    </h3>

                    <p class="mt-3 text-gray-600">
                        Êtes-vous sûr de vouloir supprimer
                        <span id="studentName"
                            class="font-semibold text-gray-900">
                        </span> ?
                    </p>

                    <p class="mt-2 text-sm text-red-500">
                        Cette action est irréversible.
                    </p>

                </div>

                <form id="deleteForm"
                    method="POST" action="">

                    @csrf
                    @method('DELETE')

                    <div class="p-6 border-t border-gray-200 flex justify-end gap-3">

                        <button
                            type="button"
                            onclick="closeDeleteModal()"
                            class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">

                            Annuler

                        </button>

                        <button
                            type="submit"
                            class="px-4 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700">

                            Supprimer

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        //  onsubmit="event.preventDefault(); saveStudent();   onclick="saveStudent()""
        


function openEditModal(
    id,
    nom,
    prenom,
    telephone,
    filiere,
    annee,
    photo,
    
)
{
    document.getElementById('editNom').value = nom;
    document.getElementById('editPrenom').value = prenom;
    document.getElementById('editTelephone').value = telephone;
    document.getElementById('editFiliere').value = filiere;
    document.getElementById('editAnnee').value = annee;

    document.getElementById('editForm').action =
        '/admin/etudiants/' + id;

    document.getElementById('photoPreview').src =
        photo && photo !== ''
            ? photo
            : 'https://via.placeholder.com/120x120?text=Photo';

    document
        .getElementById('editStudentModal')
        .classList
        .remove('hidden');
}

function closeEditModal()
{
    document
        .getElementById('editStudentModal')
        .classList
        .add('hidden');
}

/*
|--------------------------------------------------------------------------
| Boutons Modifier
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.edit-btn')
        .forEach(function(button) {

            button.addEventListener('click', function() {

                openEditModal(
                    this.dataset.id,
                    this.dataset.nom,
                    this.dataset.prenom,
                    this.dataset.telephone,
                    this.dataset.filiere,
                    this.dataset.annee,
                    this.dataset.photo
                );

            });

        });

});

/*
|--------------------------------------------------------------------------
| Aperçu photo
|--------------------------------------------------------------------------
*/

function previewPhoto(event)
{
    const file = event.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(e)
    {
        document
            .getElementById('photoPreview')
            .src = e.target.result;
    };

    reader.readAsDataURL(file);
}



function previewPhoto(event)
{
    const reader = new FileReader();

    reader.onload = function()
    {
        document
            .getElementById('photoPreview')
            .src = reader.result;
    };

    reader.readAsDataURL(
        event.target.files[0]
    );
}


        function handleFileSelect(input) {
            if (input.files.length > 0) {
                document
                    .getElementById('fileNameDisplay')
                    .classList.remove('hidden');

                document
                    .getElementById('fileNameText')
                    .textContent = input.files[0].name;

                document
                    .getElementById('importBtn')
                    .disabled = false;
            }
        }


        function closeEditModal() {
            document
                .getElementById('editStudentModal')
                .classList.add('hidden');
        }


       function openViewModal(
    matricule,
    nom,
    prenom,
    filiere,
    annee,
    anneeEntree,
    telephone,
    sexe
) {
    document.getElementById('viewMatricule').textContent = matricule;
    document.getElementById('viewNom').textContent = nom;
    document.getElementById('viewPrenom').textContent = prenom;
    document.getElementById('viewFiliere').textContent = filiere;
    document.getElementById('viewAnnee').textContent = annee;

    document.getElementById('viewAnneeEntree').textContent =
        anneeEntree || "Non renseignée";

    document.getElementById('viewTelephone').textContent = telephone;
    document.getElementById('viewSexe').textContent = sexe;

    document
        .getElementById('viewStudentModal')
        .classList.remove('hidden');

    lucide.createIcons();
}

        function closeViewModal() {
            document
                .getElementById('viewStudentModal')
                .classList.add('hidden');
        }

        //toast

        document.addEventListener('DOMContentLoaded', function() {

            const toast = document.getElementById('toast');

            if (toast) {

                // Affichage
                setTimeout(() => {
                    toast.classList.remove('translate-x-full');
                }, 100);

                // Disparition après 4 secondes
                setTimeout(() => {
                    toast.classList.add('translate-x-full');

                    setTimeout(() => {
                        toast.remove();
                    }, 500);

                }, 4000);
            }

            // Recharge les icônes Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        function openDeleteModal(actionUrl, studentName) {
            document.getElementById('deleteModal')
                .classList.remove('hidden');

            document.getElementById('studentName')
                .textContent = studentName;

            document.getElementById('deleteForm')
                .action = actionUrl;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal')
                .classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('filterForm');
            const search = document.getElementById('searchInput');
            const year = document.getElementById('filterYear');
            const filiere = document.getElementById('filterFiliere');

            let timeout;

            search.addEventListener('keyup', function() {

                clearTimeout(timeout);

                timeout = setTimeout(() => {
                    form.submit();
                }, 1000);

            });

            year.addEventListener('change', function() {
                form.submit();
            });

            filiere.addEventListener('change', function() {
                form.submit();
            });

        });


        

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            if (modalId === 'importModal') {
                document.getElementById('excelFile').value = '';
                document.getElementById('fileNameDisplay').classList.add('hidden');
                document.getElementById('importBtn').disabled = true;
            }
        }

 
        function saveStudent() {
            const form = document.getElementById('addStudentForm');
            if (form.checkValidity()) {
                const btn = event.target.closest('button');
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div> Enregistrement...';
                btn.disabled = true;

                setTimeout(() => {
                    closeModal('addStudentModal');
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    form.reset();
                    showToast('L\'étudiant a été ajouté avec succès.', 'Succès');
                }, 1000);
            } else {
                form.reportValidity();
            }
        }

        function showToast(message, title = "Information", isError = false) {
            const toast = document.getElementById('toast');
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;

            const icon = toast.querySelector('i');
            if (isError) {
                icon.setAttribute('data-lucide', 'x-circle');
                icon.classList.remove('text-emerald-400');
                icon.classList.add('text-red-400');
            } else {
                icon.setAttribute('data-lucide', 'check-circle-2');
                icon.classList.remove('text-red-400');
                icon.classList.add('text-emerald-400');
            }
            lucide.createIcons();

            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3500);
        }

        // Initial render
        
    </script>
</body>

</html>