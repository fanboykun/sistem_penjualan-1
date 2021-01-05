<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_transaksi', function (Blueprint $table) {
            $table->string('kd_transaksi',25)->primary();
            $table->string('fk_kd_user',25)->index();
            $table->string('status',1)->default(0);
            $table->string('img_bukti',100)->nullable();
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
        Schema::dropIfExists('t_transaksi');
    }
}
