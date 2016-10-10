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
                $table->integer('fight_id');
                $table->integer('character_id');
                $table->integer('metric_id');
                $table->integer('value');
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('character_raid_stats');
    }
}
