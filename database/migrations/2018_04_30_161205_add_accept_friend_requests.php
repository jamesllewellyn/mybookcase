<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAcceptFriendRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->boolean('accepted')->after('friend_id')->nullable();
            $table->boolean('declined')->after('accepted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('friend_requests', function (Blueprint $table) {
            $table->dropColumn('accepted');
            $table->dropColumn('declined');
        });
    }
}
