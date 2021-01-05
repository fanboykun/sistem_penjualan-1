<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToTCart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_cart', function (Blueprint $table) {
            $table->foreign('fk_kd_user')->references('kd_user')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fk_kd_produk')->references('kd_produk')->on('m_produk')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_cart', function (Blueprint $table) {
            //
        });
    }
}
