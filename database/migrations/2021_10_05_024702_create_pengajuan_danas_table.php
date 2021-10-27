<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanDanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_danas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('divisi_id')->nullable();
            $table->unsignedBigInteger('paket_id')->nullable();
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
        Schema::dropIfExists('pengajuan_danas');
    }
}
