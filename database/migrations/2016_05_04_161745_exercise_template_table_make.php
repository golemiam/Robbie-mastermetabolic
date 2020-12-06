<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExerciseTemplateTableMake extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exerciseTemplate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('program_notes');
            $table->longText('circuittemplate');
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
        Schema::drop('exerciseTemplate');
    }
}
