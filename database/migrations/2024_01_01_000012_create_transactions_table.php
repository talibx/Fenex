<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('source', [
                'amazon.ae',
                'amazon.sa',
                'noon',
                'local_sales',
                'local_purchase',
                'china_purchase',
                'profit_withdrawal',
                'other'
            ])->default('amazon.ae');
            $table->enum('type', ['credit', 'debit']);
            $table->text('details')->nullable();
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
