<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLogsUrlToRaidFightsTable extends Migration
{
    public function up()
    {
        Schema::table('raid_fights', function ($table) {
            $table->string('logs_url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('raid_fights', function ($table) {
            $table->dropColumn('logs_url');
        });
    }
}
