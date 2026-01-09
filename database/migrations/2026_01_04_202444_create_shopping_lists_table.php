<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shopping_lists', function (Blueprint $table) {
            $table->id();
            
            // Ito ang nagkakabit sa Inventory item (e.g. Oat Milk)
            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            
            // Status: 0 kung bibilhin pa lang, 1 kung nabili na
            $table->boolean('is_bought')->default(false);
            
            // Dito natin ise-save ang DATE kung kailan clinick ang "Nabili na"
            // Ito ang gagamitin natin para sa "History per Date" record
            $table->date('date_bought')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_lists');
    }
};
