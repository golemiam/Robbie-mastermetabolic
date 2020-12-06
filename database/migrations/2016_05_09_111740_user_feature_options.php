<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserFeatureOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_dashboard')->default(1);
            $table->boolean('has_nutrition')->default(1);
            $table->boolean('has_exercise')->default(1);
            $table->boolean('can_edit')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_dashboard');
            $table->dropColumn('has_nutrition');
            $table->dropColumn('has_exercise');
            $table->dropColumn('can_edit');
        });
    }
}
