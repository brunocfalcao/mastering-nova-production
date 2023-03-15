<?php

use App\Seeders\UpdateVideosForStorageSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This migration file was created to add a new column to the
 * videos table to be able to store the video link to the Backblaze
 * storage cloud server. This way the users can later download the videos
 * from the server using website.
 */
class UpdateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->text('filename')
                  ->comment('Stores the Backblaze bucket video filename.')
                  ->after('vimeo_id')
                  ->nullable();
        });

        // Call initial seeder. Mandatory to initialize the schema correctly.
        Artisan::call('db:seed', [
            '--class' => UpdateVideosForStorageSeeder::class,
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
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('video_path');
        });
    }
}
