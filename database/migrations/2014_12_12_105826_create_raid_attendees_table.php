<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaidAttendeesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('raid_attendees')) {
			Schema::create('raid_attendees', function ($table) {
				$table->increments('id');
				$table->integer('raid_id');
				$table->integer('character_id');
				$table->timestamps();
			});
		}
	}
	public function down()
	{
		Schema::dropIfExists('raid_bosses');
	}
}
