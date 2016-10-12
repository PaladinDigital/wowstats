<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharactersTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('characters')) {
            Schema::create('characters', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->integer('class_id')->unsigned();
                $table->integer('rank')->unsigned()->nullable();
                $table->integer('main_role_id')->unsigned()->nullable(); // Main Spec
                $table->integer('os_role_id')->unsigned()->nullable(); // Off-Spec
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('characters');
    }
}
