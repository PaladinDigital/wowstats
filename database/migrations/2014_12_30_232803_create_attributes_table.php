<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('attributes')) {
            Schema::create('attributes', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
        }
    }
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
}
