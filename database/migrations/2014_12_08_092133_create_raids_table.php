<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaidsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('raids')) {
            Schema::create('raids', function ($table) {
                $table->increments('id');
                $table->date('date');
                $table->integer('raidzone_id')->unsigned();
                $table->boolean('locked')->default(0);
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('raids');
    }
}
