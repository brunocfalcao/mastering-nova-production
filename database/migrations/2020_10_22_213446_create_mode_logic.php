<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeLogic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Add the mode to the paddle_log and to the users table.
         */
        Schema::table('paddle_log', function (Blueprint $table) {
            $table->string('mode')
                  ->after('receipt_url')
                  ->default('full');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('mode')
                  ->after('invoice_link')
                  ->default('full');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mode_logic');
    }
}
