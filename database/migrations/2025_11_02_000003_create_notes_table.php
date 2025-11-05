<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('note');
            $table->string('tags')->nullable(); // comma-separated or json if you prefer
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            // Add created_at and updated_at columns
            $table->timestamps();
            // Add deleted_at column for soft deletes
            $table->softDeletes();
            });
    }
    public function down() { Schema::dropIfExists('notes'); }
}
