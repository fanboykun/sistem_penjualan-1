<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_produk', function (Blueprint $table) {
            $table->string('kd_produk',25)->primary();
            $table->string('fk_kd_kategori',25)->index();
            $table->string('fk_kd_admin',25)->index();
            $table->string('nama',100);
            $table->mediumText('deskripsi')->nullable();
            $table->string('img_1',100);
            $table->string('img_2',100)->nullable();
            $table->string('img_3',100)->nullable();
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
        Schema::dropIfExists('m_produk');
    }
}
