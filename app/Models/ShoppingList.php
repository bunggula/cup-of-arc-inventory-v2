<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    use HasFactory;

    // Payagan natin ang pag-save sa mga columns na ito
    protected $fillable = [
        'inventory_id', 
        'is_bought', 
        'date_bought'
    ];

    // Sabihin natin na itong shopping item ay "nagmamay-ari" ng isang inventory item
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}