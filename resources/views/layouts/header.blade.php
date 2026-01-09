<header class="sticky top-0 z-40 px-8 py-4 flex justify-between items-center 
               bg-white/70 backdrop-blur-md border-b border-stone-200/50">
    
    <div class="flex items-center gap-3">
        <div class="w-1.5 h-6 bg-orange-600 rounded-full shadow-[0_0_10px_rgba(234,88,12,0.3)]"></div>
        
        <div class="flex flex-col">
            <h2 class="text-[11px] font-black uppercase tracking-[0.2em] text-stone-800 leading-none">
                {{-- DITO PAPASOK YUNG TITLE NG PAGE --}}
                @yield('header_title', 'Dashboard')
            </h2>
            <span class="text-[8px] font-bold text-stone-400 uppercase tracking-widest mt-1">
                Cup Of Arc Management
            </span>
        </div>
    </div>

    <div class="flex gap-6 items-center">
        <div class="hidden sm:flex flex-col items-end border-r border-stone-200 pr-6">
            <span class="text-[9px] font-black text-stone-300 uppercase tracking-tighter leading-none">Current Period</span>
            <span class="text-[10px] font-bold text-stone-800 uppercase">{{ now()->format('M Y') }}</span>
        </div>

        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="h-9 w-9 bg-stone-900 rounded-xl flex items-center justify-center text-white 
                        text-xs font-black shadow-lg group-hover:bg-orange-600 
                        transition-all duration-300 ring-4 ring-orange-50">
                A
            </div>
        </div>
    </div>
</header>