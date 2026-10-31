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
            <a href="{{ route('etudiant.profil') }}" class="flex items-center gap-3 px-4 py-3 text-blue-200 hover:bg-primary-800 hover:text-white rounded-lg transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg> Mon Profil
            </a>
            <a href="{{ route('etudiant.documents') }}" class="flex items-center gap-3 px-4 py-3 bg-primary-800 rounded-lg text-white font-medium">
                
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