<?php

use App\Seeders\AffiliateLaravelio;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliates', function (Blueprint $table) {
            $table->id();

            $table->string('domain')
                  ->comment('Base domain without https://www.*. E.g. laravel.io, laravelnews.com, etc');

            $table->unsignedInteger('paddle_vendor_id')
                  ->comment('Paddle vendor id');

            $table->unsignedInteger('commission')
                  ->comment('Commission percentage, integer. E.g. 35 means 35%.');

            $table->timestamps();
        });

        // Call initial seeder. Mandatory to initialize the schema correctly.
        Artisan::call('db:seed', [
            '--class' => AffiliateLaravelio::class,
            '--force' => true
        ]);
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
