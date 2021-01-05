<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKurirToTTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_transaksi', function (Blueprint $table) {
            $table->string('kurir',35)->nullable();
            $table->integer('biaya_kirim')->nullable();
            $table->string('estimasi',6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_transaksi', function (Blueprint $table) {
            $table->dropColumn('kurir',35);
            $table->dropColumn('biaya_kirim');
            $table->dropColumn('estimasi',6);
        });
    }
}
