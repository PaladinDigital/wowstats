<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterAttributesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('character_attributes')) {
            Schema::create('character_attributes', function ($table) {
                $table->increments('id');
                $table->integer('character_id')->unsigned();
                $table->integer('attribute_id')->unsigned();
                $table->integer('value');
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('character_attributes');
    }
}
