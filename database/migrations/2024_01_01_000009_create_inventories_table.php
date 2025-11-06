<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->enum('condition', [
                'new',
                'used in good condition',
                'damaged product',
                'damaged bag',
                'without bag',
                'replaced'
            ]);
            $table->enum('inventory_actions', ['add to inventory', 'ship to amazon']);
            $table->string('details', 400)->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
