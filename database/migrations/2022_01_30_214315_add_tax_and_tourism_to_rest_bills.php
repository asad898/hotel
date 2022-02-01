<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxAndTourismToRestBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rest_bills', function (Blueprint $table) {
            $table->decimal('tax',9,3);
            $table->decimal('tourism',9,3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rest_bills', function (Blueprint $table) {
            $table->dropColumn('tax');
            $table->dropColumn('tourism');
        });
    }
}
