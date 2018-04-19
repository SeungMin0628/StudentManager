<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyGroupsTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('groups', function(Blueprint $table) {
            $table->time('school_time')->default('09:00:00')->change();
            $table->time('home_time')->default('21:00:00')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('groups', function(Blueprint $table) {
            $table->time('school_time')->default('00:09:00')->change();
            $table->time('home_time')->default('00:21:00')->change();
        });
    }
}
