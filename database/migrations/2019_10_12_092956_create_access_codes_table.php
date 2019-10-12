<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id'); // unsigned for foreign key.
            $table->foreign('event_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('events') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->unsignedBigInteger('ticket_type_id'); // unsigned for foreign key.
            $table->foreign('ticket_type_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('ticket_types') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->text('code');
            $table->bigInteger('limit');
            $table->dateTime('valid_from');
            $table->dateTime('valid_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_codes');
    }
}
