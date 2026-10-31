<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modèles - Administration IRSBAC</title>
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
            <img src="{{asset('storage/logo_irsbac/logo.png')}}" alt="IRSBAC Logo" class="w-13 h-13 object-contain rounded-lg p-1">
            <div>
                <h1 class="text-lg font-bold tracking-wide">IRSBAC</h1>
                <p class="text-xs text-blue-200">Espace Administration</p>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
            <a href="{{route('admin.dashboard')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                    <rect width="7" height="9" x="3" y="3" rx="1" />
                    <rect width="7" height="5" x="14" y="3" rx="1" />
                    <rect width="7" height="9" x="14" y="12" rx="1" />
                    <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                Tableau de bord
            </a>
            <a href="{{route('admin.gestionetudiant')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
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
            <a href="{{route('admin.generationdoc')}}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">


                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text">
                    <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                    <path d="M10 9H8" />
                    <path d="M16 13H8" />
                    <path d="M16 17H8" />
                </svg>
                Génération de Documents
            </a>
            <a href="{{route('admin.modele_signature')}}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-template-icon lucide-layout-template">
                    <rect width="18" height="7" x="3" y="3" rx="1" />
                    <rect width="9" height="7" x="3" y="14" rx="1" />
                    <rect width="5" height="7" x="16" y="14" rx="1" />
                </svg> Modèles & Signatures
            </a>


            <a href="{{ route('ues.store') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap-icon lucide-graduation-cap">
                    <path d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                    <path d="M22 10v6" />
                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                </svg>
                UE & ECUE
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
                    </svg> Déconnexion
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
                        <h2 class="text-xl font-bold text-gray-900">Signatures & Cachets</h2>
                        <p class="text-sm text-gray-500">Configurez les modèles de signatures et cachets officiels</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="hidden sm:block text-right">
                        @if($info->directeur )
                        <p class="text-sm font-semibold text-gray-900">{{ $info->directeur}}</p>
                        <p class="text-xs text-gray-500">Directeur</p>
                        @endif
                    </div>

                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-6">


            <div class="bg-white rounded-xl shadow-sm border border-gray-200">

                <div class="flex items-center justify-between p-4 border-b">

                    <h2 class="text-lg font-semibold text-gray-800">
                        Signatures & Cachets
                    </h2>

                    <button
                        onclick="openSignatureCachetCreateModal()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                        Nouveau Modèle

                    </button>

                </div>

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">

                            <tr>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Aperçu
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Type
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Nom Responsable
                                </th>

                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Fonction
                                </th>

                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>

                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">

                            @foreach($elements as $element)

                            <tr class="hover:bg-gray-50">



                                <td class="px-4 py-3">

                                    <img
                                        src="{{ asset('storage/'.$element->image_path) }}"
                                        class="w-12 h-12 object-contain border rounded-md p-1 bg-white">

                                </td>

                                <td class="px-4 py-3">

                                    <span class="
                            px-2 py-1 rounded-full text-xs
                            {{ $element->type == 'signature'
                                ? 'bg-blue-100 text-blue-700'
                                : 'bg-green-100 text-green-700' }}
                        ">
                                        {{ ucfirst($element->type) }}
                                    </span>

                                </td>

                                <td class="px-4 py-3">
                                    {{ $element->nom_responsable }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $element->fonction }}
                                </td>

                                <td class="px-4 py-3">

                                    <div class="flex justify-center gap-2">

                                        <!-- Modifier -->
                                      <button
    type="button"
    class="btn-edit p-2 text-blue-600 hover:bg-blue-50 rounded-lg"
    data-id="{{ $element->id }}"
    data-type="{{ $element->type }}"
    data-nom="{{ $element->nom_responsable }}"
    data-fonction="{{ $element->fonction }}"
    data-image="{{ asset('storage/'.$element->image_path) }}"
    data-action="{{ route('signature-cachets.update', $element->id) }}">

    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit-2-icon lucide-edit-2">
        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
</button>

                                       

                                        <!-- Supprimer -->
                                      <button
    type="button"
    class="btn-delete p-2 text-red-600 hover:bg-red-50 rounded-lg"
    data-action="{{ route('signature-cachets.destroy', $element->id) }}"
    data-nom="{{ $element->nom_responsable }}"
    data-type="{{ $element->type }}"
    data-fonction="{{$element->fonction}}"
    >

 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash preview-icon"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>

</button>

                                    </div>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>


            <script>
                

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


            

          

            
            </script>

            @if($template)

            <div
                id="previewModal"
                class="fixed inset-0 z-50 hidden">

                <div
                    class="modal-overlay absolute inset-0"
                    onclick="closePreviewModal()">
                </div>

                <div
                    class="absolute inset-0 flex items-center justify-center p-4">

                    <div
                        class="bg-white rounded-xl shadow-2xl w-full max-w-6xl h-[90vh]">

                        <div
                            class="flex items-center justify-between p-4 border-b">

                            <h3 class="font-bold text-gray-900">
                                Aperçu du template
                            </h3>

                            <button
                                onclick="closePreviewModal()"
                                class="p-2 hover:bg-gray-100 rounded-lg">

                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>

                            </button>

                        </div>

                        <iframe
                            src="{{ asset('storage/'.$template->pdf_path) }}"
                            class="w-full h-[calc(90vh-70px)]">
                        </iframe>

                    </div>

                </div>

            </div>

            @endif
   <!-- Modal de modification de signature/cachet -->

<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-xl bg-white shadow-xl">

        <div class="flex items-center justify-between border-b px-5 py-4">
            <h3 class="text-lg font-semibold">Modifier l'élément</h3>
            <button type="button" id="closeEditModal" class="text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
        </div>

        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4 p-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium">Type</label>
                <select name="type" id="edit_type" required
                        class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="signature">Signature</option>
                    <option value="cachet">Cachet</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Nom du responsable</label>
                <input type="text" name="nom_responsable" id="edit_nom" required
                       class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Fonction</label>
                <input type="text" name="fonction" id="edit_fonction" required
                       class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium">Image</label>
                <img id="edit_preview" src="" class="mb-2 h-20 w-20 rounded-md border bg-white object-contain p-1">
                <input type="file" name="image" id="edit_image" accept="image/*"
                       class="w-full text-sm file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-blue-700">
                <p class="mt-1 text-xs text-gray-500">Laisser vide pour conserver l'image actuelle.</p>
            </div>

            @if ($errors->any())
                <div class="rounded-lg bg-red-50 p-3 text-sm text-red-700">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" id="cancelEditModal" class="rounded-lg border px-4 py-2 hover:bg-gray-50">Annuler</button>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

 <!-- Modal de suppression de signature/cachet -->

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-sm rounded-xl bg-white p-6 shadow-xl">

        <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                <path d="M12 9v4" />
                <path d="M12 17h.01" />
            </svg>
        </div>

        <h3 class="text-center text-lg font-semibold text-gray-900">Supprimer cet élément ?</h3>
        <p class="mt-2 text-center text-sm text-gray-600">
    Vous êtes sur le point de supprimer
    <span id="delete_type" class="font-medium text-gray-900"></span> du
     <span id="delete_fonction" class="font-medium text-gray-900"></span>.
    Cette action est irréversible.
</p>

        <form id="deleteForm" method="POST" class="mt-6 flex justify-center gap-3">
            @csrf
            @method('DELETE')

            <button type="button" id="cancelDeleteModal"
                    class="rounded-lg border px-4 py-2 hover:bg-gray-50">
                Annuler
            </button>
            <button type="submit"
                    class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                Supprimer
            </button>
        </form>
    </div>
</div>






            <!-- Modal de création de signature/cachet -->
            <div
                id="signatureCachetCreateModal"
                class="fixed inset-0 z-50 hidden">

                <!-- Fond -->
                <div
                    class="absolute inset-0 bg-black/50"
                    onclick="closeSignatureCachetCreateModal()">
                </div>

                <!-- Conteneur -->
                <div class="relative flex items-center justify-center h-full p-4">

                    <div
                        class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">

                        <!-- En-tête -->
                        <div class="px-6 py-4 border-b flex items-center justify-between">

                            <h2 class="text-xl font-bold text-gray-800">
                                Signature & Cachets
                            </h2>

                            <button
                                type="button"
                                onclick="closeSignatureCachetCreateModal()"
                                class="text-gray-500 hover:text-red-600 text-2xl">

                                &times;

                            </button>

                        </div>

                        <!-- Corps scrollable -->
                        <div class="overflow-y-auto max-h-[70vh] p-6">

                            <form
                                action="{{ route('signature-cachets.store') }}"
                                method="POST"
                                enctype="multipart/form-data">

                                @csrf

                                @if(session('success'))
                                <div class="mb-4 rounded-lg bg-green-100 text-green-700 p-3">
                                    {{ session('success') }}
                                </div>
                                @endif

                                <!-- Directeur -->
                                <div class="border rounded-xl p-5 mb-6">

                                    <h3 class="font-semibold text-lg mb-4 text-blue-700">
                                        Directeur
                                    </h3>

                                    <div class="space-y-4">

                                        <div>

                                            <label class="block mb-1 font-medium">
                                                Nom du directeur
                                            </label>

                                            <input
                                                type="text"
                                                name="directeur_nom"
                                                value="{{ old('directeur_nom',$directeurNom ?? '') }}"
                                                class="w-full rounded-lg border p-3 @error('directeur_nom') border-red-500 @enderror">

                                            @error('directeur_nom')
                                            <p class="text-red-500 text-sm mt-1">
                                                {{ $message }}
                                            </p>
                                            @enderror

                                        </div>

                                        <div>

                                            <label class="block mb-1 font-medium">
                                                Signature
                                            </label>

                                            <input
                                                type="file"
                                                name="directeur_signature"
                                                class="w-full rounded-lg border p-3">

                                        </div>

                                        <div>

                                            <label class="block mb-1 font-medium">
                                                Cachet
                                            </label>

                                            <input
                                                type="file"
                                                name="directeur_cachet"
                                                class="w-full rounded-lg border p-3">

                                        </div>

                                    </div>

                                </div>

                                <!-- Directeur des études -->

                                <div class="border rounded-xl p-5">

                                    <h3 class="font-semibold text-lg mb-4 text-blue-700">

                                        Directeur des études

                                    </h3>

                                    <div class="space-y-4">

                                        <div>

                                            <label class="block mb-1 font-medium">

                                                Nom du directeur des études

                                            </label>

                                            <input
                                                type="text"
                                                name="directeur_etudes_nom"
                                                value="{{ old('directeur_etudes_nom',$directeurEtudesNom ?? '') }}"
                                                class="w-full rounded-lg border p-3">

                                        </div>

                                        <div>

                                            <label class="block mb-1 font-medium">

                                                Signature

                                            </label>

                                            <input
                                                type="file"
                                                name="directeur_etudes_signature"
                                                class="w-full rounded-lg border p-3">

                                        </div>

                                        <div>

                                            <label class="block mb-1 font-medium">

                                                Cachet

                                            </label>

                                            <input
                                                type="file"
                                                name="directeur_etudes_cachet"
                                                class="w-full rounded-lg border p-3">

                                        </div>

                                    </div>

                                </div>

                                <!-- Boutons -->

                                <div class="flex justify-end gap-3 mt-8">

                                    <button
                                        type="button"
                                        onclick="closeSignatureCachetCreateModal()"
                                        class="px-5 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">

                                        Annuler

                                    </button>

                                    <button
                                        type="submit"
                                        class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">

                                        Enregistrer

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>


            <script>
                



    const deleteModal = document.getElementById('deleteModal');
    const deleteForm  = document.getElementById('deleteForm');
    const deleteType  = document.getElementById('delete_type');
const deleteFunction = document.getElementById('delete_fonction');
    const openDeleteModal  = () => { deleteModal.classList.remove('hidden'); deleteModal.classList.add('flex'); };
    const closeDeleteModal = () => { deleteModal.classList.add('hidden');    deleteModal.classList.remove('flex'); };

    // "la signature" / "le cachet"
    const labels = {
        signature: 'la signature',
        cachet: 'le cachet',
    };

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            deleteForm.action     = btn.dataset.action;
            deleteType.textContent = labels[btn.dataset.type] ?? 'cet élément';
            deleteFunction.textContent = btn.dataset.fonction ?? 'cette fonction';
            openDeleteModal();
        });
    });

    document.getElementById('cancelDeleteModal').addEventListener('click', closeDeleteModal);
    deleteModal.addEventListener('click', e => { if (e.target === deleteModal) closeDeleteModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });






                function closeCreateModal() {
                    document
                        .getElementById('createModal')
                        .classList.add('hidden');
                }

           
            
                  
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





    const modal   = document.getElementById('editModal');
    const form    = document.getElementById('editForm');
    const preview = document.getElementById('edit_preview');

    const openModal  = () => { modal.classList.remove('hidden'); modal.classList.add('flex'); };
    const closeModal = () => { modal.classList.add('hidden');    modal.classList.remove('flex'); };

    // Ouverture + pré-remplissage
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            form.action = btn.dataset.action;
            document.getElementById('edit_type').value     = btn.dataset.type;
            document.getElementById('edit_nom').value      = btn.dataset.nom;
            document.getElementById('edit_fonction').value = btn.dataset.fonction;
            document.getElementById('edit_image').value    = '';
            preview.src = btn.dataset.image;
            openModal();
        });
    });

    // Aperçu de la nouvelle image choisie
    document.getElementById('edit_image').addEventListener('change', e => {
        const file = e.target.files[0];
        if (file) preview.src = URL.createObjectURL(file);
    });

    // Fermeture
    document.getElementById('closeEditModal').addEventListener('click', closeModal);
    document.getElementById('cancelEditModal').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });




             

                
            </script>
</body>

</html>