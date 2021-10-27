<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsSubCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_sub_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_code_id')->nullable();
            $table->unsignedBigInteger('paket_code_id')->nullable();
            $table->string('code');
            $table->string('nama');
            $table->boolean('has_child')->default(false);
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
        Schema::dropIfExists('ms_sub_codes');
    }
}
