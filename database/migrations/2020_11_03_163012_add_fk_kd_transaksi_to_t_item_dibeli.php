<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkKdTransaksiToTItemDibeli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_item_dibeli', function (Blueprint $table) {
            $table->string('fk_kd_transaksi',25)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_item_dibeli', function (Blueprint $table) {
            $table->dropColumn('fk_kd_transaksi');
        });
    }
}
