<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_bills', function (Blueprint $table) {
            $table->id();
            $table->double('total', 20, 2);
            $table->double('stamp', 20, 2);
            $table->double('tax', 20, 2);
            $table->boolean('done');
            $table->foreignId('user_id');
            $table->foreignId('room_id');
            $table->foreignId('bill_id');
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
        Schema::dropIfExists('la_bills');
    }
}
