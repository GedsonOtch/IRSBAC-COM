<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres - Administration IRSBAC</title>
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/400.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/500.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/600.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/700.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        
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

        /* Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #2563eb;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #2563eb;
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg> Tableau de bord
            </a>
            <a href="{{ route('admin.gestionetudiant') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg> Gestion des Étudiants
            </a>
            <a href="{{ route('admin.import') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sheet-icon lucide-sheet"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><line x1="3" x2="21" y1="9" y2="9"/><line x1="3" x2="21" y1="15" y2="15"/><line x1="9" x2="9" y1="9" y2="21"/><line x1="15" x2="15" y1="9" y2="21"/></svg> Importation Excel
            </a>
            <a href="{{ route('admin.generationdoc') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg> Génération de Documents
            </a>
            <a href="{{ route('admin.modele_signature') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-template-icon lucide-layout-template"><rect width="18" height="7" x="3" y="3" rx="1"/><rect width="9" height="7" x="3" y="14" rx="1"/><rect width="5" height="7" x="16" y="14" rx="1"/></svg> Modèles & Signatures
            </a>
           
            <a href="{{ route('admin.parametres') }}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/></svg>
                   Paramètres
            </a>
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
                        <h2 class="text-xl font-bold text-gray-900">Paramètres de la plateforme</h2>
                        <p class="text-sm text-gray-500">Configuration générale, gestion des administrateurs et sécurité</p>
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

            <!-- Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 fade-in">
                <div class="border-b border-gray-200 px-6">
                    <div class="flex gap-6 overflow-x-auto scrollbar-hide" id="settingsTabs">
                        <button onclick="switchTab('general')" id="tab-general" class="tab-active py-4 text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i data-lucide="building-2" class="w-4 h-4"></i> Général
                        </button>
                        <button onclick="switchTab('admins')" id="tab-admins" class="tab-inactive py-4 text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i data-lucide="users" class="w-4 h-4"></i> Administrateurs
                        </button>
                        <button onclick="switchTab('security')" id="tab-security" class="tab-inactive py-4 text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap">
                            <i data-lucide="shield" class="w-4 h-4"></i> Sécurité
                        </button>
                    </div>
                </div>

                <!-- General Tab Content -->
                <div id="content-general" class="p-6 fade-in">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Informations de l'établissement</h3>

                    <form
                        action="{{ route('admin.parametres.update') }}"
                        method="POST"
                        class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        @csrf

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nom de l'établissement
                            </label>

                            <input
                                type="text"
                                name="nom_etablissement"
                                value="{{ old('nom_etablissement', $info->nom_etablissement ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Sigle
                            </label>

                            <input
                                type="text"
                                name="sigle"
                                value="{{ old('sigle', $info->sigle ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Numéro d'arrêté d'autorisation
                            </label>

                            <input
                                type="text"
                                name="arrete_autorisation"
                                value="{{ old('arrete_autorisation', $info->arrete_autorisation ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Adresse physique
                            </label>

                            <input
                                type="text"
                                name="adresse"
                                value="{{ old('adresse', $info->adresse ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Téléphone
                            </label>

                            <input
                                type="text"
                                name="telephone"
                                value="{{ old('telephone', $info->telephone ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Email de contact
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $info->email ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Site web
                            </label>

                            <input
                                type="text"
                                name="site_web"
                                value="{{ old('site_web', $info->site_web ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Directeur
                            </label>

                            <input
                                type="text"
                                name="directeur"
                                value="{{ old('directeur', $info->directeur ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Directeur des Études
                            </label>

                            <input
                                type="text"
                                name="directeur_etudes"
                                value="{{ old('directeur_etudes', $info->directeur_etudes ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        </div>

                        <div class="md:col-span-2 pt-4 border-t border-gray-200 flex justify-end">
                            <button
                                type="submit"
                                class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2">

                                <i data-lucide="save" class="w-4 h-4"></i>
                                Enregistrer les modifications

                            </button>
                        </div>

                    </form>
















                </div>






                <!-- Administrateurs Tab Content -->
                <div id="content-admins" class="p-6 hidden fade-in">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Gestion des comptes administrateurs</h3>
                            <p class="text-sm text-gray-500">Contrôlez qui a accès au panneau d'administration et leurs niveaux de privilège.</p>
                        </div>
                        <button onclick="openModal('addAdminModal')" class="flex items-center gap-2 px-4 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors text-sm">
                            <i data-lucide="user-plus" class="w-4 h-4"></i> Ajouter un administrateur
                        </button>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 text-gray-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Utilisateur</th>
                                    <th class="px-6 py-3 font-semibold">Rôle</th>
                                    <th class="px-6 py-3 font-semibold">Dernière connexion</th>
                                    <th class="px-6 py-3 font-semibold">Statut</th>
                                    <th class="px-6 py-3 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">

                                @foreach($admins as $admin)

                                <tr class="hover:bg-gray-50 transition-colors">

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-xs">
                                                {{ strtoupper(substr($admin->name,0,1)) }}
                                                {{ strtoupper(substr(explode(' ', $admin->name)[1] ?? '',0,1)) }}
                                            </div>

                                            <div>
                                                <p class="font-medium text-gray-900">
                                                    {{ $admin->name }}
                                                </p>

                                                <p class="text-xs text-gray-500">
                                                    {{ $admin->email }}
                                                </p>
                                            </div>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4">

                                        @php
                                        $roleClass = match($admin->role){
                                        'Super Administrateur' => 'bg-red-50 text-red-700 border-red-100',
                                        'Directeur des Études' => 'bg-purple-50 text-purple-700 border-purple-100',
                                        default => 'bg-blue-50 text-blue-700 border-blue-100'
                                        };
                                        @endphp

                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $roleClass }}">
                                            {{ $admin->role }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4 text-gray-600">

                                        @if($admin->last_login_at)
                                        {{ $admin->last_login_at->diffForHumans() }}
                                        @else
                                        Jamais connecté
                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        @if($admin->is_active)

                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Actif
                                        </span>

                                        @else

                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Inactif
                                        </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-right">

                                        <div class="flex items-center justify-end gap-2">

                                            {{-- Modifier --}}
                                            <button
                                                onclick="openEditAdminModal(
                    '{{ $admin->id }}',
                    '{{ $admin->nom }}',
                    '{{ $admin->email }}',
                    '{{ $admin->role }}'
                )"
                                                class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                                                title="Modifier">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil-line-icon lucide-pencil-line"><path d="M13 21h8"/><path d="m15 5 4 4"/><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/></svg>

                                            </button>

                                            {{-- Supprimer --}}
                                            <button
                                                onclick="openDeleteAdminModal(
        `{{ route('admins.destroy', $admin->id) }}`,
        '{{ $admin->nom }}'
    )"
                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>

                                            </button>

                                        </div>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Security Tab Content -->


                <div id="content-security" class="p-6 hidden fade-in">

                    <h3 class="text-lg font-bold text-gray-900 mb-6">
                        Configuration de la sécurité
                    </h3>

                    <form action="{{ route('security.update') }}"
                        method="POST"
                        class="space-y-6 max-w-3xl">

                        @csrf

                        <!-- Mot de passe obligatoire -->



                        <!-- Session -->
                        <div class="flex items-start justify-between p-4 bg-white border border-gray-200 rounded-xl">

                            <div>
                                <h4 class="font-semibold text-gray-900">
                                    Expiration des sessions
                                </h4>

                                <p class="text-sm text-gray-500 mt-1">
                                    Déconnecter automatiquement les utilisateurs après une période d'inactivité.
                                </p>
                            </div>

                            <select
                                name="session_timeout"
                                class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 bg-white">

                                <option value="30"
                                    {{ ($security->session_timeout ?? '') == '30' ? 'selected' : '' }}>
                                    30 minutes
                                </option>

                                <option value="60"
                                    {{ ($security->session_timeout ?? '60') == '60' ? 'selected' : '' }}>
                                    1 heure
                                </option>

                                <option value="240"
                                    {{ ($security->session_timeout ?? '') == '240' ? 'selected' : '' }}>
                                    4 heures
                                </option>

                                <option value="0"
                                    {{ ($security->session_timeout ?? '') == '0' ? 'selected' : '' }}>
                                    Jamais
                                </option>

                            </select>

                        </div>

                        <!-- Maintenance -->
                        <div class="flex items-start justify-between p-4 bg-white border border-gray-200 rounded-xl">

                            <div>
                                <h4 class="font-semibold text-gray-900">
                                    Mode Maintenance
                                </h4>

                                <p class="text-sm text-gray-500 mt-1">
                                    Rendre la plateforme inaccessible aux étudiants.
                                </p>
                            </div>

                            <div class="relative">
                                <input
                                    type="checkbox"
                                    name="maintenance_mode"
                                    value="1"
                                    class="w-5 h-5"
                                    {{ ($security->maintenance_mode ?? false) ? 'checked' : '' }}>
                            </div>

                        </div>

                        <!-- Audit -->
                        <div class="flex items-start justify-between p-4 bg-white border border-gray-200 rounded-xl">

                            <div>
                                <h4 class="font-semibold text-gray-900">
                                    Journalisation des actions (Audit)
                                </h4>

                                <p class="text-sm text-gray-500 mt-1">
                                    Enregistrer toutes les connexions, modifications et générations de documents.
                                </p>
                            </div>

                            <div class="relative">
                                <input
                                    type="checkbox"
                                    name="audit_log"
                                    value="1"
                                    class="w-5 h-5"
                                    {{ ($security->audit_log ?? true) ? 'checked' : '' }}>
                            </div>

                        </div>

                        <div class="pt-4 border-t border-gray-200 flex justify-end">

                            <button
                                type="submit"
                                class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors flex items-center gap-2">

                                <i data-lucide="save" class="w-4 h-4 "></i>

                                Enregistrer les paramètres de sécurité

                            </button>

                        </div>

                    </form>

                </div>


            </div>

            <!-- Footer -->
            <footer class="text-center py-6 text-sm text-gray-500">
                <p>© 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication.</p>
            </footer>
        </main>
    </div>

    <!-- Add Admin Modal -->
    <

        <div id="addAdminModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute inset-0"
            onclick="closeModal('addAdminModal')"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">

            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md pointer-events-auto fade-in">

                <form action="{{ route('admins.store') }}" method="POST">

                    @csrf

                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">
                            Ajouter un administrateur
                        </h3>

                        <button type="button"
                            onclick="closeModal('addAdminModal')"
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Nom complet
                            </label>

                            <input
                                type="text"
                                name="name"
                                required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Adresse email
                            </label>

                            <input
                                type="email"
                                name="email"
                                required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Rôle
                            </label>

                            <select
                                name="role"
                                required
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-lg">

                                <option value="secretaire">
                                    Secretaire
                                </option>

                                <option value="directeur_etudes">
                                    Directeur des Études
                                </option>

                                <option value="comptable">
                                    Comptable
                                </option>

                                <option value="directeur">
                                    Directeur
                                </option>

                            </select>
                        </div>

                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 flex gap-3">
                            <i data-lucide="info"
                                class="w-5 h-5 text-blue-600 flex-shrink-0"></i>

                            <p class="text-xs text-blue-800">
                                Le mot de passe par défaut sera :
                                <strong>admin12345</strong>
                            </p>
                        </div>

                    </div>

                    <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end gap-3">

                        <button type="button"
                            onclick="closeModal('addAdminModal')"
                            class="px-4 py-2.5 border border-gray-300 rounded-lg">
                            Annuler
                        </button>

                        <button type="submit"
                            class="px-4 py-2.5 bg-primary-600 text-white rounded-lg flex items-center gap-2">

                            <i data-lucide="user-plus" class="w-4 h-4"></i>

                            Créer le compte

                        </button>

                    </div>

                </form>

            </div>

        </div>
        </div>


        <!-- Edit Admin Modal -->
        <div id="editAdminModal"
            class="fixed inset-0 z-50 hidden">

            <div class="absolute inset-0 bg-black/50"></div>

            <div class="absolute inset-0 flex items-center justify-center p-4">

                <div class="bg-white rounded-xl w-full max-w-lg shadow-xl">

                    <div class="p-6 border-b">

                        <h3 class="text-lg font-bold">
                            Modifier un administrateur
                        </h3>

                    </div>

                    <form id="editAdminForm"
                        method="POST" action="{{ route('admins.update', ['admin' => $admin->id]) }}">

                        @csrf
                        @method('PUT')

                        <div class="p-6 space-y-4">

                            <div>
                                <label class="block mb-1 text-sm font-medium">
                                    Nom
                                </label>

                                <input
                                    type="text"
                                    id="editNom"
                                    name="name"
                                    class="w-full border rounded-lg p-3">
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="editEmail"
                                    name="email"
                                    class="w-full border rounded-lg p-3">
                            </div>

                            <div>
                                <label class="block mb-1 text-sm font-medium">
                                    Rôle
                                </label>

                                <select
                                    id="editRole"
                                    name="role"
                                    class="w-full border rounded-lg p-3">

                                   <option value="secretaire">
                                    Secretaire
                                </option>

                                <option value="directeur_etudes">
                                    Directeur des Études
                                </option>

                                <option value="comptable">
                                    Comptable
                                </option>

                                <option value="directeur">
                                    Directeur
                                </option>

                                </select>
                            </div>

                        </div>

                        <div class="p-6 border-t flex justify-end gap-3">

                            <button
                                type="button"
                                onclick="closeEditAdminModal()"
                                class="px-4 py-2 border rounded-lg">

                                Annuler

                            </button>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg">

                                Enregistrer

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>







        <!-- Delete Admin Modal -->
        <div id="deleteAdminModal"
            class="fixed inset-0 z-50 hidden">

            <div class="absolute inset-0 bg-black/50"></div>

            <div class="absolute inset-0 flex items-center justify-center p-4">

                <div class="bg-white rounded-xl p-6 w-full max-w-md">

                    <h3 class="text-lg font-bold text-red-600">
                        Supprimer l'administrateur
                    </h3>

                    <p class="mt-3 text-gray-600">
                        Voulez-vous vraiment supprimer
                        <span id="adminName"
                            class="font-semibold"></span> ?
                    </p>

                    <form id="deleteAdminForm"
                        method="POST"
                        class="mt-6">

                        @csrf
                        @method('DELETE')

                        <div class="flex justify-end gap-3">

                            <button
                                type="button"
                                onclick="closeDeleteAdminModal()"
                                class="px-4 py-2 border rounded-lg">

                                Annuler

                            </button>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg">

                                Supprimer

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>



        <!-- Toast Notification -->
        @if(session('success'))

        <div id="toast"
            class="fixed top-5 right-5 z-50 bg-gray-900 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 max-w-sm">

            <i data-lucide="check-circle-2"
                class="w-5 h-5 text-emerald-400 flex-shrink-0">
            </i>

            <div>
                <p class="font-semibold text-sm">
                    Succès
                </p>

                <p class="text-sm text-gray-300 mt-0.5">
                    {{ session('success') }}
                </p>
            </div>

        </div>

        @endif


        <script>
            

            let currentTab = 'general';

            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('mobileOverlay');
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            function switchTab(tab) {
                currentTab = tab;

                // Update tab styles
                ['general', 'admins', 'security'].forEach(t => {
                    const btn = document.getElementById(`tab-${t}`);
                    const content = document.getElementById(`content-${t}`);

                    if (t === tab) {
                        btn.className = 'tab-active py-4 text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap';
                        content.classList.remove('hidden');
                    } else {
                        btn.className = 'tab-inactive py-4 text-sm font-medium transition-colors flex items-center gap-2 whitespace-nowrap';
                        content.classList.add('hidden');
                    }
                });

                lucide.createIcons();
            }

            function openModal(modalId) {
                document.getElementById(modalId).classList.remove('hidden');
            }

            function closeModal(modalId) {
                document.getElementById(modalId).classList.add('hidden');
            }

            function saveSettings(type) {
                const btn = event.target.closest('button');
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div> Enregistrement...';
                btn.disabled = true;

                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    const msg = type === 'general' ? 'Les informations de l\'établissement ont été mises à jour avec succès.' : 'Les paramètres de sécurité ont été enregistrés avec succès.';
                    showToast(msg, 'Succès');
                }, 1000);
            }

         


            document.addEventListener('DOMContentLoaded', function() {

               

                const toast = document.getElementById('toast');

                if (!toast) return;

                toast.style.transition = "all 0.5s ease";

                setTimeout(() => {

                    toast.style.opacity = "0";
                    toast.style.transform = "translateX(100px)";

                    setTimeout(() => {
                        toast.remove();
                    }, 500);

                }, 2000);

            });




            function openEditAdminModal(id, nom, email, role) {
                document.getElementById('editNom').value = nom;
                document.getElementById('editEmail').value = email;
                document.getElementById('editRole').value = role;

                document.getElementById('editAdminForm').action =
                    '/admins/' + id;

                document
                    .getElementById('editAdminModal')
                    .classList
                    .remove('hidden');
            }

            function closeEditAdminModal() {
                document
                    .getElementById('editAdminModal')
                    .classList
                    .add('hidden');
            }

            function openDeleteAdminModal(url, nom) {
                document.getElementById('adminName').textContent = nom;

                document.getElementById('deleteAdminForm').action = url;

                document
                    .getElementById('deleteAdminModal')
                    .classList
                    .remove('hidden');
            }

            function closeDeleteAdminModal() {
                document
                    .getElementById('deleteAdminModal')
                    .classList
                    .add('hidden');
            }
        </script>
</body>

</html>