<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Ipakita ang Unified Dashboard (Audit Page)
    public function index()
    {
        $groups = Inventory::all()->groupBy('category');
        return view('dashboard', compact('groups'));
    }

    // Pag-save ng bagong item (Manage Side)
    public function store(Request $request)
    {
        // FIX: Dapat kunin ang 'quantity' galing sa $request
        Inventory::create([
            'item_name' => $request->item_name,
            'category'  => $request->category,
            'quantity'  => $request->quantity ?? 0, // Kukunin na yung input mo sa form
        ]);
    
        return redirect()->back()->with('success', 'Item Added!');
    }

    public function manage()
    {
        $items = Inventory::orderBy('category')->get();
        return view('inventory.manage', compact('items'));
    }

    public function destroy($id)
    {
        $item = Inventory::findOrFail($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully!');
    }

    // Pag-edit ng Item
    public function update(Request $request, $id) {
        $item = Inventory::findOrFail($id);
        // FIX: Siguraduhin na kasama ang quantity sa update
        $item->update([
            'item_name' => $request->item_name,
            'category'  => $request->category,
            'quantity'  => $request->quantity,
        ]);
        return back()->with('success', 'Item updated!');
    }

    // Pag-update ng Stocks (Audit Side)
    public function updateStock(Request $request)
    {
        if ($request->has('quantities')) {
            foreach ($request->quantities as $id => $qty) {
                $item = Inventory::find($id);
                if ($item) {
                    $item->quantity = $qty;
                    $item->save();
                }
            }
        }
        return redirect()->back()->with('success', 'Inventory updated!');
    }
    public function monitor()
{
    // Kukunin natin lahat ng items grouped by category
    $groups = Inventory::all()->groupBy('category');
    return view('inventory.monitor', compact('groups'));
}
public function shoppingList()
{
    // Kukunin lahat at i-group by date. 
    // Yung mga hindi pa nabibili, mapupunta sa group na "Pending"
    $shoppingItems = \App\Models\ShoppingList::with('inventory')
        ->orderBy('is_bought', 'asc') // Unahin ang hindi pa nabibili
        ->orderBy('updated_at', 'desc') // Pinaka-latest sa taas
        ->get()
        ->groupBy(function($item) {
            return $item->is_bought ? $item->date_bought : 'Pending';
        });

    return view('inventory.list', compact('shoppingItems'));
}

public function toggleBought($id)
{
    $item = \App\Models\ShoppingList::findOrFail($id);
    
    // Toggle status
    $item->is_bought = !$item->is_bought;
    
    // Kung na-checkan na (nabili), i-save ang date ngayon. 
    // Kung in-uncheck, burahin ang date.
    $item->date_bought = $item->is_bought ? now()->toDateString() : null;
    $item->save();

    return back();
}

public function addToList($id)
{
    // Check kung nandoon na sa listahan na 'pending' para hindi mag-duplicate
    $exists = \App\Models\ShoppingList::where('inventory_id', $id)
                ->where('is_bought', false)
                ->exists();
    
    if (!$exists) {
        \App\Models\ShoppingList::create([
            'inventory_id' => $id,
            'is_bought' => false
        ]);
    }

    return back()->with('success', 'Added to checklist!');
}
public function printShoppingList()
{
    // Kukunin lang natin ang mga 'Pending' (is_bought = false)
    $items = \App\Models\ShoppingList::where('is_bought', false)
                ->with('inventory')
                ->get();

    return view('inventory.print-list', compact('items'));
}
    public function removeFromList($id)
{
    // Hanapin ang item sa ShoppingList model
    $item = \App\Models\ShoppingList::findOrFail($id);
    
    // Burahin ang item
    $item->delete();

    // Bumalik sa dating page na may kasamang success message
    return back()->with('success', 'Item removed from archive.');
}
    public function updateStatus($id, $status)
{
    $item = \App\Models\Inventory::findOrFail($id);
    $item->quantity = $status;
    $item->save();

    return response()->json(['success' => true]);
}
}