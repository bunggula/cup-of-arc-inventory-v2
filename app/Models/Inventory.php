<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // Ito ay para payagan si Laravel na mag-save ng data sa mga columns na ito
    protected $fillable = ['item_name', 'category', 'quantity'];
}