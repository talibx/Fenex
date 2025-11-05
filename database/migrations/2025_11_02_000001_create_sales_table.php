<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up(){
    
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('year_id')->constrained('years')->onDelete('cascade');
            $table->foreignId('month_id')->constrained('months')->onDelete('cascade');

            $table->enum('hub', ['amazon.ae', 'amazon.sa', 'noon','local', 'other'])->default('Amazon.ae');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('file_path')->nullable();

            $table->integer('order_sold')->default(0);
            $table->integer('order_returned')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->decimal('total_profit', 12, 2)->default(0);
            $table->text('notes')->nullable();

            // Add created_at and updated_at columns
            $table->timestamps();

            // Add deleted_at column for soft deletes
            $table->softDeletes();

            });
}

    public function down() { Schema::dropIfExists('sales_monthly'); }
}