<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPaddleLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Apply changes in the paddle_log table in order to make it
         * easier to understand the financials regardings earnings, gross
         * amounts, etc.
         */
        Schema::table('paddle_log', function (Blueprint $table) {
            $table->decimal('fee', 15, 2)
                  ->after('sale_gross')
                  ->nullable();

            $table->decimal('payment_tax', 15, 2)
                  ->after('earnings')
                  ->nullable();

            $table->string('coupon')
                  ->after('fee')
                  ->nullable();
        });

        Schema::table('paddle_log', function (Blueprint $table) {
            $table->decimal('earnings', 15, 2)
                  ->nullable()
                  ->change();
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
