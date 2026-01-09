@extends('layouts.app')
@section('header_title', 'list')
@section('content')
<div class="max-w-3xl mx-auto pb-20 px-4" x-data="{ openDeleteModal: false, deleteUrl: '' }">
    
    <div class="mb-10 flex justify-between items-start">
        <div class="flex-1 text-center">
            <h1 class="text-3xl font-black text-stone-800 uppercase tracking-tighter italic">
                Shopping <span class="text-orange-600">Archive</span>
            </h1>
            <div class="flex flex-col items-center mt-1">
                <p class="text-[10px] font-bold text-stone-400 uppercase tracking-[0.3em]">Daily Purchase Monitoring</p>
                
                {{-- ACCURATE AUDIT SYNC INDICATOR --}}
                <div class="mt-2 flex items-center gap-2">
                    @php 
                        // Kinukuha ang huling item na naging 'is_bought' 
                        // Ito ang pinaka-accurate na basehan ng huling stock update/audit
                        $lastPurchase = \App\Models\ShoppingList::where('is_bought', true)
                                            ->latest('updated_at')
                                            ->first();
                        
                        // Check kung lagpas 24 hours na para magpalit ng kulay
                        $isOld = $lastPurchase && $lastPurchase->updated_at->diffInHours(now()) > 24;
                    @endphp

                    <span class="w-1.5 h-1.5 rounded-full {{ $isOld ? 'bg-orange-500 animate-bounce' : 'bg-green-500 animate-pulse' }}"></span>
                    <span class="text-[9px] font-black text-stone-500 uppercase tracking-widest">
                        {{ $isOld ? 'Audit Needed:' : 'Last Sync:' }} 
                        {{ $lastPurchase ? \Carbon\Carbon::parse($lastPurchase->updated_at)->timezone('Asia/Manila')->format('h:i A') : 'No Recent Activity' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- PRINT BUTTON --}}
        <a href="{{ route('inventory.print') }}" target="_blank" 
           class="p-3 bg-stone-900 text-white rounded-2xl hover:bg-orange-600 transition-all shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2m8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
        </a>
    </div>

    @forelse($shoppingItems as $date => $items)
        <div class="mb-10">
            <div class="flex items-center gap-3 mb-4">
                <span class="bg-stone-900 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-sm">
                    @if($date === 'Pending')
                        🛒 To Buy (Pending)
                    @else
                        📅 {{ \Carbon\Carbon::parse($date)->format('M d, Y') }} 
                        @if($date == date('Y-m-d')) <span class="text-orange-400 ml-2">— TODAY</span> @endif
                    @endif
                </span>
                <div class="h-px flex-1 bg-stone-200/60"></div>
            </div>

            <div class="bg-white rounded-[2rem] border border-stone-100 shadow-sm overflow-hidden">
                <div class="divide-y divide-stone-50">
                    @foreach($items as $item)
                    <div class="p-5 flex items-center justify-between transition-all border-b border-stone-100/50 {{ $item->is_bought ? 'bg-stone-50/60' : 'bg-white hover:bg-orange-50/20' }}">
                        
                        <div class="flex items-center gap-5">
                            {{-- CHECKBOX TOGGLE --}}
                            <form action="/toggle-bought/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-9 h-9 rounded-2xl border-2 flex items-center justify-center transition-all 
                                        {{ $item->is_bought 
                                            ? 'bg-green-600 border-green-600 text-white shadow-md shadow-green-100' 
                                            : 'border-stone-300 hover:border-orange-500 bg-white text-transparent' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>

                            <div>
                                <h3 class="font-black text-[13px] uppercase tracking-wide transition-all
                                    {{ $item->is_bought 
                                        ? 'text-stone-400 line-through decoration-2 decoration-stone-300' 
                                        : 'text-stone-800' }}">
                                    {{ $item->inventory->item_name }}
                                </h3>
                                
                                <div class="flex items-center gap-3 mt-1.5">
                                    <span class="text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-tighter
                                        {{ $item->is_bought 
                                            ? 'bg-stone-200 text-stone-500' 
                                            : 'bg-orange-100 text-orange-700' }}">
                                        Stock: {{ $item->inventory->quantity }} {{ $item->inventory->unit ?? 'pcs' }}
                                    </span>
                                    
                                    <span class="text-[10px] font-bold uppercase tracking-widest
                                        {{ $item->is_bought ? 'text-stone-300' : 'text-stone-400' }}">
                                        | {{ $item->inventory->category }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- DELETE BUTTON --}}
                        <button type="button" 
                                @click="openDeleteModal = true; deleteUrl = '/remove-from-list/{{ $item->id }}'"
                                class="p-2.5 rounded-xl text-stone-300 hover:text-red-600 hover:bg-red-50 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="py-20 text-center">
            <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4 text-stone-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <p class="text-[10px] font-black text-stone-400 uppercase tracking-[0.2em]">Your shopping list is empty</p>
        </div>
    @endforelse

    {{-- DELETE MODAL --}}
    <div x-show="openDeleteModal" 
         class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-stone-900/40 backdrop-blur-sm"
         x-cloak x-transition>
        
        <div @click.away="openDeleteModal = false" 
             class="bg-white rounded-[2.5rem] p-8 max-w-sm w-full shadow-2xl border border-stone-100 text-center">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h2 class="text-xl font-black text-stone-800 uppercase tracking-tighter mb-2">Remove Item?</h2>
            <p class="text-xs font-bold text-stone-400 uppercase tracking-widest leading-relaxed mb-8">This will remove the item from your shopping history.</p>
            <div class="flex flex-col gap-3">
                <form :action="deleteUrl" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-4 bg-red-500 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-red-600 transition-all shadow-lg shadow-red-100">
                        Yes, Remove Now
                    </button>
                </form>
                <button @click="openDeleteModal = false" class="w-full py-4 bg-stone-50 text-stone-400 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-stone-100 transition-all">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
@endsection