<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropModifiables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('modifiables');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('modifiables', function (Blueprint $table) {
            $table->unsignedBigInteger('modifier_id'); // unsigned for foreign key.
            $table->foreign('modifiables_id') // foreign key column name.
                ->references('id') // parent table primary key.
                ->on('modifiers');
            $table->unsignedBigInteger('modifiables_id'); // unsigned for foreign key.
            $table->string('modifiables_type');
        });
    }
}
