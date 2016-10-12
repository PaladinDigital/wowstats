<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterItemLevelsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('character_item_levels')) {
            Schema::create('character_item_levels', function ($table) {
                $table->increments('id');
                $table->integer('character_id')->unsigned();
                $table->integer('item_level')->unsigned();
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('character_item_levels');
    }
}
