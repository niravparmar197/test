<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToEventMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_masters', function (Blueprint $table) {
            $table->string("venue")->after("event_name");
            $table->string("description")->after("venue");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_masters', function (Blueprint $table) {
            $table->dropColumn("venue");
            $table->dropColumn("description");
        });
    }
}
