<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'shipping',
                'vat',
                'printing',
                'packaging',
                'domain_hosting',
                'license_fees',
                'bank_fees',
                'purchases',
                'returns',
                'refund',
                'tools_materials',
                'operation',
                'misc'
            ])->nullable();
            $table->decimal('amount', 12, 2);
            $table->text('details')->nullable();
            $table->date('date');
            $table->enum('hub', ['amazon.ae', 'amazon.sa', 'noon', 'local', 'other'])->default('amazon.ae');
            $table->json('photos')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
