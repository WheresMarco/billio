<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketModifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_modifiers', function (Blueprint $table) {
            $table->unsignedBigInteger('ticket_modifiers_id'); // unsigned for foreign key.
            $table->foreign('ticket_modifiers_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('tickets') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->unsignedBigInteger('modifier_id'); // unsigned for foreign key.
            $table->foreign('modifier_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('modifiers') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->string('ticket_modifiers_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_modifiers');
    }
}
