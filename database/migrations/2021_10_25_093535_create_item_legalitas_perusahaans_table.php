<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemLegalitasPerusahaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_legalitas_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('legalitas_perusahaan_id')->nullable();
            $table->string('image_name');
            $table->string('image_path');
            $table->timestamp('tanggal');
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
        Schema::dropIfExists('item_legalitas_perusahaans');
    }
}
