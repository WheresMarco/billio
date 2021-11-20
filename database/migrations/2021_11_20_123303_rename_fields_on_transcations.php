<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFieldsOnTranscations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rename fields on transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('stripe_source', 'stripe_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rename fields on transactions table
        Schema::table('transactions', function (Blueprint $table) {
            $table->renameColumn('stripe_id', 'stripe_source');
        });
    }
}
