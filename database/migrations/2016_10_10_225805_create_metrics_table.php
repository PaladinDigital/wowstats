<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetricsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('metrics')) {
            Schema::create('metrics', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('metrics');
    }
}
