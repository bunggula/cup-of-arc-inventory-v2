@extends('layouts.app')
@section('header_title', 'Ending')
@section('content')
<div class="max-w-2xl mx-auto pb-32">
    
    <div class="mb-8 px-4 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-black text-stone-800 uppercase tracking-tighter">Inventory <span class="text-orange-600">Audit</span></h1>
            <p class="text-xs font-bold text-stone-400 uppercase tracking-widest mt-1">Update current stock levels</p>
        </div>

        <div class="text-right">
            <p class="text-[8px] font-black text-stone-400 uppercase tracking-widest">Last Sync</p>
            <span class="text-[10px] font-bold text-stone-800">
                @php 
                    $latestItem = \App\Models\Inventory::latest('updated_at')->first();
                @endphp
                {{ $latestItem ? \Carbon\Carbon::parse($latestItem->updated_at)->timezone('Asia/Manila')->format('h:i A') : 'No Data' }}
            </span>
        </div>
    </div>

    <form action="/update-inventory" method="POST">
        @csrf
        @foreach($groups as $category => $items)
            <div class="mt-10 mb-4 flex items-center gap-3 px-4">
                <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-600">{{ $category }}</h2>
                <div class="h-px flex-1 bg-stone-200/50"></div>
            </div>

            <div class="grid gap-4 px-2">
                @foreach($items as $item)
                <div x-data="{ qty: {{ (int)$item->quantity }} }" 
                     class="bg-white p-5 rounded-[2.5rem] shadow-sm border border-stone-100 hover:border-orange-200 transition-all">
                    
                    {{-- TOP SECTION: NAME AND QUANTITY COUNTER --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="pl-3">
                            <h3 class="font-bold text-stone-800 text-sm leading-tight uppercase tracking-tight">{{ $item->item_name }}</h3>
                            <div class="flex items-center gap-2 mt-1">
                                <p class="text-[9px] font-bold text-stone-400 uppercase tracking-wider">{{ $item->unit ?? 'pcs' }}</p>
                                <span class="text-[9px] text-stone-300 italic">{{ $item->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 bg-stone-50 p-1.5 rounded-full border border-stone-100">
                            <button type="button" 
                                    @click="if(qty > 0) qty--" 
                                    class="w-9 h-9 rounded-full bg-white shadow-sm flex items-center justify-center text-stone-600 font-black hover:bg-red-50 hover:text-red-600 active:scale-90 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" /></svg>
                            </button>

                            <input type="hidden" name="quantities[{{ $item->id }}]" :value="qty">
                            <span x-text="qty" class="w-8 text-center font-black text-sm text-stone-900"></span>

                            <button type="button" 
                                    @click="qty++" 
                                    class="w-9 h-9 rounded-full bg-stone-900 text-white shadow-lg flex items-center justify-center hover:bg-orange-600 active:scale-90 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                            </button>
                        </div>
                    </div>

                    {{-- BOTTOM SECTION: MANUAL STATUS BUTTONS (INSTANT UPDATE) --}}
                    <div class="grid grid-cols-3 gap-2 pt-1">
                        <button type="button" 
                                onclick="updateInstantStatus({{ $item->id }}, 1)"
                                class="py-2.5 rounded-2xl border text-[8px] font-black uppercase transition-all {{ $item->quantity <= 1 ? 'bg-red-500 text-white border-red-500 shadow-md shadow-red-100' : 'bg-white text-red-400 border-red-100 hover:bg-red-50' }}">
                            Out of Stock
                        </button>
                        <button type="button" 
                                onclick="updateInstantStatus({{ $item->id }}, 2)"
                                class="py-2.5 rounded-2xl border text-[8px] font-black uppercase transition-all {{ $item->quantity == 2 ? 'bg-orange-500 text-white border-orange-500 shadow-md shadow-orange-100' : 'bg-white text-orange-400 border-orange-100 hover:bg-orange-50' }}">
                            Running Low
                        </button>
                        <button type="button" 
                                onclick="updateInstantStatus({{ $item->id }}, 3)"
                                class="py-2.5 rounded-2xl border text-[8px] font-black uppercase transition-all {{ $item->quantity >= 3 ? 'bg-green-600 text-white border-green-600 shadow-md shadow-green-100' : 'bg-white text-green-400 border-green-100 hover:bg-green-50' }}">
                            Good Stock
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach

        <div class="fixed bottom-28 left-0 right-0 px-6 md:static md:px-2 md:mt-12 flex justify-center">
            <button type="submit" class="w-full max-w-md bg-stone-900 text-white py-5 rounded-[2.5rem] font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl shadow-stone-900/40 hover:bg-orange-600 transition-all flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Bulk Save All Changes
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT PARA SA INSTANT STATUS UPDATE --}}
<script>
function updateInstantStatus(id, statusValue) {
    // Optional: Maglagay ng loading state sa button
    fetch(`/update-stock-status/${id}/${statusValue}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.ok) {
            // I-refresh ang page para mag-update ang colors at "Last Sync"
            window.location.reload();
        } else {
            alert('Error updating status. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
@endsection