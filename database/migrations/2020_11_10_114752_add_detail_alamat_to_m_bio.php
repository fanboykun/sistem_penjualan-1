<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailAlamatToMBio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_bio', function (Blueprint $table) {
            $table->string('kelamin',7)->nullable();
            $table->string('rtrw',8)->nullable();
            $table->string('kelurahan',30)->nullable();
            $table->string('kecamatan',30)->nullable();
            $table->string('lainya',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_bio', function (Blueprint $table) {
            //
        });
    }
}
