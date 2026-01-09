<?php
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AuthController; // Siguraduhing tama ang tawag dito
use Illuminate\Support\Facades\Route;

// 1. LOGIN ROUTES (Public - Kahit sino pwedeng makita ito)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. PROTECTED ROUTES (Dapat naka-login ang apat na staff para mabuksan)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard / Main Monitor
    // Dashboard / Main Monitor
Route::get('/', [InventoryController::class, 'index'])->name('inventory.index'); // Ito ang 'Ending'
Route::get('/inventory/monitor', [InventoryController::class, 'monitor'])->name('inventory.monitor'); // Palitan ang 'index' ng 'monitor'

    // Shopping List & History
    Route::get('/inventory/list', [InventoryController::class, 'shoppingList'])->name('inventory.list');
    Route::post('/add-to-list/{id}', [InventoryController::class, 'addToList']);
    Route::post('/toggle-bought/{id}', [InventoryController::class, 'toggleBought']);
    Route::delete('/remove-from-list/{id}', [InventoryController::class, 'removeFromList']);

    // Management Page (Add/Edit/Delete ng Items)
    Route::get('/inventory/manage', [InventoryController::class, 'manage'])->name('inventory.manage');
    Route::post('/add-item', [InventoryController::class, 'store']);
    Route::put('/edit-item/{id}', [InventoryController::class, 'update']);
    Route::delete('/delete-item/{id}', [InventoryController::class, 'destroy']);
    Route::post('/update-inventory', [InventoryController::class, 'updateStock']);
    Route::get('/inventory/print-list', [InventoryController::class, 'printShoppingList'])->name('inventory.print');
});