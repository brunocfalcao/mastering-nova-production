<?php

use App\Seeders\GenerateUserUUIDS;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableForNewsletters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('allows_emails')
                  ->comment('Can receive/allow emails')
                  ->after('password')
                  ->default(true);

            $table->uuid('uuid')
                  ->after('allows_emails')
                  ->nullable();
        });

        // Call initial seeder. Mandatory to initialize the schema correctly.
        Artisan::call('db:seed', [
            '--class' => GenerateUserUUIDS::class,
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
