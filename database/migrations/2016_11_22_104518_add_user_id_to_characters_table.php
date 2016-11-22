<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToCharactersTable extends Migration
{
    public function up()
    {
        Schema::table('characters', function ($table) {
            $table->integer('user_id')->unsigned()->nullable();
        });
    }

    public function down()
    {
        Schema::table('characters', function ($table) {
            $table->dropColumn('user_id');
        });
    }
}
