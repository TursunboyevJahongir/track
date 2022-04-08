<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleColumnToRolesTable extends Migration
{
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->jsonb('title');
        });
    }

    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}
