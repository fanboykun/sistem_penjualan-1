<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRjoIdToMBio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_bio', function (Blueprint $table) {
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->string('provinsi',35)->nullable();
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
            $table->dropColumn('city_id');
            $table->dropColumn('province_id');
        });
    }
}
