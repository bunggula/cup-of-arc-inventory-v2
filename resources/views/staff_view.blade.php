<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cup Of Arc | Inventory Audit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfbf9; }
        .glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); }
        .item-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="pb-32">

    <nav class="sticky top-0 z-50 glass border-b border-stone-200/40 p-5 px-6 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-[800] tracking-tighter text-stone-900 leading-none">CUP OF <span class="text-orange-600 italic">ARC</span></h1>
            <p class="text-[8px] font-bold text-stone-400 uppercase tracking-[0.3em] mt-1">Inventory Audit</p>
        </div>
        <div class="flex items-center gap-2 bg-stone-100 py-1.5 px-3 rounded-full border border-stone-200/50">
            <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
            <span class="text-[9px] font-bold text-stone-600 uppercase">Live Audit</span>
        </div>
    </nav>

    <main class="max-w-md mx-auto p-5">
        @foreach($groups as $category => $items)
            <div class="mt-8 mb-5 flex items-center gap-3">
                <div class="h-[2px] w-6 bg-orange-600"></div>
                <h2 class="text-xs font-[800] uppercase tracking-[0.2em] text-stone-400">{{ $category }}</h2>
            </div>

            <div class="grid gap-4">
                @foreach($items as $item)
                <div x-data="{ qty: {{ $item->quantity }}, original: {{ $item->quantity }} }" 
                     :class="qty != original ? 'ring-2 ring-orange-500/20 bg-orange-50/40 shadow-orange-100' : 'bg-white shadow-sm'"
                     class="item-card p-5 rounded-[2.5rem] flex items-center justify-between border border-stone-100 shadow-xl shadow-stone-200/10">
                    
                    <div class="pl-2">
                        <h3 class="font-bold text-stone-800 text-sm tracking-tight leading-tight">{{ $item->item_name }}</h3>
                        <p class="text-[9px] font-bold text-stone-300 uppercase mt-1 tracking-wider">{{ $item->unit }}</p>
                    </div>

                    <div class="flex items-center gap-1.5 bg-stone-50 p-1.5 rounded-full border border-stone-100">
                        <button @click="if(qty > 0) qty--" 
                                class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-stone-600 active:scale-90 transition-all font-bold text-lg hover:text-orange-600">
                            -
                        </button>
                        
                        <input type="number" x-model="qty" 
                               class="w-10 bg-transparent text-center font-extrabold text-sm outline-none text-stone-900">

                        <button @click="qty++" 
                                class="w-10 h-10 rounded-full bg-stone-900 text-white shadow-lg shadow-stone-900/20 flex items-center justify-center active:scale-90 transition-all font-bold text-lg">
                            +
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach
    </main>

    <div class="fixed bottom-0 left-0 right-0 p-6 glass border-t border-stone-200/30">
        <div class="max-w-md mx-auto">
            <button class="w-full bg-orange-600 text-white py-5 rounded-[2rem] font-extrabold text-xs uppercase tracking-[0.25em] shadow-2xl shadow-orange-600/30 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <span>Submit Audit Report</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </button>
        </div>
    </div>

</body>
</html>