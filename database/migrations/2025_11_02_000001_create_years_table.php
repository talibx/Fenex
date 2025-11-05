<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->id();
            $table->integer('year')->unique(); // e.g., 2022, 2023, ...
            $table->boolean('active')->default(true); // you can deactivate old years
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('years');
    }
};
