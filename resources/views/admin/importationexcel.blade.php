<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importation Excel - Administration IRSBAC</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/400.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/500.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/600.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/700.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e3a8a',
                            900: '#172554',
                        }
                    }
                }
            }
        }
    </script>
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

        .toast {
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .toast.show {
            transform: translateX(0);
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
  <img src="{{asset('storage/logo_irsbac/logo.png')}}" alt="IRSBAC Logo" class="w-13 h-13 object-contain rounded-lg p-1">
            <div>
                <h1 class="text-lg font-bold tracking-wide">IRSBAC</h1>
                <p class="text-xs text-blue-200">Espace Administration</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
            <a href="{{route('admin.dashboard')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>Tableau de bord
            </a>
            <a href="{{route('admin.gestionetudiant')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg> Gestion des Étudiants
            </a>
            <a href="{{route('imports.create')}}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sheet-icon lucide-sheet"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="3" x2="21" y1="15" y2="15"/><line x1="9" x2="9" y1="9" y2="21"/><line x1="15" x2="15" y1="9" y2="21"/></svg>
                 Importation Excel
            </a>
            <a href="{{route('admin.generationdoc')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
 Génération de Documents
            </a>
            <a href="{{route('admin.modele_signature')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-template-icon lucide-layout-template"><rect width="18" height="7" x="3" y="3" rx="1"/><rect width="9" height="7" x="3" y="14" rx="1"/><rect width="5" height="7" x="16" y="14" rx="1"/></svg> Modèles & Signatures
            </a>
             <a href="{{ route('ues.store') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                 UE & ECUE
            </a>
           <!-- <a href="#" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <i data-lucide="shield-check" class="w-5 h-5"></i> Journal d'audit
            </a> -->
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


    <div class="lg:ml-64 max-w-7xl mx-auto p-6">

        
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Importation des données académiques
            </h1>

            <p class="mt-2 text-gray-600">
                Cette interface permet d'importer les étudiants et les notes
                depuis des fichiers Excel afin d'alimenter automatiquement
                le système de gestion académique.
            </p>

        </div>


      

        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow border overflow-hidden">

            <div class="border-b">

                <div class="flex">

                    <button
                        id="studentTab"
                        type="button"
                        onclick="showStudents()"
                        class="tab-btn active">

                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>

                        <span>Import des Étudiants</span>

                    </button>

                    <button
                        id="noteTab"
                        type="button"
                        onclick="showNotes()"
                        class="tab-btn">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap"><path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>


                        <span>Import des Notes</span>

                    </button>

                </div>

            </div>

            <!-- IMPORT ETUDIANTS -->

            <div id="studentsView" class="p-6">








                <form action="{{ route('admin.import') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="p-6 space-y-5">


                        <div
                            class="border-2 border-dashed border-gray-300 rounded-xl p-6 sm:p-8 text-center hover:border-primary-500 hover:bg-primary-50 transition-colors cursor-pointer"
                            onclick="document.getElementById('excelFile').click()">

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
                            type="submit"
                            id="importBtn"
                            disabled
                            class="w-full sm:w-auto px-4 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">

                            Lancer l'importation

                        </button>

                    </div>

                </form>










               <!-- <form
                    action="{{ route('admin.import') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf

                    <div class="grid lg:grid-cols-2 gap-6">

                        <div>

                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-5">

                                <h3 class="font-bold text-lg mb-4">
                                    Format requis
                                </h3>

                                <ul class="space-y-2 text-sm">

                                    <li>• Matricule</li>
                                    <li>• Nom</li>
                                    <li>• Prenoms</li>
                                    <li>• Date_naissance</li>
                                    <li>• Lieu_naissance</li>
                                    <li>• Filiere</li>
                                    <li>• Annee_etude</li>

                                </ul>

                            </div>

                            <a
                                href=""
                                class="mt-4 flex justify-center items-center gap-2 border rounded-xl py-3 hover:bg-gray-50">

                                <i data-lucide="download"></i>

                                Télécharger le modèle

                            </a>

                        </div>

                        <div>

                            <label class="cursor-pointer">

                                <input
                                    type="file"
                                    hidden
                                    name="fichier"
                                    id="studentFile">

                                <div class="upload-zone">

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-cloud-upload-icon lucide-cloud-upload"><path d="M12 13v8"/><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="m8 17 4-4 4 4"/></svg>

                                    <p class="font-medium mt-3">
                                        Cliquez ou glissez votre fichier
                                    </p>

                                    <p
                                        id="studentFileName"
                                        class="text-sm text-gray-500 mt-2">

                                        .xlsx / .xls

                                    </p>

                                </div>

                            </label>

                            <button type="button"
                                class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                                Importer les étudiants

                            </button>

                        </div>

                    </div>

                </form>-->

            </div>

            <!-- IMPORT NOTES -->

            <div id="notesView" class="hidden p-6">

                    
            





<div class="max-w-4xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Import centralisé des notes</h2>

    @if ($errors->any())
        <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-4">
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 rounded-md border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('erreurs') && count(session('erreurs')))
        <div class="mb-6 rounded-md border border-amber-200 bg-amber-50 p-4">
            <p class="text-sm font-medium text-amber-800 mb-1">Certaines lignes n'ont pas pu être importées :</p>
            <ul class="list-disc list-inside text-sm text-amber-700 space-y-1">
                @foreach (session('erreurs') as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('colonnesIgnorees') && count(session('colonnesIgnorees')))
        <div class="mb-6 rounded-md border border-amber-200 bg-amber-50 p-4 text-sm text-amber-700">
            <span class="font-medium">Colonnes non reconnues (ignorées) :</span>
            {{ implode(', ', session('colonnesIgnorees')) }}
        </div>
    @endif

    {{-- Étape 1 : générer et télécharger le modèle --}}
    <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Étape 1 — Télécharger le modèle</h3>

        <form action="{{ route('notes.modele') }}" method="GET">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                    <select name="filiere_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Choisir --</option>
                        @foreach($filieres as $f)
                            <option value="{{ $f->id }}">{{ $f->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Niveau</label>
                    <select name="annee_etude" required
                        class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1">L1</option>
                        <option value="2">L2</option>
                        <option value="3">L3</option>
                    </select>
                </div>

            

              

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Télécharger
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Étape 2 : renvoyer le fichier rempli --}}
    <div class="bg-white border border-gray-200 rounded-lg p-6">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Étape 2 — Importer le fichier rempli</h3>

        <form action="{{ route('notes.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Année académique</label>
                    <select name="annee_academique_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($annees as $a)
                            <option value="{{ $a->id }}">{{ $a->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fichier rempli</label>
                    <input type="file" name="fichier" accept=".xlsx,.csv" required
                        class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 border border-gray-300 rounded-md">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full inline-flex justify-center items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                        Importer les notes
                    </button>
                </div>
            </div>
        </form>

        <p class="mt-3 text-xs text-gray-500">
            Réutilisez le fichier téléchargé à l'étape 1 — un fichier vierge ne contiendra pas les identifiants d'ECU nécessaires à l'import.
        </p>
    </div>
</div>









            </div>

        </div>
    

    </div>

    <style>
        .tab-btn {
            padding: 16px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 3px solid transparent;
        }

        .tab-btn.active {
            color: #2563eb;
            border-color: #2563eb;
        }

        .upload-zone {
          
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
        }
    </style>

    <script>



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
        function showStudents() {
            studentsView.classList.remove('hidden');
            notesView.classList.add('hidden');

            studentTab.classList.add('active');
            noteTab.classList.remove('active');
        }

        function showNotes() {
            notesView.classList.remove('hidden');
            studentsView.classList.add('hidden');

            noteTab.classList.add('active');
            studentTab.classList.remove('active');
        }

        const ecueSelect =
            document.getElementById('ecueSelect');

        const ueDisplay =
            document.getElementById('ueDisplay');

        function updateUe() {
            ueDisplay.value =
                ecueSelect.selectedOptions[0]
                .dataset.ue;
        }

        if (ecueSelect) {
            updateUe();

            ecueSelect.addEventListener(
                'change',
                updateUe
            );
        }

        document
            .getElementById('studentFile')
            .addEventListener(
                'change',
                function() {
                    document.getElementById(
                            'studentFileName'
                        ).innerText =
                        this.files[0]?.name ?? '';
                });

        document
            .getElementById('noteFile')
            .addEventListener(
                'change',
                function() {
                    document.getElementById(
                            'noteFileName'
                        ).innerText =
                        this.files[0]?.name ?? '';
                });

        lucide.createIcons();
    </script>






    <script>
        

        let currentTab = 'students';

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function switchTab(tab) {
            currentTab = tab;

            // Update tab styles
            document.getElementById('tab-students').className = tab === 'students' ? 'tab-active py-4 text-sm font-medium transition-colors flex items-center gap-2' : 'tab-inactive py-4 text-sm font-medium transition-colors flex items-center gap-2';
            document.getElementById('tab-grades').className = tab === 'grades' ? 'tab-active py-4 text-sm font-medium transition-colors flex items-center gap-2' : 'tab-inactive py-4 text-sm font-medium transition-colors flex items-center gap-2';

            // Show/hide content
            document.getElementById('content-students').classList.toggle('hidden', tab !== 'students');
            document.getElementById('content-grades').classList.toggle('hidden', tab !== 'grades');

            lucide.createIcons();
        }





        function buildPreview(rows) {
            const tbody =
                document.getElementById(
                    'preview-body-students'
                );

            tbody.innerHTML = '';

            rows.slice(0, 3).forEach(row => {

                tbody.innerHTML += `
            <tr>
                <td class="px-3 py-2 font-mono">
                    ${row.Matricule ?? ''}
                </td>

                <td class="px-3 py-2">
                    ${row.Nom ?? ''}
                </td>

                <td class="px-3 py-2">
                    ${row.Prénoms ?? ''}
                </td>

                <td class="px-3 py-2">
                    ${row.Filiere ?? ''}
                </td>

                <td class="px-3 py-2">
                    ${row.Annee_etude ?? ''}
                </td>

                <td class="px-3 py-2 text-center">
                    <span class="text-emerald-600 font-medium">
                        ✓ Valide
                    </span>
                </td>
            </tr>
        `;
            });
        }


      

        function clearFile(type) {
            document.getElementById(`file-${type}`).value = '';
            document.getElementById(`file-info-${type}`).classList.add('hidden');
            document.getElementById(`preview-${type}`).classList.add('hidden');
            document.getElementById(`progress-${type}`).classList.add('hidden');
            document.getElementById(`dropzone-${type}`).classList.remove('hidden');
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
            }, 3000);
        }

      
    </script>

</body>

</html>