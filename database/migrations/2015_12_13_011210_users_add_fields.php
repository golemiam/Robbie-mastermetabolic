<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone');
            $table->string('addr_line_1');
            $table->string('addr_line_2');
            $table->string('city');
            $table->string('state');
            $table->string('ec_name');
            $table->string('ec_phone');
            $table->string('ec_relationship');
            $table->longText('med_cond');
            $table->longText('exer_cond');
            $table->longText('food_cond');
            $table->longText('diet_cond');
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
            $table->dropColumns('phone');
            $table->dropColumns('addr_line_1');
            $table->dropColumns('addr_line_2');
            $table->dropColumns('city');
            $table->dropColumns('state');
            $table->dropColumns('ec_name');
            $table->dropColumns('ec_phone');
            $table->dropColumns('ec_relationship');
            $table->dropColumns('med_cond');
            $table->dropColumns('exer_cond');
            $table->dropColumns('food_cond');
            $table->dropColumns('diet_cond');
        });
    }
}
