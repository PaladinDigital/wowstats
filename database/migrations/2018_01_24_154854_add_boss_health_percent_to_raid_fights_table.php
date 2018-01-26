<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBossHealthPercentToRaidFightsTable extends Migration
{
    public function up()
    {
        Schema::table('raid_fights', function ($table) {
            $table->float('boss_health', 4, 2)->default(0);
        });
    }

    public function down()
    {
        Schema::table('raid_fights', function ($table) {
            $table->dropColumn('boss_health');
        });
    }
}
