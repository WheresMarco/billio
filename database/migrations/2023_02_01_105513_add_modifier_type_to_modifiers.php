<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModifierTypeToModifiers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modifiers', function (Blueprint $table) {
            $table->string('modifier_type')->default('modifier');
            $table->dropColumn('hidden');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modifiers', function (Blueprint $table) {
            $table->dropColumn('modifier_type');
            $table->boolean('hidden')->default(false);
        });
    }
}
