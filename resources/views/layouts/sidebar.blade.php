<div x-data="{ sidebarOpen: false }" class="relative min-h-screen">

    <div class="md:hidden fixed top-0 left-0 p-4 z-[60]">
        <button @click="sidebarOpen = !sidebarOpen" 
                class="p-3 bg-stone-900 text-white rounded-xl shadow-2xl border border-stone-700/50 active:scale-95 transition-all">
            <svg x-show="!sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="sidebarOpen" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <aside 
        x-cloak
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-stone-900 text-white transform -translate-x-full transition-transform duration-300 ease-in-out md:translate-x-0 md:sticky md:flex flex-col h-screen shadow-2xl md:shadow-none">
        
        <div class="p-10">
            <h1 class="text-2xl font-black tracking-tighter italic text-white uppercase">CUP OF <span class="text-orange-500">ARC</span></h1>
            <div class="flex items-center gap-2 mt-2">
                <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                <p class="text-[9px] font-bold text-stone-500 uppercase tracking-[0.3em]">Management v2</p>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-3">
            <a href="{{ url('/') }}" 
               class="flex items-center gap-4 p-4 {{ Request::is('/') ? 'bg-orange-600 text-white' : 'hover:bg-stone-800 text-stone-400' }} rounded-[1.5rem] text-sm font-bold transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Ending
            </a>

            <a href="{{ route('inventory.manage') }}" 
               class="flex items-center gap-4 p-4 {{ Request::is('inventory/manage') ? 'bg-orange-600 text-white' : 'hover:bg-stone-800 text-stone-400' }} rounded-[1.5rem] text-sm font-bold transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Inventory
            </a>

            <a href="{{ route('inventory.monitor') }}" 
               class="flex items-center gap-4 p-4 {{ Request::is('inventory/monitor') ? 'bg-orange-600 text-white' : 'hover:bg-stone-800 text-stone-400' }} rounded-[1.5rem] text-sm font-bold transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Stock Monitor
            </a>

            <a href="{{ route('inventory.list') }}" 
               class="flex items-center justify-between p-4 {{ Request::is('inventory/list') ? 'bg-orange-600 text-white shadow-lg' : 'hover:bg-stone-800 text-stone-400' }} rounded-[1.5rem] text-sm font-bold transition-all group">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Shopping List
                </div>

                @php
                    $pendingCount = \App\Models\ShoppingList::where('is_bought', false)->count();
                @endphp
                
                @if($pendingCount > 0)
                    <span class="bg-white text-orange-600 text-[10px] font-black px-2 py-0.5 rounded-lg">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
        </nav>

        <div class="mt-auto px-6 pb-8">
            <div class="p-4 bg-stone-900/50 rounded-[1.5rem] border border-stone-800">
                <p class="text-[8px] font-black uppercase text-stone-500 tracking-widest mb-2 text-center">Active Session</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-3 p-3 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 md:hidden" 
         x-cloak>
    </div>
</div>