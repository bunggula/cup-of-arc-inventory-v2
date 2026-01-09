@extends('layouts.app')
@section('header_title', 'Inventory')
@section('content')
<div class="max-w-4xl mx-auto pb-20 px-4" 
     x-data="{ 
        openDelete: false, 
        openEdit: false,
        deleteId: null, 
        deleteName: '',
        editItem: { id: null, item_name: '', category: '', quantity: 0 },
        categoryType: 'select'
     }">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-stone-800 uppercase tracking-tighter">Stock <span class="text-orange-600">Masterlist</span></h1>
            <p class="text-xs font-bold text-stone-400 uppercase tracking-widest">Register and manage product quantities</p>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2.5rem] border border-stone-100 shadow-xl shadow-stone-200/50 mb-12">
        <form action="/add-item" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            @csrf
            <div class="md:col-span-1">
                <label class="text-[10px] font-black uppercase text-stone-400 ml-2 mb-1 block">Category</label>
                
                <template x-if="categoryType === 'select'">
                    <select name="category" 
                            @change="if($event.target.value === 'Others') categoryType = 'manual'"
                            class="w-full bg-stone-50 border-none rounded-2xl p-4 text-sm font-bold outline-none ring-1 ring-stone-100 focus:ring-orange-500/20">
                        <option value="Coffee">Coffee</option>
                        <option value="Dairy">Dairy</option>
                        <option value="Packaging">Packaging</option>
                        <option value="Syrups">Syrups</option>
                        <option value="Others">Others (Type Manual)</option>
                    </select>
                </template>

                <template x-if="categoryType === 'manual'">
                    <div class="relative">
                        <input type="text" name="category" placeholder="Type Category..." 
                               class="w-full bg-stone-50 border-none rounded-2xl p-4 text-sm font-bold outline-none ring-1 ring-orange-500/50">
                        <button type="button" @click="categoryType = 'select'" class="absolute right-3 top-4 text-[9px] font-black text-orange-600 uppercase">Back</button>
                    </div>
                </template>
            </div>

            <div class="md:col-span-1">
                <label class="text-[10px] font-black uppercase text-stone-400 ml-2 mb-1 block">Item Name</label>
                <input type="text" name="item_name" placeholder="e.g. Oat Milk" class="w-full bg-stone-50 border-none rounded-2xl p-4 text-sm font-bold outline-none ring-1 ring-stone-100 focus:ring-orange-500/20" required>
            </div>

            <div class="md:col-span-1">
                <label class="text-[10px] font-black uppercase text-stone-400 ml-2 mb-1 block">Initial Quantity</label>
                <input type="number" name="quantity" placeholder="0" min="0" class="w-full bg-stone-50 border-none rounded-2xl p-4 text-sm font-bold outline-none ring-1 ring-stone-100 focus:ring-orange-500/20" required>
            </div>

            <button type="submit" class="bg-stone-900 text-white p-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg">
                Save Product
            </button>
        </form>
    </div>

    @foreach($items->groupBy('category') as $category => $groupItems)
    <div class="mb-12">
        <div class="flex items-center gap-3 mb-4 px-4">
            <h2 class="text-xs font-black uppercase tracking-widest text-orange-600">{{ $category }}</h2>
            <div class="h-px flex-1 bg-stone-200/50"></div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-stone-100 shadow-sm overflow-hidden mb-4">
            <table class="w-full text-left border-collapse">
                <thead class="bg-stone-50 border-b border-stone-100">
                    <tr>
                        <th class="p-6 text-[10px] font-black uppercase text-stone-400">Item Name</th>
                        <th class="p-6 text-[10px] font-black uppercase text-stone-400 text-center">Current Stock</th>
                        <th class="p-6 text-[10px] font-black uppercase text-stone-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-50">
                    @foreach($groupItems as $item)
                    <tr class="hover:bg-orange-50/30 transition-all">
                        <td class="p-6 text-sm font-bold text-stone-800">{{ $item->item_name }}</td>
                        <td class="p-6 text-sm font-black text-stone-900 text-center">{{ $item->quantity }}</td>
                        <td class="p-6 text-right">
                            <div class="flex justify-end gap-2">
                                <button @click="openEdit = true; editItem = { id: {{ $item->id }}, item_name: '{{ $item->item_name }}', category: '{{ $item->category }}', quantity: {{ $item->quantity }} }" 
                                        class="w-8 h-8 rounded-full bg-stone-50 text-stone-400 flex items-center justify-center hover:bg-orange-100 hover:text-orange-600 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </button>
                                <button @click="openDelete = true; deleteId = {{ $item->id }}; deleteName = '{{ $item->item_name }}'" 
                                        class="w-8 h-8 rounded-full bg-stone-50 text-stone-400 flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-stone-50/50 border border-dashed border-stone-200 rounded-[2rem]">
            <form action="/add-item" method="POST" class="flex flex-wrap md:flex-nowrap gap-3 items-center">
                @csrf
                <input type="hidden" name="category" value="{{ $category }}">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="item_name" placeholder="Quick add to {{ $category }}..." class="w-full bg-white border-none rounded-xl px-4 py-2 text-xs font-bold outline-none ring-1 ring-stone-200" required>
                </div>
                <div class="w-24">
                    <input type="number" name="quantity" placeholder="Qty" min="0" class="w-full bg-white border-none rounded-xl px-4 py-2 text-xs font-bold outline-none ring-1 ring-stone-200" required>
                </div>
                <button type="submit" class="bg-stone-900 text-white px-4 py-2 rounded-xl font-black text-[9px] uppercase tracking-widest hover:bg-orange-600 transition-all">
                    + Add
                </button>
            </form>
        </div>
    </div>
    @endforeach

    <div x-show="openDelete" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-sm" x-cloak x-transition>
        <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-8">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h3 class="text-center font-black text-stone-800 text-lg uppercase tracking-tighter">Remove Item?</h3>
            <p class="text-center text-stone-400 text-sm mt-2">Deleting <span class="text-stone-900 font-bold" x-text="deleteName"></span> cannot be undone.</p>
            <div class="grid grid-cols-2 gap-3 mt-8">
                <button @click="openDelete = false" class="bg-stone-100 text-stone-600 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest">Cancel</button>
                <form :action="'/delete-item/' + deleteId" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest shadow-lg">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <div x-show="openEdit" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-stone-900/60 backdrop-blur-sm" x-cloak x-transition>
        <div class="bg-white w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">
            <h3 class="font-black text-stone-800 text-xl uppercase tracking-tighter mb-6">Edit Stock</h3>
            <form :action="'/edit-item/' + editItem.id" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="text-[10px] font-black uppercase text-stone-400 ml-2 mb-1 block">Category</label>
                    <input type="text" name="category" x-model="editItem.category" class="w-full bg-stone-50 border-none rounded-2xl p-4 text-sm font-bold outline-none ring-1 ring-stone-100 focus:ring-orange-500/20">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-stone-400 ml-2 mb-1 block">Item Name</label>
                    <input type="text" name="item_name" x-model="editItem.item_name" class="w-full bg-stone-50 border-none rounded-2xl p-4 text-sm font-bold outline-none ring-1 ring-stone-100 focus:ring-orange-500/20">
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase text-stone-400 ml-2 mb-1 block">Update Quantity</label>
                    <input type="number" name="quantity" x-model="editItem.quantity" min="0" class="w-full bg-stone-50 border-none rounded-2xl p-4 text-sm font-bold outline-none ring-1 ring-stone-100 focus:ring-orange-500/20">
                </div>
                <div class="grid grid-cols-2 gap-3 mt-8 pt-4">
                    <button type="button" @click="openEdit = false" class="bg-stone-100 text-stone-600 py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest">Cancel</button>
                    <button type="submit" class="bg-orange-600 text-white py-4 rounded-2xl font-bold text-[10px] uppercase tracking-widest shadow-lg">Update Stock</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection