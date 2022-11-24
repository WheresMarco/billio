<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEventDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('event_dates');

        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();
            $table->text('location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('event_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id'); // unsigned for foreign key.
            $table->foreign('event_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('events') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->dateTime('date_from');
            $table->dateTime('date_to');
            $table->text('location');
        });
    }
}
