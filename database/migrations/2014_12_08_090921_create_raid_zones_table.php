<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaidZonesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('raid_zones')) {
            Schema::create('raid_zones', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('raid_zones');
    }
}
