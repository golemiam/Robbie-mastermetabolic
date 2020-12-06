<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNutritionProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritionProgram', function (Blueprint $table) {
            $table->increments('id');
            $table->string('date');
            $table->float('target_calories');
            $table->string('water_intake');
            $table->longText('meals');
            $table->longText('program_notes');
            $table->integer('session_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nutritionProgram');
    }
}
