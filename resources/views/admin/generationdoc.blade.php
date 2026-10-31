<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Génération de Documents - Administration IRSBAC</title>
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

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .toast {
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .a4-preview {
            width: 210mm;
            min-height: 297mm;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            padding: 20mm;
            position: relative;
            transform-origin: top center;
        }

        @media (max-width: 768px) {
            .a4-preview {
                width: 100%;
                min-height: auto;
                padding: 15px;
                transform: scale(0.5);
            }
        }


        .toast-show {

            animation: toastShow .35s ease;

        }

        @keyframes toastShow {

            from {

                opacity: 0;

                transform: translateY(-15px);

            }

            to {

                opacity: 1;

                transform: translateY(0);

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
            <h1 class="text-lg font-bold tracking-wide">IRSBAC</h1>
            <p class="text-xs text-blue-200">Espace Administration</p>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sheet-icon lucide-sheet"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="3" x2="21" y1="15" y2="15"/><line x1="9" x2="9" y1="9" y2="21"/><line x1="15" x2="15" y1="9" y2="21"/></svg>
                 Importation Excel
            </a>
            <a href="{{route('admin.generationdoc')}}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
         Génération de Documents
            </a>
            <a href="{{route('admin.modele_signature')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-template-icon lucide-layout-template"><rect width="18" height="7" x="3" y="3" rx="1"/><rect width="9" height="7" x="3" y="14" rx="1"/><rect width="5" height="7" x="16" y="14" rx="1"/></svg>
                 Modèles & Signatures
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
                        <h2 class="text-xl font-bold text-gray-900">Génération de Documents</h2>
                        <p class="text-sm text-gray-500">Générez, prévisualisez et téléchargez les documents administratifs certifiés</p>
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

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 fade-in">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4" >
                    <div class="p-3 bg-blue-50 rounded-lg">  <svg xmlns="http://www.w3.org/2000/svg" width="20" class="text-blue-400" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg></div>
                    <div>
                        <p class="text-sm text-gray-500">Documents générés</p>
                        <p class="text-2xl font-bold text-gray-900">{{$documentsGeneres}}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-amber-50 rounded-lg"><i data-lucide="clock" class="w-6 h-6 text-amber-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">En attente de génération</p>
                        <p class="text-2xl font-bold text-gray-900">15</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 rounded-lg"><i data-lucide="check-circle-2" class="w-6 h-6 text-emerald-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Taux de succès</p>
                        <p class="text-2xl font-bold text-gray-900">98.5%</p>
                    </div>
                </div>
            </div>

            <!-- Filters & Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 fade-in" style="animation-delay: 0.1s;">
                <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                    <div class="flex flex-col sm:flex-row gap-3 flex-1 w-full">
                        <div class="relative flex-1">
                            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <form
                                method="GET"
                                class="flex flex-col sm:flex-row gap-3 flex-1 w-full">

                                <div class="relative flex-1">

                                    <i
                                        data-lucide="search"
                                        class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    </i>

                                    <input

                                        type="text"

                                        name="search"

                                        value="{{ request('search') }}"

                                        placeholder="Rechercher par matricule ou nom..."

                                        class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-lg"

                                        onkeyup="clearTimeout(window.searchTimer);

                     window.searchTimer=setTimeout(()=>this.form.submit(),500);">

                                </div>
                        </div>
                        <select

                            name="type"

                            onchange="this.form.submit()"

                            class="px-4 py-2.5 border rounded-lg">

                            <option value="">

                                Tous les types

                            </option>

                            <option

                                value="Relevé de notes"

                                @selected(request('type')=='Relevé de notes' )>

                                Relevé de notes

                            </option>

                            <option

                                value="Attestation de réussite"

                                @selected(request('type')=='Attestation de réussite' )>

                                Attestation de réussite

                            </option>

                        </select>

                        </form>

                    </div>
                    <button
                        type="button"
                        onclick="openGenerationModal()"
                        class="inline-flex items-center gap-2 bg-primary-700 hover:bg-primary-800 text-white px-5 py-3 rounded-xl font-medium transition">

                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap-icon lucide-zap"><path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/></svg>


                        Nouvelle génération

                    </button>
                </div>
            </div>

            <!-- Documents Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden fade-in" style="animation-delay: 0.2s;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Étudiant</th>
                                <th class="px-6 py-4 font-semibold">Type de document</th>
                                <th class="px-6 py-4 font-semibold">Date de génération</th>
                                <th class="px-6 py-4 font-semibold">Statut</th>
                                <th class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">

                            @forelse($documents as $document)

                            <tr class="hover:bg-slate-50 transition">

                                <!-- Etudiant -->

                                <td class="px-6 py-4">

                                    <div>

                                        <p class="font-semibold text-slate-800">

                                            {{ $document['nom'] }}
                                            {{ $document['prenom'] }}

                                        </p>

                                        <p class="text-xs text-slate-500">

                                            {{ $document['matricule'] }}

                                        </p>

                                    </div>

                                </td>

                                <!-- Type -->

                                <td class="px-6 py-4">

                                    @if($document['type'] == 'Attestation de réussite')

                                    <div>

                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">

                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award-icon lucide-award"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"/><circle cx="12" cy="8" r="6"/></svg>


                                            Attestation

                                        </span>

                                    </div>

                                    @else

                                    <div class="space-y-1">

                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">

                                              <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>

                                            Relevé semestre {{ $document['semestre'] ?? '-' }}

                                        </span>


                                    </div>

                                    @endif

                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 text-slate-600">

                                    {{ $document['date']->format('d/m/Y H:i') }}

                                </td>
                                <!-- Statut -->
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                        Disponible

                                    </span>

                                </td>

                                <!-- Actions -->

                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <!-- Aperçu -->

                                        <button
                                            type="button"

                                            data-pdf="{{ $document['route_preview'] }}"

                                            onclick="openPdfModal(this.dataset.pdf)"

                                            class="w-9 h-9 rounded-lg border border-slate-200 hover:bg-slate-100 flex items-center justify-center transition"

                                            title="Prévisualiser">

                                                <svg xmlns="http://www.w3.org/2000/svg" class="text-slate-600" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye-icon lucide-eye"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>

                                        </button>

                                        <!-- Supprimer -->

                                        <button

                                            type="button"

                                            onclick="openDeleteDocumentModal(

                    `{{ $document['route_delete'] }}`,

                    `{{ $document['nom'] }} {{ $document['prenom'] }}`,

                    `{{ $document['type'] }}`

                )"

                                            class="w-9 h-9 rounded-lg border border-red-200 hover:bg-red-50 flex items-center justify-center transition"

                                            title="Supprimer">

                                           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>


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

                                        Aucun document trouvé.

                                    </p>

                                </td>

                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div
                    class="px-6 py-4 border-t border-slate-200 bg-slate-50 ">

                    {{ $documents->withQueryString()->links() }}

                </div>
            </div>

            <!-- Footer -->
            <footer class="text-center py-6 text-sm text-gray-500">
                <p>© 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication.</p>
            </footer>
        </main>
    </div>



    <!----Modal appercu document--->
    <div
        id="pdfModal"
        class="fixed inset-0 z-50 hidden bg-black/70  items-center justify-center">

        <div class="bg-white rounded-xl w-[90%] h-[90%] shadow-xl overflow-hidden">

            <div class="flex justify-between items-center border-b p-4">

                <h3 class="font-semibold">
                    Aperçu du document
                </h3>

                <button onclick="closePdfModal()">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>


                </button>

            </div>

            <iframe

                id="pdfFrame"

                class="w-full h-full"

                src="">

            </iframe>

        </div>

    </div>


    <!-- Modal suppression document -->

    <div
        id="deleteDocumentModal"
        class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4">

            <div class="p-6">

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">

                        <i
                            data-lucide="trash-2"
                            class="w-7 h-7 text-red-600">
                        </i>

                    </div>

                    <div>

                        <h3 class="text-lg font-bold text-slate-900">

                            Supprimer le document

                        </h3>

                        <p class="text-sm text-slate-500">

                            Cette action est irréversible.

                        </p>

                    </div>

                </div>

                <div class="mt-6">

                    <p class="text-slate-700">

                        Voulez-vous vraiment supprimer le document de

                        <span
                            id="deleteStudentName"
                            class="font-semibold">
                        </span>

                        ?

                    </p>

                    <p
                        id="deleteDocumentType"
                        class="text-sm text-slate-500 mt-2">
                    </p>

                </div>

            </div>

            <div class="border-t px-6 py-4 flex justify-end gap-3">

                <button

                    type="button"

                    onclick="closeDeleteDocumentModal()"

                    class="px-5 py-2 rounded-lg border border-slate-300 hover:bg-slate-100">

                    Annuler

                </button>

                <form
                    id="deleteDocumentForm"
                    method="POST">

                    @csrf

                    @method('DELETE')

                    <button

                        type="submit"

                        class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white">

                        Supprimer

                    </button>

                </form>

            </div>

        </div>

    </div>

    <!--
     MODAL GENERATION DOCUMENTS -->

    <div
        id="generationModal"
        class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-6">

        <div
            class="bg-white rounded-2xl shadow-xl w-full max-w-5xl overflow-hidden">

            <!-- Header -->

            <div class="flex items-center justify-between px-8 py-5 border-b">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">

                        Nouvelle génération

                    </h2>

                    <p class="text-sm text-slate-500 mt-1">

                        Sélectionnez le type de document à générer.

                    </p>

                </div>

                <button
                    type="button"
                    onclick="closeGenerationModal()"
                    class="text-slate-500 hover:text-red-500">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>

                </button>

            </div>

            <!-- Onglets -->

            <div class="border-b">

                <div class="flex">

                    <button
                        id="tabAttestation"
                        type="button"
                        onclick="showAttestationForm()"
                        class=" px-8 py-4 font-medium border-b-2 text-primary-900">




                        Attestations

                    </button>

                    <button
                        id="tabReleve"
                        type="button"
                        onclick="showReleveForm()"
                        class=" px-8  py-4">

                        <i data-lucide="file-text" class="inline w-5 h-5 mr-2"></i>

                        Relevés

                    </button>

     <button
                        id="tabDeliberation"
                        type="button"
                        onclick="showDelibForm()"
                        class=" px-8  py-4">

                        <i data-lucide="file-text" class="inline w-5 h-5 mr-2"></i>

                            Fichier Délibération

                    </button>

                </div>

            </div>

            <!-- FORMULAIRE ATTESTATION-->

            <div id="attestationContent">

                <form
                    action="{{ route('generer') }}"
                    method="POST">

                    @csrf

                    <div class="p-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>

                                <label class="block text-sm font-semibold mb-2">

                                    Date de délibération des procès verbaux

                                </label>

                                <input
                                    type="date"
                                    name="date_deliberation"
                                    required
                                    class="w-full border rounded-xl px-4 py-3">

                            </div>

                            <div>

                                <label class="block text-sm font-semibold mb-2">

                                    Date du document

                                </label>

                                <input
                                    type="date"
                                    name="date_document"
                                    required
                                    class="w-full border rounded-xl px-4 py-3">

                            </div>

                        

                            <div>

                                <label class="block text-sm font-semibold mb-2">

                                    Premier numéro

                                </label>

                                <input
                                    type="number"
                                    name="numero_depart"
                                    value="1"
                                    required
                                    class="w-full border rounded-xl px-4 py-3">

                            </div>

                        </div>

                    </div>

                    <div class="border-t px-8 py-5 flex justify-end">

                        <button
                            class="bg-primary-900 hover:bg-primary-800 text-white px-8 py-3 rounded-xl">

                            Générer les attestations

                        </button>

                    </div>

                </form>

            </div>





         <!-- FORMULAIRE Deliberation-->
@if($errors->any())
<div class="bg-red-50 border border-red-500 p-4">
@foreach($errors->all() as $error )
<p>{{$error}}</p>
@endforeach

</div>
@endif
            <div id="deliberationContent" class="hidden">

                <form
                    action="{{route('deliberation.generer')}}"
                    method="POST">

                    @csrf

                    <div class="p-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>

                               <select
                                            name="filliere_id"
                                            required
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                            <option value="">
                                                Sélectionner une filière
                                            </option>

                                            @foreach($filieres as $filiere)

                                            <option value="{{ $filiere->id }}">
                                                {{ $filiere->nom }}
                                            </option>

                                            @endforeach

                                        </select>

                               
                            </div>

                            <div>


      <select
                                            name="annee_academique_id"
                                            required
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                            @foreach($anneesAcademiques as $annee)

                                            <option value="{{ $annee->id }}">
                                                {{ $annee->libelle }}
                                            </option>

                                            @endforeach

                                        </select>



                            </div>

                          

                        

                       

                        </div>

                    </div>

                    <div class="border-t px-8 py-5 flex justify-end">

                        <button
                            class="bg-primary-900 hover:bg-primary-800 text-white px-8 py-3 rounded-xl">

                            Générer le fichier de Delibération

                        </button>

                    </div>

                </form>

            </div>







            <!-- ==========================
              FORMULAIRE RELEVE
        =========================== -->

            <div
                id="releveContent"
                class="hidden">

                <div class="p-8 text-center text-slate-500">

                    <div id="releveContent" class="">

                        <form
                            action="{{ route('releves.generer') }}"
                            method="POST">

                            @csrf

                            <div class="px-2 ">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <!-- Filière -->

                                    <div>

                                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                                            Filière

                                        </label>

                                        <select
                                            name="filiere_id"
                                            required
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                            <option value="">
                                                Sélectionner une filière
                                            </option>

                                            @foreach($filieres as $filiere)

                                            <option value="{{ $filiere->id }}">
                                                {{ $filiere->nom }}
                                            </option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <!-- Année d'étude -->

                                    <div>

                                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                                            Année d'étude

                                        </label>

                                        <select
                                            name="annee_etude"
                                            required
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                            <option value="1">1ère année</option>
                                            <option value="2">2ème année</option>
                                            <option value="3">3ème année</option>

                                        </select>

                                    </div>

                                    <!-- Année académique -->

                                    <div>

                                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                                            Année académique

                                        </label>

                                        <select
                                            name="annee_academique_id"
                                            required
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500">

                                            @foreach($anneesAcademiques as $annee)

                                            <option value="{{ $annee->id }}">
                                                {{ $annee->libelle }}
                                            </option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <!-- Semestre -->

                                    <div>

                                        <label class="block text-sm font-semibold text-slate-700 mb-2">

                                            Semestre

                                        </label>

                                        <select
                                            name="semestre"
                                            required
                                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-primary-500 mb-2">

                                            <option value="1">Semestre 1</option>
                                            <option value="2">Semestre 2</option>
                                            <option value="3">Semestre 3</option>
                                            <option value="4">Semestre 4</option>
                                            <option value="5">Semestre 5</option>
                                            <option value="6">Semestre 6</option>

                                        </select>

                                    </div>

                                </div>

                           

                            </div>

                            <!-- Footer -->

                            <div class="border-t px-8 py-5 flex justify-end">

                                <button
                                    type="submit"
                                    class="inline-flex items-center gap-2 bg-primary-900 hover:bg-primary-800 text-white px-8 py-3 rounded-xl transition">

                                    <i data-lucide="file-text"
                                        class="w-5 h-5">
                                    </i>

                                    Générer les relevés

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    @if(session('success'))

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            showToast(

                'Succès',



            );

        });
    </script>
    @endif






    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showErrorToast(`@js(session('error'))`);
        });
    </script>
    @endif



    <!-- Toast Notification -->
    <div
        id="toast"
        class="hidden fixed top-4 right-4 z-50 bg-gray-900 text-white px-6 py-4 rounded-xl shadow-2xl  items-center gap-3 max-w-sm">

        <i
            data-lucide="check-circle-2"
            class="w-5 h-5 text-emerald-400 flex-shrink-0">
        </i>

        <div>

            <p
                class="font-semibold text-sm"
                id="toastTitle">

                Succès

            </p>

            <p
                class="text-sm text-gray-300 mt-0.5"
                id="toastMessage">

                Opération réussie.

            </p>

        </div>

    </div>


    <div id="errorToast"
        class="fixed top-5 right-5 z-50 hidden max-w-sm w-full bg-red-600 text-white rounded-xl shadow-xl overflow-hidden">

        <div class="flex items-start p-4">

            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M10.29 3.86l-8 14A1 1 0 003.14 19h17.72a1 1 0 00.85-1.5l-8-14a1 1 0 00-1.72 0z" />

                </svg>
            </div>

            <div class="ml-3 flex-1">

                <h3 class="font-semibold">
                    Erreur
                </h3>

                <p id="errorToastMessage"
                    class="text-sm mt-1">
                </p>

            </div>

            <button onclick="hideErrorToast()"
                class="ml-4 text-white hover:text-gray-200 text-xl leading-none">
                &times;
            </button>

        </div>
    </div>




    <script>
        lucide.createIcons();


        function openDeleteDocumentModal(route, name, type) {
            document.getElementById('deleteStudentName').textContent = name;

            document.getElementById('deleteDocumentType').textContent = type;

            document.getElementById('deleteDocumentForm').action = route;

            document.getElementById('deleteDocumentModal').classList.remove('hidden');

            document.getElementById('deleteDocumentModal').classList.add('flex');

            lucide.createIcons();
        }

        function closeDeleteDocumentModal() {
            document.getElementById('deleteDocumentModal').classList.remove('flex');

            document.getElementById('deleteDocumentModal').classList.add('hidden');
        }


        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }



        function showToast(title, message) {
            const toast = document.getElementById('toast');

            document.getElementById('toastTitle').textContent = title;

            document.getElementById('toastMessage').textContent = message;

            toast.classList.remove('hidden');

            toast.classList.add('flex');

            toast.classList.add('toast-show');

            

            setTimeout(() => {

                toast.classList.remove('flex');

                toast.classList.add('hidden');

            }, 2000);

        }


        function openPdfModal(url) {
            document.getElementById('pdfFrame').src = url;

            document.getElementById('pdfModal').classList.remove('hidden');

            lucide.createIcons();
        }

        function closePdfModal() {
            document.getElementById('pdfModal').classList.add('hidden');

            document.getElementById('pdfFrame').src = "";
        }


        function openGenerationModal() {

            document
                .getElementById('generationModal')
                .classList.remove('hidden');

            document
                .getElementById('generationModal')
                .classList.add('flex');

        }

        function closeGenerationModal() {

            document
                .getElementById('generationModal')
                .classList.remove('flex');

            document
                .getElementById('generationModal')
                .classList.add('hidden');

        }

        function showAttestationForm() {

            document
                .getElementById('attestationContent')
                .classList.remove('hidden');

            document
                .getElementById('releveContent')
                .classList.add('hidden');

                 document.getElementById('deliberationContent').classList.add('hidden');


            document
                .getElementById('tabAttestation')
                .classList.add(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );

            document
                .getElementById('tabReleve')
                .classList.remove(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );

                   document
                .getElementById('tabDeliberation')
                .classList.remove(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );

        }

        function showReleveForm() {

            document
                .getElementById('releveContent')
                .classList.remove('hidden');

            document
                .getElementById('attestationContent')
                .classList.add('hidden');

                document.getElementById('deliberationContent').classList.add('hidden');

            document
                .getElementById('tabReleve')
                .classList.add(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );

            document
                .getElementById('tabAttestation')
                .classList.remove(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );

                 document
                .getElementById('tabDeliberation')
                .classList.remove(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );

        }


    function showDelibForm(){


       document
                .getElementById('deliberationContent')
                .classList.remove('hidden');

            document
                .getElementById('attestationContent')
                .classList.add('hidden');

                  document
                .getElementById('releveContent')
                .classList.add('hidden');

 document
                .getElementById('tabDeliberation')
                .classList.add(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );


            document
                .getElementById('tabReleve')
                .classList.remove(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );

            document
                .getElementById('tabAttestation')
                .classList.remove(
                    'border-b-2',
                    'border-primary-900',
                    'text-primary-900'
                );



    }




        function showErrorToast(message) {
            const toast = document.getElementById('errorToast');
            const text = document.getElementById('errorToastMessage');

            text.textContent = message;

            toast.classList.remove('hidden');

            toast.classList.add(
                'animate__animated',
                'animate__fadeInRight'
            );

            setTimeout(() => {
                hideErrorToast();
            }, 5000);
        }

        function hideErrorToast() {
            const toast = document.getElementById('errorToast');

            toast.classList.add('hidden');
        }
    </script>
</body>

</html>