<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAccessCodeFromTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_access_code_id_foreign');

            // Remove access_code_id column.
            $table->dropColumn('access_code_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add access_code_id column.
            $table->unsignedBigInteger('access_code_id'); // unsigned for foreign key.
            $table->foreign('access_code_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('access_codes') // parent table name.
                ->nullable()
                ->onDelete('cascade'); // this will delete all the children rows when the parent row is deleted.
        });
    }
}
