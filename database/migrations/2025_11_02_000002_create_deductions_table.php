<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration
{
    public function up()
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
            ])->nullable()->change();

            $table->decimal('amount', 12, 2);
            $table->text('note')->nullable();
            $table->date('date');
            // Add created_at and updated_at columns
            $table->timestamps();
            // Add deleted_at column for soft deletes
            $table->softDeletes();
            });
    }
    public function down() { Schema::dropIfExists('deductions'); }
}
