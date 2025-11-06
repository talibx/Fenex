<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('year_id')->constrained('years')->cascadeOnDelete();
            $table->foreignId('month_id')->constrained('months')->cascadeOnDelete();
            $table->enum('hub', ['amazon.ae', 'amazon.sa', 'noon', 'local', 'other'])->default('amazon.ae');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('file_path')->nullable();
            $table->integer('order_sold')->default(0);
            $table->integer('order_returned')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0.00);
            $table->decimal('total_cost', 12, 2)->default(0.00);
            $table->decimal('total_profit', 12, 2)->default(0.00);
            $table->text('details')->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
