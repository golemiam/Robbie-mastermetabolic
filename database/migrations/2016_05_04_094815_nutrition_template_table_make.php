<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NutritionTemplateTableMake extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nutritionTemplate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('program_notes');
            $table->longText('mealtemplate');
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
        Schema::drop('nutritionTemplate');
    }
}
