<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGiveawayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('giveaway', function (Blueprint $table) {
            $table->string('contest_number')
                  ->after('email')
                  ->nullable();
        });

        Schema::table('giveaway', function (Blueprint $table) {
            $table->boolean('won')
                  ->after('contest_number')
                  ->default(false);
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
