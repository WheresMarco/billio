<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id'); // unsigned for foreign key.
            $table->foreign('event_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('events') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->text('name');
            $table->longText('description');
            $table->float('price');
            $table->boolean('active');
            $table->bigInteger('limit');
            $table->bigInteger('limit_person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_types');
    }
}
