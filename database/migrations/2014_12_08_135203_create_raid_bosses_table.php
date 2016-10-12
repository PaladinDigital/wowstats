<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaidBossesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('raid_bosses')) {
            Schema::create('raid_bosses', function ($table) {
                $table->increments('id');
                $table->integer('raidzone_id')->unsigned();
                $table->string('name');
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('raid_bosses');
    }
}
