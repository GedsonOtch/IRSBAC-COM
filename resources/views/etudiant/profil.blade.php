<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - IRSBAC</title>
     @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/400.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/500.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/600.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.16/700.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
      
    <style>
        body { font-family: 'Inter', sans-serif; }
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .toast {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
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
            <a href="{{ route('etudiant.profil') }}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                 Mon Profil
            </a>
            <a href="{{ route('etudiant.documents') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
 Mes Documents
            </a>
            <a href="{{ route('etudiant.notes') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
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
                        <h2 class="text-xl font-bold text-gray-900">Mon Profil</h2>
                        <p class="text-sm text-gray-500">Gérez vos informations personnelles et académiques</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ auth('etudiant')->user()->prenom }} {{ auth('etudiant')->user()->nom }}</p>
                        <p class="text-xs text-gray-500">Mat: {{ auth('etudiant')->user()->matricule }}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                     <img src="{{ auth()->guard('etudiant')->user()->photo_url }}" alt="">
                    </div>
                </div>
            </div>
        </header>

        <!-- Profile Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-6">
            
            <!-- Profile Header Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 fade-in">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-3xl font-bold border-4 border-white shadow-md">
                           <img src="{{ auth()->guard('etudiant')->user()->photo_url }}" alt="">
                        
                    </div>
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl font-bold text-gray-900">{{ auth('etudiant')->user()->prenom }} {{ auth('etudiant')->user()->nom }}</h3>
                        <p class="text-gray-500 mt-1">Étudiante en Licence Professionnelle</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium {{auth('etudiant')->user()->est_en_regle ? 'bg-emerald-50 text-emerald-700' : 'bg-red-100 text-red-500'}}  border border-emerald-100">
                                <i data-lucide="check-circle-2" class="w-4 h-4"></i> {{ auth('etudiant')->user()->est_en_regle ? 'En règle' : 'Non en règle' }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                <i data-lucide="book-open" class="w-4 h-4"></i> {{ auth('etudiant')->user()->filiere->nom }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-3">
                      <button onclick="openModal('editProfileModal')"
        class="px-4 py-2 bg-primary-600 text-white rounded-lg">
    Modifier le profil
</button>
                        
                    </div>
                </div>
            </div>

            <form id="profileForm" class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in" style="animation-delay: 0.1s;" onsubmit="event.preventDefault();">
                
                <!-- Personal Information -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i data-lucide="user" class="w-5 h-5 text-primary-600"></i> Informations Personnelles
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nom</label>
                            <input type="text" value="{{ auth('etudiant')->user()->nom }}" disabled class="profile-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:cursor-not-allowed transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Prénoms</label>
                            <input type="text" value="{{ auth('etudiant')->user()->prenom }}" disabled class="profile-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:cursor-not-allowed transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Date de naissance</label>
                            <input type="date" value="{{ auth('etudiant')->user()->date_naissance }}" disabled class="profile-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:cursor-not-allowed transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Lieu de naissance</label>
                            <input type="text" value="{{ auth('etudiant')->user()->lieu_naissance }}" disabled class="profile-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:cursor-not-allowed transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Sexe</label>
                            <select disabled class="profile-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:cursor-not-allowed transition-all">
                                <option value="F" selected>{{ auth('etudiant')->user()->sexe }}</option>
                                
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Téléphone</label>
                            <input type="tel" value="{{ auth('etudiant')->user()->telephone }}" disabled class="profile-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent disabled:cursor-not-allowed transition-all">
                        </div>
                        
                    </div>
                </div>

                <!-- Academic & Security Information -->
                <div class="space-y-6">
                    <!-- Academic Info -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i data-lucide="graduation-cap" class="w-5 h-5 text-primary-600"></i> Informations Académiques
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Matricule</label>
                                <p class="text-sm font-semibold text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">{{ auth('etudiant')->user()->matricule }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Filière</label>
                                <p class="text-sm font-semibold text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">{{ auth('etudiant')->user()->filiere->nom }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Niveau actuel</label>
                                <p class="text-sm font-semibold text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">Licence{{ auth('etudiant')->user()->annee_etude }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Année d'entrée</label>
                                <p class="text-sm font-semibold text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">2024-2025</p>
                            </div>
                        </div>
                    </div>

                    
            </form>

            <!-- Footer -->
            <footer class="text-center py-6 text-sm text-gray-500">
                <p>© 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication. Tous droits réservés.</p>
                <p class="mt-1">Parakou, Bénin • <a href="#" class="text-primary-600 hover:underline">Mentions légales</a> • <a href="#" class="text-primary-600 hover:underline">Support technique</a></p>
            </footer>
        </main>
    </div>

<!-- Edit Profile Modal -->
<div id="editProfileModal" class="fixed inset-0 z-50 hidden">

    <div class="modal-overlay absolute inset-0 bg-black/50"
         onclick="closeModal('editProfileModal')">
    </div>

    <div class="absolute inset-0 flex items-center justify-center p-4 pointer-events-none">

        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg pointer-events-auto fade-in">

            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">

                <h3 class="text-lg font-bold text-gray-900">
                    Modifier mon profil
                </h3>

                <button onclick="closeModal('editProfileModal')"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg">

                    <i data-lucide="x" class="w-5 h-5"></i>

                </button>

            </div>

            <form id="profileUpdateForm"
                  method="POST"
                  action="{{ route('etudiant.profile.update') }}">

                @csrf
                

                <div class="p-6 space-y-5">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Numéro de téléphone
                        </label>

                        <input
                            type="tel"
                            name="telephone"
                            value="{{ auth('etudiant')->user()->telephone }}"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nouveau mot de passe
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmation du mot de passe
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500">
                    </div>

                </div>

                <div class="p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl flex justify-end gap-3">

                    <button type="button"
                            onclick="closeModal('editProfileModal')"
                            class="px-4 py-2.5 border border-gray-300 text-gray-700 rounded-lg">
                        Annuler
                    </button>

                    <button type="submit"
                            id="saveBtnModal"
                            class="px-4 py-2.5 bg-primary-600 text-white rounded-lg flex items-center gap-2">

                        <i data-lucide="save" class="w-4 h-4"></i>

                        Enregistrer

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>



















    <!-- Toast Notification -->
    <div id="toast" class="toast fixed top-4 right-4 z-50 bg-emerald-600 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3">
        <i data-lucide="check-circle-2" class="w-5 h-5"></i>
        <div>
            <p class="font-semibold">Succès</p>
            <p class="text-sm text-emerald-100">Vos informations ont été mises à jour avec succès.</p>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

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
}
  

    </script>
</body>
</html>

