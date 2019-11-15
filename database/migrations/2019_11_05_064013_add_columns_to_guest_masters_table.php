<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToGuestMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guest_masters', function (Blueprint $table) {
            $table->integer("assigned_user_id")->unsigned()->nullable();
            $table->integer("product_rating")->unsigned()->nullable();
            $table->integer("agent_rating")->unsigned()->nullable();
            $table->boolean("fb_like")->nullable();
            $table->boolean("linkedin_like")->nullable();
            $table->boolean("twitter_like")->nullable();
            $table->boolean("insta_like")->nullable();
            $table->boolean("mobile_subscribe")->nullable();
            $table->boolean("email_subscribe")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guest_masters', function (Blueprint $table) {
            $table->dropColumn('assigned_user_id');
            $table->dropColumn('product_rating');
            $table->dropColumn('agent_rating');
            $table->dropColumn('fb_like');
            $table->dropColumn('linkedin_like');
            $table->dropColumn('twitter_like');
            $table->dropColumn('insta_like');
            $table->dropColumn('mobile_subscribe');
            $table->dropColumn('email_subscribe');
        });
    }
}
