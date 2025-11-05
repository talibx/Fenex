<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthsTable extends Migration
{
    public function up()
    {
        Schema::create('months', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('number')->unique(); // 1–12
            $table->string('name_en'); // e.g. "January"
            $table->string('name_ar')->nullable(); // optional Arabic/localized name
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('months');
    }
};
