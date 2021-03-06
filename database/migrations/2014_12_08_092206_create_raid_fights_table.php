<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaidFightsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('raid_fights')) {
            Schema::create('raid_fights', function ($table) {
                $table->increments('id');
                $table->integer('raid_id')->unsigned();
                $table->integer('boss_id')->unsigned();
                $table->boolean('killed');
                $table->integer('locked')->default(0);
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('raid_fights');
    }
}
