<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('create_user_id')->unsigned();
            $table->string('ticket_number');
            $table->string('name');
            $table->string('mobile_number');
            $table->string('email');
            $table->integer('event_id')->unsigned();
            $table->string('guest_type');
            $table->datetime('from_time');
            $table->datetime('to_time');
            $table->double('rating');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guest_masters');
    }
}
