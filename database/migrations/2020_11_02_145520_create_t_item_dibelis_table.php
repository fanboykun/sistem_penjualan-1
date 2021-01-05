<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTItemDibelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_item_dibeli', function (Blueprint $table) {
            $table->string('kd_dibeli',25)->primary();
            $table->string('fk_kd_user',25)->index();
            $table->string('fk_kd_produk',25)->index();
            $table->tinyInteger('jumlah');
            $table->integer('harga');
            $table->integer('total');
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
        Schema::dropIfExists('t_item_dibeli');
    }
}
