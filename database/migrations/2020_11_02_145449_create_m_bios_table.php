<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMBiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_bio', function (Blueprint $table) {
            $table->string('fk_kd_user',25)->primary();
            $table->mediumText('alamat');
            $table->string('email',100)->nullable();
            $table->string('no_hp1',15);
            $table->string('no_hp2',15)->nullable();
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
        Schema::dropIfExists('m_bio');
    }
}
