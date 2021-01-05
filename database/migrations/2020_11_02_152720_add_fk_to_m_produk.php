<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToMProduk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_produk', function (Blueprint $table) {
            $table->foreign('fk_kd_admin')->references('kd_admin')->on('admin')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('fk_kd_kategori')->references('kd_kategori')->on('m_kategori')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_produk', function (Blueprint $table) {
            //
        });
    }
}
