<?php

use App\Chapter;
use App\Seeders\InitialSeeder;
use App\Video;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class CreateMasteringNovaSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website', function (Blueprint $table) {
            $table->id();

            $table->string('title')
                  ->comment('The default website <title>.');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->longtext('properties')
                  ->comment('Stores last ip, last seen video timestamp, etc.')
                  ->after('remember_token')
                  ->nullable();

            $table->timestamp('last_login_at')
                  ->nullable()
                  ->after('remember_token');

            $table->string('invoice_link')
                  ->nullable()
                  ->after('email');

            $table->string('password')
                  ->nullable()
                  ->change();

            $table->string('name')
                  ->nullable()
                  ->change();
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->decimal('ppp_index', 10, 2)
                  ->nullable();
        });

        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();

            $table->string('email');

            $table->timestamps();
        });

        Schema::create('chapters', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->unsignedInteger('index')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->text('details')
                  ->nullable();

            $table->unsignedInteger('index')
                  ->nullable();

            $table->boolean('is_visible')
                  ->comment('If the video is visible, but maybe not clickable. Useful to appear as a being-created video.')
                  ->default(false);

            $table->boolean('is_active')
                  ->comment('Video was created, and can be viewed (if allowed).')
                  ->default(false);

            $table->boolean('is_free')
                  ->default(false);

            $table->unsignedInteger('chapter_id')
                  ->nullable();

            $table->integer('duration')
                  ->comment('Total seconds, converted to i:s in the frontend via custom casts.')
                  ->nullable();

            $table->unsignedBigInteger('vimeo_id')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('links', function (Blueprint $table) {
            $table->id();

            $table->string('title');

            $table->text('url');

            $table->unsignedInteger('video_id')
                  ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('videos_completed', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('video_id');

            $table->unsignedInteger('user_id');

            $table->timestamps(); /* created_at is when the video was completed */
        });

        Schema::create('paddle_log', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('alert_id')
                  ->nullable();

            $table->string('alert_name')
                  ->nullable();

            $table->string('checkout_id')
                  ->nullable();

            $table->string('country')
                  ->nullable();

            $table->string('currency')
                  ->nullable();

            $table->string('customer_name')
                  ->nullable();

            $table->string('email')
                  ->nullable();

            $table->datetime('event_time')
                  ->nullable();

            $table->unsignedBigInteger('order_id')
                  ->nullable();

            $table->string('payment_method')
                  ->nullable();

            $table->string('receipt_url')
                  ->nullable();

            $table->decimal('sale_gross', 15, 2)
                  ->nullable();

            $table->decimal('gross_refund', 15, 2)
                  ->nullable();

            $table->string('refund_reason')
                  ->nullable();

            $table->longtext('passthrough')
                  ->nullable();

            $table->longtext('payload')
                  ->nullable();

            $table->timestamps();
        });

        // Call initial seeder. Mandatory to initialize the schema correctly.
        Artisan::call('db:seed', [
            '--class' => InitialSeeder::class,
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
    }
}
