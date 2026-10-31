<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administration - IRSBAC</title>
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

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .toast {
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toast.show {
            transform: translateX(0);
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
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                Tableau de bord
            </a>
            <a href="{{ route('admin.gestionetudiant') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <circle cx="9" cy="7" r="4" />
                </svg>
                Gestion des Étudiants
            </a>
            <a href="{{route('imports.create')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sheet-icon lucide-sheet">
                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                    <line x1="3" x2="21" y1="9" y2="9" />
                    <line x1="3" x2="21" y1="15" y2="15" />
                    <line x1="9" x2="9" y1="9" y2="21" />
                    <line x1="15" x2="15" y1="9" y2="21" />
                </svg>
                Importation Excel
            </a>
            <a href="{{ route('admin.generationdoc') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text">
                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                    <path d="M10 9H8" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                </svg>
                Génération de Documents
            </a>
            <a href="{{route('admin.modele_signature')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-template-icon lucide-layout-template">
                    <rect width="18" height="7" x="3" y="3" rx="1" />
                    <rect width="9" height="7" x="3" y="14" rx="1" />
                    <rect width="5" height="7" x="16" y="14" rx="1" />
                </svg>
                Modèles & Signatures
            </a>

            <a href="{{ route('ues.store') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap">
                    <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                    <path d="M22 10v6" />
                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                </svg>
                UE & ECUE
            </a>
            <a href="{{ route('admin.parametres') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings">
                    <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
                Paramètres
            </a>
        </nav>
        <div class="p-4 border-t border-primary-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-red-300 hover:bg-red-500/20 hover:text-red-100 rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out">
                        <path d="m16 17 5-5-5-5" />
                        <path d="M21 12H9" />
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    </svg>
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
                        <h2 class="text-xl font-bold text-gray-900">Tableau de Bord</h2>
                        <p class="text-sm text-gray-500">Vue d'ensemble de l'activité académique</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">

                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                        <div class="hidden sm:block text-right">
                            @if($info->directeur_etudes)
                            <p class="text-sm font-semibold text-gray-900">{{ $info->directeur_etudes}}</p>
                            <p class="text-xs text-gray-500">Directeur des Études</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-6">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 fade-in">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2.5 bg-blue-50 rounded-lg">
                            <i data-lucide="users" class="w-6 h-6 text-primary-600"></i>
                        </div>

                    </div>
                    <p class="text-sm text-gray-500 mb-1">Total Étudiants</p>
                    <p class="text-2xl font-bold text-gray-900">{{$nombreEtudiants}}</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2.5 bg-purple-50 rounded-lg">
                            <i data-lucide="file-check" class="w-6 h-6 text-purple-600"></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Documents Générés</p>
                    <p class="text-2xl font-bold text-gray-900">{{$documentsGeneres}}</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2.5 bg-emerald-50 rounded-lg">
                            <i data-lucide="trending-up" class="w-6 h-6 text-emerald-600"></i>
                        </div>

                    </div>
                    <p class="text-sm text-gray-500 mb-1">Signature et cachets</p>
                    <p class="text-2xl font-bold text-gray-900">4</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2.5 bg-amber-50 rounded-lg">
                            <i data-lucide="clock" class="w-6 h-6 text-amber-600"></i>
                        </div>
                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Action requise</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Imports en attente</p>
                    <p class="text-2xl font-bold text-gray-900">2</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="fade-in" style="animation-delay: 0.1s;">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Actions Rapides</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{route('imports.create')}}" class="flex items-center gap-4 p-4 bg-white border border-gray-200 rounded-xl hover:border-primary-500 hover:shadow-md transition-all group text-left">

                        <div class="p-3 bg-blue-50 rounded-lg group-hover:bg-primary-600 transition-colors">
                            <i data-lucide="upload-cloud" class="w-6 h-6 text-primary-600 group-hover:text-white transition-colors"></i>
                        </div>

                        <div>

                            <p class="font-semibold text-gray-900">Importer Étudiants</p>

                            <p class="text-xs text-gray-500">Via fichier Excel (.xlsx)</p>

                        </div>

                    </a>

                    <a href="{{route('imports.create')}}" class="flex items-center gap-4 p-4 bg-white border border-gray-200 rounded-xl hover:border-primary-500 hover:shadow-md transition-all group text-left">
                        <div class="p-3 bg-purple-50 rounded-lg group-hover:bg-purple-600 transition-colors">
                            <i data-lucide="file-spreadsheet" class="w-6 h-6 text-purple-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Importer les Notes</p>
                            <p class="text-xs text-gray-500">Par semestre et matière</p>
                        </div>
                    </a>


                    <button onclick="showToast('Redirection vers la gestion des modèles...')" class="flex items-center gap-4 p-4 bg-white border border-gray-200 rounded-xl hover:border-primary-500 hover:shadow-md transition-all group text-left">
                        <div class="p-3 bg-amber-50 rounded-lg group-hover:bg-amber-600 transition-colors">
                            <i data-lucide="pen-tool" class="w-6 h-6 text-amber-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Ajouter une fillière</p>
                        
                        </div>
                    </button>


                    <button onclick="openModal('addStudentModal')" class="flex items-center gap-4 p-4 bg-white border border-gray-200 rounded-xl hover:border-primary-500 hover:shadow-md transition-all group text-left">
                        <div class="p-3 bg-amber-50 rounded-lg group-hover:bg-emerald-600 transition-colors">
                            <i data-lucide="pen-tool" class="w-6 h-6 text-emerald-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Ajouter une Année Académique</p>

                        </div>
                    </button>



                </div>
            </div>

            <!-- Recent Activity & Stats Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in" style="animation-delay: 0.2s;">

                <!-- Recent Documents Table -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Dernières Générations de Documents</h3>

                        <a href="{{route('admin.generationdoc')}}" class="text-sm text-primary-600 hover:text-primary-700 font-medium flex items-center"> Voir tout <i data-lucide="arrow-right" class="w-4 h-4"></i></a>

                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Document</th>
                                    <th class="px-6 py-3 font-semibold">Étudiant</th>
                                    <th class="px-6 py-3 font-semibold">Date</th>
                                    <th class="px-6 py-3 font-semibold">Statut</th>

                                </tr>
                            </thead>





                            <tbody class="divide-y divide-gray-100 text-sm">

                                @foreach($derniersDocuments as $doc)

                                <tr>

                                    <td class="px-6 py-4">
                                        {{ $doc->type }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $doc->etudiant->nom ?? 'N/A' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $doc->created_at->format('d/m/Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-xs 
            {{ isset($doc->pdf_path) ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            Généré
                                        </span>
                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>
                    </div>
                </div>

                <!-- System Status & Info -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">État du Système</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-sm text-gray-700">Base de données MySQL</span>
                                </div>
                                <span class="text-xs font-medium text-emerald-600">Opérationnel</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-sm text-gray-700">Générateur PDF</span>
                                </div>
                                <span class="text-xs font-medium text-emerald-600">Opérationnel</span>
                            </div>
                            <div class="flex items-center justify-between">

                                <span class="text-xs font-medium text-emerald-600">Opérationnel</span>
                            </div>
                            <div class="pt-4 border-t border-gray-100">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-500">Espace disque utilisé</span>
                                    <span class="font-medium text-gray-900">45%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="bg-primary-600 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-primary-900 rounded-xl shadow-sm p-6 text-white">
                        <div class="flex items-start gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-blue-300 mt-0.5 flex-shrink-0"></i>
                            <div>
                                <h4 class="font-semibold mb-1">Rappel de sécurité</h4>
                                <p class="text-sm text-blue-200 leading-relaxed">
                                    Assurez-vous que tous les imports Excel respectent le modèle standardisé pour éviter les erreurs de traitement. Les fichiers doivent être au format .xlsx et contenir toutes les colonnes requises.
                                </p>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="text-center py-6 text-sm text-gray-500">
                <p>© 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication. Tous droits réservés.</p>
                <p class="mt-1">Parakou, Bénin • </p>
            </footer>
        </main>
    </div>



    <div id="addStudentModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute inset-0" onclick="closeModal('addStudentModal')"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col pointer-events-auto fade-in">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Ajouter une nouvelle Année Académique</h3>
                    <button onclick="closeModal('addStudentModal')" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>

                    </button>
                </div>
                <div class="p-6 overflow-y-auto">
                    
<form method="POST" action="{{ route('annees.store') }}" class="space-y-5">
        @csrf

        <div>
            <label for="libelle" class="block text-sm font-medium text-gray-700">Libellé</label>
            <input type="text" id="libelle" name="libelle" placeholder="2025-2026"
                   value="{{ old('libelle') }}"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('libelle') border-red-500 @enderror">
            @error('libelle')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4">

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Enregistrer
            </button>
        </div>
    </form>
                </div>
            </div>
        </div>
    </div>





    <!-- Toast Notification -->
    <div id="toast" class="toast fixed top-4 right-4 z-50 bg-gray-900 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 max-w-sm">
        <i data-lucide="info" class="w-5 h-5 text-blue-400 flex-shrink-0"></i>
        <div>
            <p class="font-semibold text-sm" id="toastTitle">Information</p>
            <p class="text-sm text-gray-300 mt-0.5" id="toastMessage">Message du système.</p>
        </div>
    </div>

    <script>
        // Initialize Lucide icons


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





        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function showToast(message, title = "Information") {
            const toast = document.getElementById('toast');
            document.getElementById('toastTitle').textContent = title;
            document.getElementById('toastMessage').textContent = message;

            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Close toast on click
        document.getElementById('toast').addEventListener('click', function() {
            this.classList.remove('show');
        });
    </script>
</body>

</html>