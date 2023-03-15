<?php

use App\Seeders\GiveAway1;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AlterWebsiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website', function (Blueprint $table) {
            $table->dateTime('giveaway_starts_at')
                  ->after('title')
                  ->comment('In UTC timezone (server configured by default)')
                  ->nullable();

            $table->dateTime('giveaway_ends_at')
                  ->after('giveaway_starts_at')
                  ->comment('In UTC timezone (server configured by default)')
                  ->nullable();
        });

        // Call initial seeder. Mandatory to initialize the schema correctly.
        Artisan::call('db:seed', [
            '--class' => GiveAway1::class,
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
