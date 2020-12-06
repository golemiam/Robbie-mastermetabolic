<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSessionMeasurements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('training_sessions', function (Blueprint $table) {
            $table->string('neck');
            $table->string('arm');
            $table->string('chest');
            $table->string('hips');
            $table->string('calf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('training_sessions', function (Blueprint $table) {
            $table->dropColumns('neck');
            $table->dropColumns('arm');
            $table->dropColumns('chest');
            $table->dropColumns('hips');
            $table->dropColumns('calf');
        });
    }
}
