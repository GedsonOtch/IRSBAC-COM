<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Étudiant - IRSBAC</title>
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
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-primary-900 text-white z-40 sidebar-transition transform -translate-x-full lg:translate-x-0 flex flex-col">
        <!-- Logo -->
        <div class="p-6 flex items-center gap-3 border-b border-primary-800">
            <img src="{{asset('storage/logo_irsbac/logo.png')}}" alt="IRSBAC Logo" class="w-13 h-13 object-contain rounded-lg p-1">
            <div>
                <h1 class="text-lg font-bold tracking-wide">IRSBAC</h1>
                <p class="text-xs text-blue-200">Espace Étudiant</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-hide">
            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>

                Tableau de bord
            </a>
            <a href="{{ route('etudiant.profil') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>

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

        <!-- Logout -->
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
                        <h2 class="text-xl font-bold text-gray-900">Bonjour,  {{ auth('etudiant')->user()->prenom }} </h2>
                        <p class="text-sm text-gray-500">Bienvenue sur votre espace académique IRSBAC</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                   
                    <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                        <img src="{{ auth()->guard('etudiant')->user()->photo_url }}" alt="" class="w-9 h-9 rounded-full object-cover border-2 border-primary-100">
                        <div class="hidden sm:block">
                            <p class="text-sm font-semibold text-gray-900"> {{ auth('etudiant')->user()->prenom }}
    {{ auth('etudiant')->user()->nom }}</p>
                            <p class="text-xs text-gray-500">Mat: {{ auth('etudiant')->user()->matricule }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-8">
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 fade-in">
                <!-- Moyenne Générale -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <i data-lucide="trending-up" class="w-5 h-5 text-primary-600"></i>
                        </div>
                        
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Documents disponibles</p>
                    <p class="text-2xl font-bold text-gray-900">11.89<span class="text-sm font-normal text-gray-400">/20</span></p>
                </div>

                <!-- Semestre Actuel -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-purple-50 rounded-lg">
                            <i data-lucide="calendar" class="w-5 h-5 text-purple-600"></i>
                        </div>
                        <span class="text-xs font-medium text-purple-600 bg-purple-50 px-2 py-1 rounded-full">En cours</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Semestre Actuel</p>
                    <p class="text-2xl font-bold text-gray-900">Semestre 6</p>
                </div>

                <!-- Crédits Validés -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-amber-50 rounded-lg">
                            <i data-lucide="award" class="w-5 h-5 text-amber-600"></i>
                        </div>
                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded-full">100%</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Crédits Validés</p>
                    <p class="text-2xl font-bold text-gray-900">18<span class="text-sm font-normal text-gray-400">/18</span></p>
                </div>

                <!-- Statut -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-emerald-50 rounded-lg">
                            <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600"></i>
                        </div>
                        <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Actif</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Statut Académique</p>
                    <p class="text-2xl font-bold {{auth('etudiant')->user()->est_en_regle ? ' text-emerald-600' : ' text-red-500'}}">{{ auth('etudiant')->user()->est_en_regle ? 'En règle' : 'Non en règle' }}</p>
                </div>
            </div>

            <!-- Profile & Progress Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in" style="animation-delay: 0.1s;">
                <!-- Profile Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-1">
                    <div class="text-center">
                        <img src="{{ auth()->guard('etudiant')->user()->photo_url }}
                        " alt="Profile" class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-primary-50 shadow-md">
                        <h3 class="mt-4 text-lg font-bold text-gray-900"> {{ auth('etudiant')->user()->prenom }} {{ auth('etudiant')->user()->nom }}</h3>
                        <p class="text-sm text-gray-500">Étudiant en Licence Professionnelle</p>
                    </div>
                    <div class="mt-6 space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i data-lucide="hash" class="w-4 h-4"></i> Matricule</span>
                            <span class="text-sm font-semibold text-gray-900">{{ auth('etudiant')->user()->matricule }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i data-lucide="book-open" class="w-4 h-4"></i> Filière</span>
                            <span class="text-sm font-semibold text-gray-900 text-right">{{ auth('etudiant')->user()->filiere->nom }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-50">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i data-lucide="layers" class="w-4 h-4"></i> Année d'étude</span>
                            <span class="text-sm font-semibold text-gray-900">Licence {{ auth('etudiant')->user()->annee_etude }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-500 flex items-center gap-2"><i data-lucide="calendar-days" class="w-4 h-4"></i> Année Acad.</span>
                            <span class="text-sm font-semibold text-gray-900">2024-2025</span>
                        </div>
                    </div>
                    <a href="{{ route('etudiant.profil') }}">
                    <button class="w-full mt-6 py-2.5 bg-primary-50 text-primary-700 font-medium rounded-lg hover:bg-primary-100 transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i> Modifier le profil
                    </button> </a>
                </div>

                 
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Progression du cursus (3 ans / 6 semestres)</h3>
                        <span class="text-sm text-gray-500">Cycle Licence BAPES</span>
                    </div>
                    
                    <div class="space-y-4">
                        
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">1ère Année - Semestres 1 & 2</span>
                                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">En attente</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 00%"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Moy. S1: </span>
                                <span class="text-xs text-gray-500">Moy. S2:</span>
                            </div>
                        </div>

                         
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">2ème Année - Semestres 3 & 4</span>
                                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">En attente</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 00%"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Moy. S3: </span>
                                <span class="text-xs text-gray-500">Moy. S4: </span>
                            </div>
                        </div>

                         
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-gray-700">3ème Année - Semestres 5 & 6</span>
                                <span class="text-xs font-medium text-emerald-600 bg-amber-50 px-2 py-1 rounded-full">en attente</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2.5">
                                <div class="bg-emerald-500 h-2.5 rounded-full" style="width: 50%"></div>
                            </div>
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">Moy. </span>
                                <span class="text-xs text-gray-400">Moy. S6: 11.89</span>
                            </div>
                        </div>
                    </div>

                
                </div>
            </div> 

            <!-- Documents Section --
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 fade-in" style="animation-delay: 0.2s;">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Mes Documents Administratifs</h3>
                        <p class="text-sm text-gray-500">Téléchargez vos relevés, attestations et diplômes certifiés</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Rechercher..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>
                    </div>
                </div>  --->

            <!-- Footer -->
            <footer class="text-center py-6 text-sm text-gray-500">
                <p>© 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication. Tous droits réservés.</p>
                <p class="mt-1">Parakou, Bénin • <a href="#" class="text-primary-600 hover:underline">Mentions légales</a> • <a href="#" class="text-primary-600 hover:underline">Support technique</a></p>
            </footer>
        </main>
    </div>

    <!-- QR Verification Modal -->
    <div id="qrModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeQrModal()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 fade-in">
            <button onclick="closeQrModal()" class="absolute top-4 right-4 p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
            
            <div class="text-center mb-6">
                <div class="inline-flex p-3 bg-primary-50 rounded-full mb-4">
                    <i data-lucide="scan-line" class="w-6 h-6 text-primary-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Vérification d'authenticité</h3>
                <p class="text-sm text-gray-500 mt-1">Scannez le QR Code ou entrez le code du document</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Code du document</label>
                    <input type="text" id="qrCodeInput" placeholder="Ex: IRSBAC-2024-LM-0042-S1" class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm font-mono">
                </div>
                
                <button onclick="verifyDocument()" class="w-full py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4"></i> Vérifier le document
                </button>

                <!-- Verification Result -->
                <div id="verifyResult" class="hidden p-4 rounded-lg border">
                    <div class="flex items-start gap-3">
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-600 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-emerald-800">Document authentique</p>
                            <p class="text-sm text-emerald-700 mt-1">Ce document a été émis par l'IRSBAC et est officiellement certifié.</p>
                            <div class="mt-2 pt-2 border-t border-emerald-200 text-xs text-emerald-700 space-y-1">
                                <p><strong>Étudiant:</strong> Grâce EYITAYO</p>
                                <p><strong>Document:</strong> Relevé de Notes S1</p>
                                <p><strong>Émis le:</strong> 15 Juin 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500">Tous les documents officiels IRSBAC comportent un QR Code de vérification unique.</p>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // QR Modal
        function openQrModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('verifyResult').classList.add('hidden');
            document.getElementById('qrCodeInput').value = '';
        }

        function closeQrModal() {
            const modal = document.getElementById('qrModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function verifyDocument() {
            const code = document.getElementById('qrCodeInput').value.trim();
            const resultDiv = document.getElementById('verifyResult');
            
            // Simulate verification
            resultDiv.classList.remove('hidden');
            resultDiv.className = 'p-4 rounded-lg border bg-emerald-50 border-emerald-200 fade-in';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeQrModal();
            }
        });
    </script>
</body>
</html>

