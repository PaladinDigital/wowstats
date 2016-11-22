<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminColumnToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->boolean('admin')->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('admin');
        });
    }
}
