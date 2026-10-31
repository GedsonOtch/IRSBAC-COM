<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance - IRSBAC</title>

     @vite('resources/css/app.css')

    <style>
        body {
            background: linear-gradient(135deg, #f8fafc, #eef2ff);
        }

        .floating {
            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

    <div class="max-w-2xl w-full">

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-red-500 to-red-700 p-8 text-center">

                <div class="floating inline-flex items-center justify-center w-20 h-20 rounded-full bg-white/20 backdrop-blur-sm mb-4">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8v4m0 4h.01M5.07 19H18.93c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />

                    </svg>

                </div>

                <h1 class="text-3xl font-bold text-white">
                    Plateforme temporairement indisponible
                </h1>

                <p class="text-blue-100 mt-2">
                    Maintenance en cours
                </p>

            </div>

            <!-- Contenu -->
            <div class="p-10 text-center">

                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    Nous améliorons actuellement nos services
                </h2>

                <p class="text-gray-600 leading-relaxed max-w-xl mx-auto">
                    La plateforme de gestion académique de l'IRSBAC est
                    momentanément inaccessible afin de permettre la réalisation
                    d'opérations de maintenance et d'amélioration.
                </p>

                <p class="text-gray-600 leading-relaxed mt-4 max-w-xl mx-auto">
                    Nous vous remercions pour votre compréhension et vous invitons
                    à revenir dans quelques instants.
                </p>

                <!-- Infos -->
                <div class="mt-8 grid md:grid-cols-2 gap-4">

                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                        <h3 class="font-semibold text-blue-900">
                            Établissement
                        </h3>
                        <p class="text-sm text-blue-700 mt-1">
                            IRSBAC - Institut Régional Supérieur des Beaux-Arts,
                            de la Culture et de la Communication
                        </p>
                    </div>

                    <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                        <h3 class="font-semibold text-emerald-900">
                            Support
                        </h3>
                        <p class="text-sm text-emerald-700 mt-1">
                            Contactez l'administration en cas d'urgence.
                        </p>
                    </div>

                </div>

                <!-- Bouton -->
                <div class="mt-8">

                    <button
                        onclick="window.location.reload()"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-medium transition">

                        Réessayer

                    </button>

                </div>

            </div>

            <!-- Footer -->
            <div class="border-t border-gray-100 bg-gray-50 py-4 text-center">

                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} IRSBAC — Tous droits réservés
                </p>

            </div>

        </div>

    </div>

</body>

</html>