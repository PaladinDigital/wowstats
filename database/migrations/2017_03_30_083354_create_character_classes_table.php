<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterClassesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('character_classes')) {
            Schema::create('character_classes', function ($table) {
                $table->increments('uuid');
                $table->integer('id')->unsigned();
                $table->string('class_name'); // Hunter
                $table->string('css_name'); // .hunter
                $table->string('color_hex'); // #ABD473
                $table->integer('rgb_r')->unsigned(); // 171
                $table->integer('rgb_g')->unsigned(); // 212
                $table->integer('rgb_b')->unsigned(); // 115
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('character_classes');
    }
}
