<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Documents - IRSBAC</title>
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
        .modal-overlay { background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); }
        .a4-page {
            width: 210mm;
            min-height: 297mm;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin: 0 auto;
            padding: 20mm;
            position: relative;
        }
        @media (max-width: 768px) {
            .a4-page { width: 100%; min-height: auto; padding: 15px; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

@include('etudiant.nav_stud');

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
                        <h2 class="text-xl font-bold text-gray-900">Mes Documents</h2>
                        <p class="text-sm text-gray-500">Téléchargez et vérifiez vos documents académiques certifiés</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-semibold text-gray-900">{{$etudiant->nom }}  {{$etudiant->prenom}}</p>
                        <p class="text-xs text-gray-500">Mat: {{$etudiant->matricule}}</p>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                          <img src="{{ auth()->guard('etudiant')->user()->photo_url }}" alt="" class="w-9 h-9 rounded-full object-cover border-2 border-primary-100">
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="flex-1 p-4 lg:p-8 space-y-6">
            
            <!-- Stats -->
             
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 fade-in">
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg"><i data-lucide="file-check" class="w-6 h-6 text-primary-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Documents disponibles</p>
@if($nbDoc)
                        <p class="text-2xl font-bold text-gray-900">{{$etudiant->est_en_regle ? $nbDoc : '-'}}</p>
                    @endif
                    </div>
                </div>
                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-emerald-50 rounded-lg"><i data-lucide="shield-check" class="w-6 h-6 text-emerald-600"></i></div>
                    <div>
                        <p class="text-sm text-gray-500">Documents certifiés</p>
                       @if($nbDoc) <p class="text-2xl font-bold text-gray-900">{{$etudiant->est_en_regle ? $nbDoc : '-'}}</p> @endif
                    </div>
                </div>
              
            </div>

            <!-- Documents List --
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 fade-in" style="animation-delay: 0.1s;">
                <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <h3 class="text-lg font-bold text-gray-900">Liste des documents</h3>
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="searchInput" onkeyup="filterDocuments()" placeholder="Rechercher un document..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent w-full sm:w-64">
                        </div>
                    </div>
                </div>
-->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 text-left">
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Document</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                    
                            

<tbody
class="divide-y divide-gray-100"
id="documentsTableBody">
@if($etudiant->est_en_regle)
@forelse($documents as $document)

<tr>

    <td class="px-6 py-4">

        {{ $document['nom'] }}

    </td>

    <td class="px-6 py-4">

        {{ $document['type'] }}

    </td>

    <td class="px-6 py-4">

        {{ $document['date']->format('d/m/Y') }}

    </td>

    <td class="px-6 py-4">

        <span
        class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">

            Disponible

        </span>

    </td>

    <td class="px-6 py-4">

        <div
        class="flex justify-end gap-2">

            <button

            type="button"

            onclick="openDocumentPreview(
                `{{ $document['preview_route'] }}`
            )"

            class="p-2 rounded-lg hover:bg-blue-100 text-blue-600">

               
            <svg id="" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
            

            </button>

            <a

            href="{{ $document['download_route'] }}"

            class="p-2 rounded-lg hover:bg-green-100 text-green-600">

                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>

            </a>

        </div>

    </td>

</tr>

@empty

<tr>

<td
colspan="5"
class="text-center py-10 text-gray-500">

Aucun document disponible

</td>

</tr>

@endforelse

</tbody>
    @endif  
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <footer class="text-center py-6 text-sm text-gray-500">
                <p>© 2026 IRSBAC - Institut Régional Supérieur des Beaux-Arts, de la Culture et de la Communication.</p>
                <p class="mt-1">Parakou, Bénin</p>
            </footer>
        </main>
    </div>

    <!-- Preview Modal -->
    <div
id="documentPreviewModal"
class="fixed inset-0 z-50 hidden">

    <div
    class="absolute inset-0 bg-black/60"
    onclick="closeDocumentPreview()">
    </div>

    <div
    class="absolute inset-4 bg-white rounded-xl shadow-xl flex flex-col">

        <div
        class="p-4 border-b flex justify-between items-center">

            <h3 class="font-semibold">

                Aperçu du document

            </h3>

            <button
            onclick="closeDocumentPreview()">

                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>

            </button>

        </div>

        <iframe
        id="documentPreviewFrame"
        class="w-full flex-1">
        </iframe>

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

           lucide.createIcons();


function openDocumentPreview(
    url
)
{
    document
        .getElementById(
            'documentPreviewFrame'
        )
        .src = url;

    document
        .getElementById(
            'documentPreviewModal'
        )
        .classList
        .remove(
            'hidden'
        );
}

function closeDocumentPreview()
{
    document
        .getElementById(
            'documentPreviewFrame'
        )
        .src = '';

    document
        .getElementById(
            'documentPreviewModal'
        )
        .classList
        .add(
            'hidden'
        );
}

lucide.createIcons();

    </script>
</body>
</html>

