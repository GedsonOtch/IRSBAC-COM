<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - IRSBAC</title>
     @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.8/index.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            overflow: hidden;
        }

        /* Arrière-plan animé doux (Gradient Mesh) */
        .bg-mesh {
            background: linear-gradient(-45deg, #e0e7ff, #f0f9ff, #e0f2fe, #f1f5f9);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
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
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: float 20s infinite ease-in-out;
            z-index: 0;
        }

        .blob-1 {
            top: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: #bfdbfe;
            animation-delay: 0s;
        }

        .blob-2 {
            bottom: -10%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: #ddd6fe;
            animation-delay: -5s;
        }

        .blob-3 {
            top: 40%;
            left: 40%;
            width: 400px;
            height: 400px;
            background: #bae6fd;
            animation-delay: -10s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        /* Animation d'entrée douce */
        .soft-enter {
            animation: softEnter 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes softEnter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Glassmorphism raffiné */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.05), 0 0 20px rgba(255, 255, 255, 0.5);
        }

        /* Transitions douces pour les inputs */
        .input-soft {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-soft:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        /* Animation d'erreur douce */
        .error-soft {
            animation: softSlideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes softSlideDown {
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
        .spinner {
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 2px solid #ffffff;
            width: 18px;
            height: 18px;
            animation: spin 0.8s linear infinite;
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="text-slate-700 antialiased min-h-screen flex items-center justify-center relative">

    <!-- Éléments d'arrière-plan animés -->
    <div class="absolute inset-0 bg-mesh z-0"></div>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <!-- Carte de connexion -->
    <div class="relative z-10 w-full max-w-md p-6">
        <div class="glass-card rounded-3xl p-8 md:p-10 soft-enter" id="loginCard">

            <!-- En-tête -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg shadow-blue-500/20 transform transition-transform duration-500 hover:scale-105 hover:rotate-3">
                    <span class="text-2xl font-black text-white">I</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">IRSBAC-COM</h1>
                <p class="text-sm text-slate-500 italic mt-1 font-medium">"Toujours plus haut, Toujours plus fort"</p>
                <div class="w-12 h-1 bg-blue-100 rounded-full mx-auto mt-4"></div>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('etudiant.login.submit') }}" method="POST" id="loginForm" class="space-y-5" novalidate>
                @csrf

                <!-- Champ Matricule -->
                <div class="group">
                    <label for="matricule" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Matricule</label>
                    <div class="relative">
                      
                        <input type="text" id="matricule" name="matricule" value="{{old('matricule')}}"
                            class="input-soft block w-full pl-5 pr-4 py-3 bg-white/60 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none    {{ $errors->has('matricule') 
                             ? 'border-red-500 bg-red-50 focus:ring-red-300' 
                             : 'border-gray-300 focus:ring-blue-300' }}  focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400"
                            placeholder="Ex: IRSBAC-2024-00125" required>
   @error('matricule')
              
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                
                @enderror
                    </div>
                </div>

                <!-- Champ Mot de passe -->
                <div class="group">
                    <label for="password" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5 ml-1">Mot de passe</label>
                    <div class="relative">
                       
                        <input type="password" id="password" name="password"
                            class="input-soft block w-full pl-5 pr-12 py-3 bg-white/60 border border-slate-200 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400/30 focus:border-blue-400"
                            placeholder="••••••••" required>
                               @error('password')
              
                <p class="text-red-500 text-sm mt-1">
                    {{ $message }}
                </p>
                
                @enderror

                        <!-- Bouton Voir/Masquer -->
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors duration-300 cursor-pointer focus:outline-none">
                           
                            <svg id="eyeOffIcon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between text-sm pt-1">
                    <label class="flex items-center cursor-pointer group select-none">
                        <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-400/50 focus:ring-offset-0 transition-colors cursor-pointer">
                        <span class="ml-2 text-slate-500 group-hover:text-slate-700 transition-colors duration-300">Se souvenir de moi</span>
                    </label>
                    
                </div>
             
               

                <!-- Bouton de soumission -->
                <button type="submit" id="submitBtn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-500/25 transform transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/40 active:translate-y-0 active:shadow-sm flex items-center justify-center space-x-2 mt-2">
                    <div class="spinner" id="loadingSpinner"></div>
                    <span id="btnText">Se connecter</span>
                </button>
            </form>

            <!-- Pied de carte -->
            <div class="mt-2 pt-6 border-t border-slate-200/60 text-center">
               
                <p class="text-[10px] text-slate-400 mt-1 tracking-wide">© 2026 IRSBAC-COM • Parakou, Bénin</p>
            </div>
        </div>
    </div>

    <script>
        // ==========================================
        // GESTION DE LA SOUMISSION
        // ==========================================
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');
        const matriculeInput = document.getElementById('matricule');
        const passwordInput = document.getElementById('password');

        loginForm.addEventListener('submit', function(e) {

            const matricule = matriculeInput.value.trim();
            const password = passwordInput.value.trim();

            // Réinitialisation de l'état d'erreur
        

           /* matriculeInput.classList.remove(
                'border-red-300',
                'focus:ring-red-400/30',
                'focus:border-red-400'
            );*/

            passwordInput.classList.remove(
                'border-red-300',
                'focus:ring-red-400/30',
                'focus:border-red-400'
            );

         

            // Animation du bouton
            submitBtn.disabled = true;

            submitBtn.classList.add(
                'cursor-not-allowed',
                'opacity-90'
            );

            btnText.textContent = "Connexion en cours...";

            loadingSpinner.style.display = "block";
        });

      

         
        
    </script>
</body>

</html>