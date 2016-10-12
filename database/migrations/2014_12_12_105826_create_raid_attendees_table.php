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
				$table->integer('raid_id')->unsigned();
				$table->integer('character_id')->unsigned();
				$table->timestamps();
			});
		}
	}
	public function down()
	{
		Schema::dropIfExists('raid_attendees');
	}
}
