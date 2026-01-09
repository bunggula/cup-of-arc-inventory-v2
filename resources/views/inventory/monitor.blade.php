@extends('layouts.app')
@section('header_title', 'Stock Masterlist')
@section('content')

<div class="max-w-6xl mx-auto pb-10 px-4 md:px-6" x-data="{ showDuplicateModal: false, itemName: '' }">
    
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
        <div>
            <h1 class="text-2xl font-black text-stone-800 uppercase tracking-tighter">Stock <span class="text-orange-600">Monitor</span></h1>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-0.5">Live status of ingredients</p>
        </div>
        
        <div class="flex gap-3 bg-white border border-stone-100 p-2 rounded-xl shadow-sm">
            <div class="flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-red-500"></div><span class="text-[8px] font-black uppercase text-stone-500">Out</span></div>
            <div class="flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-orange-500"></div><span class="text-[8px] font-black uppercase text-stone-500">Low</span></div>
            <div class="flex items-center gap-1.5"><div class="w-1.5 h-1.5 rounded-full bg-green-500"></div><span class="text-[8px] font-black uppercase text-stone-500">Good</span></div>
        </div>
    </div>

    @foreach($groups as $category => $items)
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-3">
            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-stone-500">{{ $category }}</h2>
            <div class="h-px flex-1 bg-stone-200/50"></div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($items as $item)
            @php
                $alreadyInList = \App\Models\ShoppingList::where('inventory_id', $item->id)
                                    ->where('is_bought', false)
                                    ->exists();

                // STATUS LOGIC (Based sa input niyo sa Audit)
                $val = (int)$item->quantity;

                if($val <= 1) {
                    $bgColor = 'bg-red-50'; $borderColor = 'border-red-100'; 
                    $accentColor = 'bg-red-500'; $textColor = 'text-red-700'; 
                    $btnColor = 'bg-red-600 text-white'; $statusLabel = 'Out of Stock';
                } elseif($val == 2) {
                    $bgColor = 'bg-orange-50'; $borderColor = 'border-orange-100'; 
                    $accentColor = 'bg-orange-500'; $textColor = 'text-orange-700'; 
                    $btnColor = 'bg-orange-600 text-white'; $statusLabel = 'Running Low';
                } else {
                    $bgColor = 'bg-green-50'; $borderColor = 'border-green-100'; 
                    $accentColor = 'bg-green-500'; $textColor = 'text-green-700'; 
                    $btnColor = 'bg-green-600 text-white'; $statusLabel = 'Healthy';
                }
            @endphp

            <div class="{{ $bgColor }} border {{ $borderColor }} p-4 rounded-[1.5rem] shadow-sm hover:shadow-md transition-all relative group overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 {{ $accentColor }} opacity-50"></div>

                <div class="flex flex-col h-full mt-1">
                    <div>
                        <h3 class="font-black {{ $textColor }} text-xs sm:text-sm leading-tight uppercase truncate pr-4 italic tracking-tighter">
                            {{ $item->item_name }}
                        </h3>
                        <div class="flex items-center gap-1 mt-0.5">
                            <div class="w-1.5 h-1.5 rounded-full {{ $accentColor }} {{ $val <= 2 ? 'animate-pulse' : '' }}"></div>
                            <p class="text-[8px] font-bold {{ $textColor }} opacity-70 uppercase tracking-tighter">{{ $statusLabel }}</p>
                        </div>
                    </div>

                    <div class="flex items-end justify-between mt-5">
                        <div class="flex items-baseline gap-0.5">
                            {{-- QUANTITY IS STILL HERE --}}
                            <span class="text-3xl font-black {{ $textColor }} tracking-tighter">{{ $item->quantity }}</span>
                            <span class="text-[9px] font-bold {{ $textColor }} opacity-60 uppercase">{{ $item->unit ?? 'qty' }}</span>
                        </div>

                        @if($alreadyInList)
                            <button type="button" @click="itemName = '{{ $item->item_name }}'; showDuplicateModal = true" class="w-8 h-8 rounded-xl bg-stone-200 text-stone-400 flex items-center justify-center shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                            </button>
                        @else
                            <form action="/add-to-list/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="w-8 h-8 rounded-xl {{ $btnColor }} flex items-center justify-center hover:scale-110 active:scale-95 transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    {{-- DUPLICATE MODAL --}}
    <div x-show="showDuplicateModal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-sm" x-cloak x-transition>
        <div @click.away="showDuplicateModal = false" class="bg-white rounded-[2.5rem] p-8 max-w-[300px] w-full shadow-2xl text-center border border-stone-100">
            <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h2 class="text-lg font-black text-stone-800 uppercase tracking-tighter">Already Added!</h2>
            <p class="text-[10px] font-bold text-stone-400 uppercase tracking-widest mt-2 leading-relaxed"><span class="text-orange-600" x-text="itemName"></span> is already on the list.</p>
            <button @click="showDuplicateModal = false" class="mt-8 w-full py-4 bg-stone-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[0.2em]">Got it</button>
        </div>
    </div>
</div>
@endsection