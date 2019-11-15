<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuestRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_remarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("created_by")->unsigned();
            $table->integer("guest_master_id")->unsigned();
            $table->string("remarks",1000);
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
        Schema::dropIfExists('guest_remarks');
    }
}
