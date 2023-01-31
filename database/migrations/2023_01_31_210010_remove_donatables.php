<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDonatables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('donatables');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('donatables', function (Blueprint $table) {
            $table->id();
            $table->string('donatable_type');
            $table->unsignedBigInteger('donatable_id');
            $table->unsignedBigInteger('donation_id');
            $table->timestamps();
        });
    }
}
