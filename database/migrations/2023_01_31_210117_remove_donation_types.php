<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDonationTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove donation types relation from donations
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['donation_type_id']);
            $table->dropColumn('donation_type_id');
        });

        Schema::dropIfExists('donation_types');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('donation_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('amount')->nullable();
            $table->integer('sorting_order')->nullable();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events');
        });

        // Add donation types relation to donations
        Schema::table('donations', function (Blueprint $table) {
            $table->unsignedBigInteger('donation_type_id')->nullable();
            $table->foreign('donation_type_id')->references('id')->on('donation_types');
        });
    }
}
