<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administration - IRSBAC</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.8/index.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            overflow: hidden;
        }

        /* Arrière-plan animé doux (Gradient Mesh) - Thème Admin (Indigo/Violet) */
        .bg-mesh-admin {
            background: linear-gradient(-45deg, #1e1b4b, #312e81, #1e293b, #0f172a);
            background-size: 400% 400%;
            animation: gradientBGAdmin 20s ease infinite;
        }

        @keyframes gradientBGAdmin {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Formes flottantes douces */
        .blob-admin {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: floatAdmin 25s infinite ease-in-out;
            z-index: 0;
        }

        .blob-admin-1 {
            top: -10%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: #4f46e5;
            animation-delay: 0s;
        }

        .blob-admin-2 {
            bottom: -10%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: #7c3aed;
            animation-delay: -8s;
        }

        .blob-admin-3 {
            top: 40%;
            left: 60%;
            width: 400px;
            height: 400px;
            background: #3730a3;
            animation-delay: -15s;
        }

        @keyframes floatAdmin {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(40px, -60px) scale(1.1);
            }

            66% {
                transform: translate(-30px, 30px) scale(0.9);
            }
        }

        /* Animation d'entrée douce */
        .soft-enter-admin {
            animation: softEnterAdmin 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes softEnterAdmin {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Glassmorphism raffiné pour Admin */
        .glass-card-admin {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 30px rgba(79, 70, 229, 0.1);
        }

        /* Transitions douces pour les inputs */
        .input-soft-admin {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-soft-admin:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
        }

        /* Animation d'erreur douce */
        .error-soft-admin {
            animation: softSlideDownAdmin 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes softSlideDownAdmin {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Spinner de chargement élégant */
        .spinner-admin {
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            border-top: 2px solid #ffffff;
            width: 18px;
            height: 18px;
            animation: spinAdmin 0.8s linear infinite;
            display: none;
        }

        @keyframes spinAdmin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="text-slate-200 antialiased min-h-screen flex items-center justify-center relative">

    <!-- Éléments d'arrière-plan animés -->
    <div class="absolute inset-0 bg-mesh-admin z-0"></div>
    <div class="blob-admin blob-admin-1"></div>
    <div class="blob-admin blob-admin-2"></div>
    <div class="blob-admin blob-admin-3"></div>

    <!-- Carte de connexion Admin -->
    <div class="relative z-10 w-full max-w-md p-6">
        <div class="glass-card-admin rounded-3xl p-8 md:p-10 soft-enter-admin" id="adminLoginCard">

            <!-- En-tête -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-indigo-500/20 transform transition-transform duration-500 hover:scale-105 hover:rotate-3">
                   <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
      </div>
                    
                    <h1 class="text-2xl font-bold text-white tracking-tight">Espace Administration</h1>
                    <p class="text-sm text-indigo-300 italic mt-1 font-medium">IRSBAC - Gestion Académique</p>
                    <div class="w-12 h-1 bg-indigo-500/30 rounded-full mx-auto mt-4"></div>
                </div>

                <!-- Formulaire -->
                <form method="POST" id="adminLoginForm" class="space-y-5" novalidate action="{{ route('admin.login.submit') }}">
                    @csrf
                    <!-- Champ Identifiant / Email -->
                    <div class="group">
                        <label for="adminIdentifier" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 ml-1">Adresse Email</label>
                        <div class="relative">

                            <input type="email" id="adminIdentifier" name="email"
                                class="input-soft-admin block w-full pl-5 pr-4 py-3 bg-slate-800/40 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/50"
                                placeholder="admin@irsbac.com" required>
                            @error('email')
                            <p class="text-red-500">{{$message}}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Champ Mot de passe -->
                    <div class="group">
                        <label for="adminPassword" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5 ml-1">Mot de passe</label>
                        <div class="relative">

                            <input type="password" id="adminPassword" name="password"
                                class="input-soft-admin block w-full pl-5 pr-5 py-3 bg-slate-800/40 border border-slate-600/50 rounded-xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500/50"
                                placeholder="••••••••" required>

                            @error('password')
                            <p class="text-red-500">{{$message}}</p>
                            @enderror


                        </div>
                    </div>



                    <!-- Bouton de soumission -->
                    <button type="submit" id="adminSubmitBtn" class="w-full bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-indigo-500/20 transform transition-all duration-300 hover:-translate-y-0.5 hover:shadow-indigo-500/30 active:translate-y-0 active:shadow-sm flex items-center justify-center space-x-2 mt-2">
                        <div class="spinner-admin" id="adminLoadingSpinner"></div>
                        <span id="adminBtnText">Accéder au tableau de bord</span>
                    </button>
                </form>


                <!-- Pied de carte -->
                <div class="mt-8 pt-6 border-t border-slate-700/50 text-center">
                    <p class="text-xs text-slate-500">
                        Accès réservé au personnel autorisé. <br>

                    <p class="text-[10px] text-slate-600 mt-4 tracking-wide">© 2026 IRSBAC • Parakou, Bénin</p>
                </div>
            </div>
        </div>

        <script>
            // ==========================================
            // 2. GESTION DE LA SOUMISSION ET ANIMATIONS
            // ==========================================
            const adminLoginForm = document.getElementById('adminLoginForm');
            const adminLoginCard = document.getElementById('adminLoginCard');
            const adminSubmitBtn = document.getElementById('adminSubmitBtn');
            const adminBtnText = document.getElementById('adminBtnText');
            const adminLoadingSpinner = document.getElementById('adminLoadingSpinner');
            const adminErrorMessage = document.getElementById('adminErrorMessage');
            const adminErrorText = document.getElementById('adminErrorText');
            const adminIdentifierInput = document.getElementById('adminIdentifier');
            const adminPasswordInput = document.getElementById('adminPassword');
            adminLoginForm.addEventListener('submit', function(e) {


                const identifier = adminIdentifierInput.value.trim();
                const password = adminPasswordInput.value.trim();

                // Réinitialisation douce de l'état d'erreur

                adminIdentifierInput.classList.remove('border-red-500/50', 'focus:ring-red-500/40', 'focus:border-red-500/50');
                adminPasswordInput.classList.remove('border-red-500/50', 'focus:ring-red-500/40', 'focus:border-red-500/50');


                // Simulation d'appel API (État de chargement)
                adminSubmitBtn.disabled = true;
                adminSubmitBtn.classList.add('cursor-not-allowed', 'opacity-90');
                adminBtnText.textContent = "Authentification en cours...";
                adminLoadingSpinner.style.display = "block";

                setTimeout(() => {
                    // Simulation : "admin" / "admin" pour réussir, tout autre chose échoue
                    if (identifier.toLowerCase() === "admin" && password === "admin") {
                        // Succès
                        adminBtnText.textContent = "Connexion réussie";
                        adminLoadingSpinner.style.display = "none";
                        adminSubmitBtn.classList.remove('from-indigo-600', 'to-violet-600', 'hover:from-indigo-500', 'hover:to-violet-500');
                        adminSubmitBtn.classList.add('from-emerald-600', 'to-teal-600', 'hover:from-emerald-500', 'hover:to-teal-500');

                        setTimeout(() => {
                            // Ici, vous redirigeriez vers le tableau de bord admin
                            // window.location.href = '/admin/dashboard';
                            alert("Redirection vers le tableau de bord administratif...");
                            resetAdminButton(); // Pour la démo
                        }, 800);
                    } else {

                        resetAdminButton();
                    }
                }, 1200);
            });



            function resetAdminButton() {
                adminSubmitBtn.disabled = false;
                adminSubmitBtn.classList.remove('cursor-not-allowed', 'opacity-90', 'from-emerald-600', 'to-teal-600', 'hover:from-emerald-500', 'hover:to-teal-500');
                adminSubmitBtn.classList.add('from-indigo-600', 'to-violet-600', 'hover:from-indigo-500', 'hover:to-violet-500');
                adminBtnText.textContent = "Accéder au tableau de bord";
                adminLoadingSpinner.style.display = "none";
            }
        </script>
</body>

</html>