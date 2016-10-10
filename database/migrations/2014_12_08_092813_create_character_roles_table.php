<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterRolesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('character_roles')) {
            Schema::create('character_roles', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('character_roles');
    }
}
