<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaDetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('la_detas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clothe_id');
            $table->foreignId('la_bill_id');
            $table->double('tax', 20, 2);
            $table->integer('amount');
            $table->double('price', 20, 2);
            $table->foreignId('user_id');
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
        Schema::dropIfExists('la_detas');
    }
}
