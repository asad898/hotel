<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoomIdAndBillIdToReBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('re_bills', function (Blueprint $table) {
            $table->foreignId('room_id');
            $table->foreignId('bill_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('re_bills', function (Blueprint $table) {
            $table->dropColumn('room_id');
            $table->dropColumn('bill_id');
        });
    }
}
