<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Officiels - IRSBAC</title>
     @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.8/index.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        
        .fade-in-up {
            opacity: 0;
            transform: translateY(15px);
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }

        /* Modal Animations */
        .modal-backdrop {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .modal-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-content {
            transform: scale(0.95) translateY(10px);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .modal-backdrop.active .modal-content {
            transform: scale(1) translateY(0);
        }

        /* Document Page Styling (A4 Ratio) */
        .document-page {
            background: white;
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
            margin: 0 auto;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.1);
            color: #0f172a;
            font-size: 11pt;
            line-height: 1.5;
        }

        /* Print Styles */
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .modal-backdrop { 
                position: static !important; 
                background: white !important; 
                display: block !important; 
                opacity: 1 !important;
                padding: 0 !important;
            }
            .modal-content { 
                box-shadow: none !important; 
                max-height: none !important; 
                height: auto !important;
                border: none !important;
                border-radius: 0 !important;
            }
            .document-page {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 10mm !important;
                width: 100% !important;
                min-height: auto !important;
            }
            .modal-backdrop:not(.active) { display: none !important; }
        }

        .ue-row { background-color: #f8fafc; font-weight: 600; }
        .ecue-row { padding-left: 2rem; }
    </style>
</head>
<body class="text-slate-700 antialiased min-h-screen flex flex-col">

    <!-- PUBLIC VIEW (Affiché si un token est présent dans l'URL) -->
    <div id="public-view" class="hidden min-h-screen bg-slate-100 flex flex-col">
        <!-- Public Header -->
        <header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-30">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">I</div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-800">Vérification de Document</h1>
                        <p class="text-xs text-slate-500">IRSBAC - Plateforme d'Authentification</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-full border border-emerald-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-bold">Document Authentique et Vérifié</span>
                </div>
            </div>
        </header>

        <!-- Public Content -->
        <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900" id="public-doc-title">Attestation de Réussite</h2>
                    <p class="text-slate-500 mt-1">Ce document est accessible publiquement via un lien de vérification unique et sécurisé.</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.print()" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2 shadow-sm font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Télécharger le PDF</span>
                    </button>
                    <a href="?" class="bg-white border border-slate-300 text-slate-700 px-5 py-2.5 rounded-lg hover:bg-slate-50 transition-colors flex items-center space-x-2 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Retour</span>
                    </a>
                </div>
            </div>

            <!-- Document Preview Container -->
            <div class="bg-slate-200 p-4 md:p-8 rounded-2xl overflow-x-auto">
                <div id="public-document-container" class="document-page relative">
                    <!-- Injecté dynamiquement par JS -->
                </div>
            </div>

            <div class="mt-6 text-center text-xs text-slate-400">
                <p>Vérifié le <span id="verify-date"></span> • ID de vérification : <span class="font-mono text-slate-600" id="verify-id"></span></p>
                <p class="mt-1">© 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication</p>
            </div>
        </main>
    </div>

    <!-- STUDENT VIEW (Affiché par défaut) -->
    <div id="student-view" class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b border-slate-200 sticky top-0 z-30 shadow-sm no-print">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4">
                        <a href="#" onclick="window.history.back()" class="p-2 rounded-full hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm">I</div>
                            <div>
                                <h1 class="text-lg font-bold text-slate-800 tracking-tight">IRSBAC</h1>
                                <p class="text-xs text-slate-500 hidden sm:block">Espace Étudiant</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex flex-col items-end">
                            <span class="text-sm font-semibold text-slate-800">J. C. ATCHADE</span>
                            <span class="text-xs text-slate-500">IRSBAC-2024-00125</span>
                        </div>
                        <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 font-bold border border-blue-200">JA</div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
            
            <section class="mb-8 fade-in-up">
                <h2 class="text-2xl font-bold text-slate-900">Mes Documents Officiels</h2>
                <p class="text-slate-500 mt-1">Téléchargez vos documents ou partagez le lien public de vérification (accessible sans connexion).</p>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Attestation Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300 fade-in-up delay-100 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 border border-emerald-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Disponible</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Attestation de Réussite</h3>
                    <p class="text-sm text-slate-500 mb-6 flex-grow">Licence Professionnelle / BAPES en Lettres Modernes. Document officiel certifié.</p>
                    @if($etudiant->annee_etude != 3)

<div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-center">
    <p class="text-amber-700 font-medium">
        Cette attestation est uniquement disponible pour les étudiants de Licence 3.
    </p>
</div>

@elseif(!$attestation)

<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
    <p class="text-blue-700 font-medium">
        Votre attestation n'est pas encore disponible.
    </p>
    <p class="text-sm text-blue-600 mt-1">
        Veuillez patienter pendant sa génération par l'administration.
    </p>
</div>

@else

<button
    type="button"
    data-pdf="{{ asset('storage/'.$attestation->pdf_path) }}"
    onclick="openPdfModal(this.dataset.pdf)"
    class="w-full bg-white border border-slate-300 text-slate-700 font-medium py-2.5 px-4 rounded-lg hover:bg-slate-50 transition-colors flex items-center justify-center text-sm mb-5">

    <svg class="w-4 h-4 mr-2 text-slate-500"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24">

        <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
        </path>

        <path stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
        </path>

    </svg>

    Aperçu

</button>

       

    <a
        href="{{ asset('storage/'.$attestation->pdf_path) }}"
        download
        class="w-full bg-emerald-600 text-white font-medium py-2.5 px-4 rounded-lg hover:bg-emerald-700 transition-colors flex items-center justify-center text-sm shadow-sm shadow-emerald-500/20">

        <svg class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
            </path>

        </svg>

        Télécharger PDF

    </a>

</div>

@endif
                        
                        <!-- NOUVEAU : Lien public sans connexion -->
                        <div class="pt-3 border-t border-slate-100">
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Lien public de vérification (sans connexion)</label>
                            <div class="flex space-x-2">
                                <input type="text" readonly value="https://irsbac.com/verify/att-8x9y2z" class="flex-1 bg-slate-50 border border-slate-200 text-slate-600 text-xs rounded-lg px-3 py-2 focus:outline-none font-mono">
                                <button onclick="copyLink('https://irsbac.com/verify/att-8x9y2z')" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-2 rounded-lg transition-colors" title="Copier le lien">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                                <button onclick="simulatePublicAccess('attestation')" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-2 rounded-lg transition-colors" title="Tester le lien public">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </button>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1.5">Toute personne disposant de ce lien peut consulter et télécharger ce document sans avoir à se connecter.</p>
                        </div>
                    </div>
                </div>

                <!-- Bulletin Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md hover:-translate-y-1 transition-all duration-300 fade-in-up delay-200 flex flex-col">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 border border-blue-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">Disponible</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-1">Relevé de Notes (Semestre 1)</h3>
                    <p class="text-sm text-slate-500 mb-6 flex-grow">Détail des notes, moyennes par UE, crédits obtenus et décision du jury.</p>
                    <div class="space-y-3 mt-auto">
                        <button onclick="openModal('bulletin')" class="w-full bg-white border border-slate-300 text-slate-700 font-medium py-2.5 px-4 rounded-lg hover:bg-slate-50 transition-colors flex items-center justify-center text-sm">
                            <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Aperçu
                        </button>
                        <button onclick="openModal('bulletin'); setTimeout(window.print, 300)" class="w-full bg-blue-600 text-white font-medium py-2.5 px-4 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center text-sm shadow-sm shadow-blue-500/20">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Télécharger PDF
                        </button>

                        <!-- NOUVEAU : Lien public sans connexion -->
                        <div class="pt-3 border-t border-slate-100">
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5 block">Lien public de vérification (sans connexion)</label>
                            <div class="flex space-x-2">
                                <input type="text" readonly value="https://irsbac.com/verify/bul-3k7m9p" class="flex-1 bg-slate-50 border border-slate-200 text-slate-600 text-xs rounded-lg px-3 py-2 focus:outline-none font-mono">
                                <button onclick="copyLink('https://irsbac.com/verify/bul-3k7m9p')" class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-2 rounded-lg transition-colors" title="Copier le lien">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                                <button onclick="simulatePublicAccess('bulletin')" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-3 py-2 rounded-lg transition-colors" title="Tester le lien public">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </button>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-1.5">Toute personne disposant de ce lien peut consulter et télécharger ce document sans avoir à se connecter.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 mt-auto no-print">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-center md:text-left">
                        <p class="text-sm font-semibold text-slate-900">IRSBAC.Com</p>
                        <p class="text-xs text-slate-500">Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication</p>
                    </div>
                    <div class="text-xs text-slate-400 text-center md:text-right">
                        <p>&copy; 2026 IRSBAC. Tous droits réservés.</p>
                        <p class="mt-1">Quartier Ladjifarani, Parakou, République du Bénin</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- MODAL: Attestation de Réussite (Student View) -->
    
    <div
    id="pdfModal"
    class="hidden fixed inset-0 z-50 bg-black/70">

    <div class="absolute inset-0 flex items-center justify-center p-4">

        <div class="bg-white rounded-xl w-full max-w-6xl h-[90vh] relative">

            <button
                onclick="closePdfModal()"
                class="absolute top-4 right-4 z-10 bg-red-500 text-white w-10 h-10 rounded-full">

                ✕

            </button>

            <iframe
                id="pdfViewer"
                class="w-full h-full rounded-xl">
            </iframe>

        </div>

    </div>

</div>
                   
    <!-- MODAL: Relevé de Notes (Student View) -->
    <div id="modal-bulletin" class="modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm no-print">
        <div class="modal-content bg-white rounded-2xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Aperçu : Relevé de Notes (Semestre 1)
                </h3>
                <div class="flex space-x-2">
                    <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center space-x-2 shadow-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Imprimer / PDF</span>
                    </button>
                    <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 p-2 hover:bg-slate-200 rounded-full transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto p-6 bg-slate-100">
                <div class="document-page print-area relative" id="bulletin-content">
                    <div class="text-center border-b-2 border-slate-800 pb-4 mb-6">
                        <p class="text-sm font-bold italic mb-2">"Toujours plus haut, Toujours plus fort"</p>
                        <h1 class="text-2xl font-black text-blue-900 tracking-wide mb-1">IRSBAC.Com</h1>
                        <p class="text-sm font-semibold uppercase tracking-wide">Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication</p>
                        <p class="text-xs text-slate-600 mt-2">Autorisé par arrêté N° 008/ MESRS/CAB/DC/SGM/DPP/DGESS/DEPES/SP du 05 Janvier 2011</p>
                        <p class="text-xs text-slate-600">Quartier Ladjifarani Parakou Tél. 01 97 76 36 43 • République du Bénin</p>
                    </div>

                    <h2 class="text-center text-xl font-black uppercase border-2 border-slate-900 p-2 mb-6 tracking-wider">RELEVE DE NOTES DE L'ETUDIANT</h2>

                    <div class="grid grid-cols-2 gap-x-8 gap-y-2 mb-6 text-sm border border-slate-300 p-4 rounded">
                        <div><span class="font-bold">Nom :</span> ATCHADE</div>
                        <div><span class="font-bold">Année Universitaire :</span> 2024-2025</div>
                        <div><span class="font-bold">Prénoms :</span> Julien Chambi</div>
                        <div><span class="font-bold">Année d’étude :</span> 1ère année</div>
                        <div><span class="font-bold">Date et lieu de naissance :</span> 15/04/2000 à Parakou</div>
                        <div><span class="font-bold">Filière :</span> BAPES / Lettres Modernes</div>
                        <div><span class="font-bold">Matricule :</span> IRSBAC-2024-00125</div>
                        <div><span class="font-bold">Semestre :</span> 1</div>
                    </div>

                    <table class="w-full text-left border-collapse border border-slate-800 text-xs mb-6">
                        <thead>
                            <tr class="bg-slate-100">
                                <th class="border border-slate-800 px-2 py-2 w-1/2">Intitulé des UE / Intitulé des ECUE</th>
                                <th class="border border-slate-800 px-2 py-2 text-center w-20">Note</th>
                                <th class="border border-slate-800 px-2 py-2 text-center w-20">Moyenne</th>
                                <th class="border border-slate-800 px-2 py-2 text-center w-16">Crédit</th>
                                <th class="border border-slate-800 px-2 py-2 text-center w-24">Décision</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Communication et Enseignement</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">12.50</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">3</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Introduction à la communication</td><td class="border border-slate-800 px-2 py-1 text-center">12.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Niveaux de langues et expression</td><td class="border border-slate-800 px-2 py-1 text-center">13.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                            
                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Culture générale</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">13.00</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">2</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Culture Générale</td><td class="border border-slate-800 px-2 py-1 text-center">13.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>

                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Genres littéraires</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">12.25</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">4</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">La Notion de genres littéraires</td><td class="border border-slate-800 px-2 py-1 text-center">12.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Des considérations de genres aux oeuvres</td><td class="border border-slate-800 px-2 py-1 text-center">12.50</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>

                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Littérature Française</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">10.00</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">5</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">La littérature française jusqu'au 15e siècle</td><td class="border border-slate-800 px-2 py-1 text-center">10.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>

                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Méthodologie des études françaises</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">12.00</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">4</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Contraction de texte</td><td class="border border-slate-800 px-2 py-1 text-center">12.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Dissertation</td><td class="border border-slate-800 px-2 py-1 text-center">12.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>

                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Linguistique générale</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">12.50</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">4</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Phonétique et Phonologie</td><td class="border border-slate-800 px-2 py-1 text-center">15.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Introduction à la linguistique générale</td><td class="border border-slate-800 px-2 py-1 text-center">10.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>

                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Société et Education</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">14.50</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">4</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Aspect conceptuel de l'éducation</td><td class="border border-slate-800 px-2 py-1 text-center">12.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Introduction à la sociologie de l'éducation</td><td class="border border-slate-800 px-2 py-1 text-center">17.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>

                            <tr class="ue-row"><td class="border border-slate-800 px-2 py-1 font-semibold">Pédagogie générale</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center font-bold">13.50</td><td class="border border-slate-800 px-2 py-1 text-center font-bold">4</td><td class="border border-slate-800 px-2 py-1 text-center font-bold text-emerald-700">Validée</td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Introduction à la didactique</td><td class="border border-slate-800 px-2 py-1 text-center">13.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                            <tr class="ecue-row"><td class="border border-slate-800 px-2 py-1">Les grands courants pédagogiques</td><td class="border border-slate-800 px-2 py-1 text-center">14.00</td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td><td class="border border-slate-800 px-2 py-1 text-center"></td></tr>
                        </tbody>
                        <tfoot>
                            <tr class="bg-slate-100 font-bold">
                                <td class="border border-slate-800 px-2 py-2 text-right" colspan="3">Total UE validé 8 sur 8</td>
                                <td class="border border-slate-800 px-2 py-2 text-center">30</td>
                                <td class="border border-slate-800 px-2 py-2 text-center"></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="grid grid-cols-3 gap-6 mt-8 border-t-2 border-slate-800 pt-6">
                        <div class="text-center">
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Moyenne du semestre</p>
                            <p class="text-3xl font-black text-slate-900">12.42</p>
                        </div>
                        <div class="text-center flex flex-col justify-center items-center">
                            <p class="text-xs font-bold text-slate-600 uppercase mb-2">Mention</p>
                            <span class="text-xl font-black px-4 py-1 rounded bg-amber-100 text-amber-800 border border-amber-300">ASSEZ BIEN</span>
                        </div>
                        <div class="text-center">
                            <p class="text-xs font-bold text-slate-600 uppercase mb-1">Décision du Jury</p>
                            <p class="text-2xl font-black text-emerald-700 mt-1">VALIDÉ</p>
                        </div>
                    </div>

                    <div class="mt-12 text-center">
                        <p class="text-sm font-bold mb-12">Signature et cachet du Directeur</p>
                        <div class="h-20 w-48 mx-auto border-2 border-dashed border-slate-300 rounded flex items-center justify-center text-slate-400 text-xs mb-2">Cachet et Signature</div>
                        <p class="font-semibold border-t border-slate-400 pt-2 w-48 mx-auto">Dr. Julien Chambi ATCHADE</p>
                    </div>

                    <div class="absolute bottom-10 left-0 right-0 text-center border-t border-slate-200 pt-4">
                        <p class="text-[10px] text-slate-500 mb-2 uppercase tracking-wider">Document généré automatiquement. Vérifiable via le QR Code ou le lien public ci-dessous.</p>
                        <div class="inline-flex flex-col items-center space-y-2">
                            <div id="qrcode-bul" class="p-2 bg-white border border-slate-200 rounded shadow-sm"></div>
                            <p class="text-[10px] text-blue-600 font-mono">https://irsbac.com/verify/bul-3k7m9p</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Vérifier si nous sommes en mode "Vue Publique" (simulé via l'URL)
        const urlParams = new URLSearchParams(window.location.search);
        const isPublicView = urlParams.get('public') === 'true';
        const publicDocType = urlParams.get('doc'); // 'attestation' ou 'bulletin'

        if (isPublicView && publicDocType) {
            // Afficher la vue publique
            document.getElementById('student-view').classList.add('hidden');
            document.getElementById('public-view').classList.remove('hidden');
            
            // Injecter le contenu du document
            const sourceContent = document.getElementById(publicDocType === 'attestation' ? 'attestation-content' : 'bulletin-content').innerHTML;
            document.getElementById('public-document-container').innerHTML = sourceContent;
            
            // Mettre à jour les métadonnées de vérification
            document.getElementById('public-doc-title').textContent = publicDocType === 'attestation' ? 'Attestation de Réussite' : 'Relevé de Notes (Semestre 1)';
            document.getElementById('verify-date').textContent = new Date().toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit' });
            document.getElementById('verify-id').textContent = publicDocType === 'attestation' ? 'VERIFY-ATT-8X9Y2Z' : 'VERIFY-BUL-3K7M9P';
        }


function openPdfModal(url)
{
    document
        .getElementById('pdfViewer')
        .src = url;

    document
        .getElementById('pdfModal')
        .classList
        .remove('hidden');
}

function closePdfModal()
{
    document
        .getElementById('pdfModal')
        .classList
        .add('hidden');

    document
        .getElementById('pdfViewer')
        .src = '';
}



        // Fonctions de gestion des modales (Vue Étudiant)
        let qrAttGenerated = false;
        let qrBulGenerated = false;

        function openModal(type) {
            const modal = document.getElementById(`modal-${type}`);
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';

            if (type === 'attestation' && !qrAttGenerated) {
                new QRCode(document.getElementById("qrcode-att"), {
                    text: "https://irsbac.com/verify/att-8x9y2z",
                    width: 100,
                    height: 100,
                    colorDark : "#0f172a",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
                qrAttGenerated = true;
            } else if (type === 'bulletin' && !qrBulGenerated) {
                new QRCode(document.getElementById("qrcode-bul"), {
                    text: "https://irsbac.com/verify/bul-3k7m9p",
                    width: 100,
                    height: 100,
                    colorDark : "#0f172a",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
                qrBulGenerated = true;
            }
        }

        function closeModal() {
            document.querySelectorAll('.modal-backdrop').forEach(modal => {
                modal.classList.remove('active');
            });
            document.body.style.overflow = '';
        }

        // Fermer la modale en cliquant à l'extérieur
        document.querySelectorAll('.modal-backdrop').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        });

        // Fermer avec la touche Echap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });

        // Fonction pour copier le lien public
        function copyLink(link) {
            navigator.clipboard.writeText(link).then(() => {
                // Feedback visuel temporaire
                const btn = event.currentTarget;
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                btn.classList.add('bg-emerald-100');
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('bg-emerald-100');
                }, 2000);
            });
        }

        // Fonction pour simuler l'accès public (ouvre la même page avec les params URL)
        function simulatePublicAccess(type) {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('public', 'true');
            currentUrl.searchParams.set('doc', type);
            window.open(currentUrl.toString(), '_blank');
        }
    </script>
</body>
</html>

