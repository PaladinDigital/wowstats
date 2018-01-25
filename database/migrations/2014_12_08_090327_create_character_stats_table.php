<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterStatsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('character_raid_stats')) {
            Schema::create('character_raid_stats', function ($table) {
                $table->increments('id');
                $table->integer('fight_id')->unsigned();
                $table->integer('character_id')->unsigned();
                $table->integer('metric_id')->unsigned();
                $table->float('value', 14, 2);
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('character_raid_stats');
    }
}
