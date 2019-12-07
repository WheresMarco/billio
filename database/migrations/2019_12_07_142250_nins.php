<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Nins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nin');
            $table->text('corps');
            $table->unsignedBigInteger('ticket_id'); // unsigned for foreign key.
            $table->foreign('ticket_id') // foreign key column name.
                ->nullable()
                ->references('id') // parent table primary key.
                ->on('tickets') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->boolean('utilized');
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
        //
    }
}
