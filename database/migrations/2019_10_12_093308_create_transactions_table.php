<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ticket_id'); // unsigned for foreign key.
            $table->foreign('ticket_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('tickets') // parent table name.
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->unsignedBigInteger('user_id'); // unsigned for foreign key.
            $table->foreign('user_id') // foreign key column name.
                    ->references('id') // parent table primary key.
                    ->on('users') // parent table name.
                    ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
            $table->float('amount');
            $table->unsignedBigInteger('access_code_id'); // unsigned for foreign key.
            $table->foreign('access_code_id') // foreign key column name.
                    ->references('id') // parent table primary key.
                    ->on('access_codes') // parent table name.
                    ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
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
        Schema::dropIfExists('transactions');
    }
}
