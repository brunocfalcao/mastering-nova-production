<?php

namespace App\Seeders;

use App\Chapter;
use App\Country;
use App\Link;
use App\PaddleLog;
use App\Subscriber;
use App\User;
use App\Video;
use App\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class InitialSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Add one line to the paddle_log so we can make checkout tests.
        PaddleLog::create([

            'alert_id' => '37439032',
            'alert_name' => 'payment_succeeded',
            'checkout_id' => '68618190-chre064887bf4ff-73176d78a7',
            'country' => 'CH',
            'currency' => 'USD',
            'customer_name' => 'BRUNO DA SILVA C FALCAO',
            'email' => 'bruno.falcao@live.com',
            'event_time' => now(),
            'order_id' => 18317663,
            'payment_method' => 'card',
            'receipt_url' => 'http://my.paddle.com/receipt/18317663/68618190-chre064887bf4ff-73176d78a7',
            'sale_gross' => '3.10',
            'gross_refund' => null,
            'refund_reason' => null,
            'passthrough' => null,
            'payload' => null,

        ]);

        // Import Laraning users into Mastering Nova subscribers
        // (csv laraning-users.csv).
        $lines = file(base_path('database/seeds/laraning-users.csv'), FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            $subscriber = explode(',', $line);
            Subscriber::create([
                'email' => $subscriber[2], ]);
        }

        // (csv mastering-nova-subscribers.csv).
        $lines = file(base_path('database/seeds/mastering-nova-subscribers.csv'), FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            $subscriber = explode(',', $line);
            Subscriber::create([
                'email' => $subscriber[1], ]);
        }

        // Delete all folders/files in the storage public directory.
        collect(Storage::allDirectories('public'))->each(function ($directory) {
            Storage::deleteDirectory($directory);
        });

        // Seed website.
        $website = Website::create(['title' => 'Mastering Nova - Laravel Nova tutorial']);

        $website->addMedia(resource_path('images/website/header-1.jpg'))
                ->preservingOriginal()
                ->toMediaCollection();

        $website->addMedia(resource_path('images/website/header-2.jpg'))
                ->preservingOriginal()
                ->toMediaCollection();

        $website->addMedia(resource_path('images/website/header-3.jpg'))
                ->preservingOriginal()
                ->toMediaCollection();

        $website->addMedia(resource_path('images/website/social-card.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('social');

        // Load countries + ppp data via csv file.
        $lines = file(base_path('database/seeds/countries.csv'), FILE_IGNORE_NEW_LINES);

        foreach ($lines as $line) {
            $country = explode(',', $line);

            Country::create([
                'code' => $country[1],
                'name' => str_replace(['"', '/'], ['', ''], $country[2]),

                // No ppp index ? Then should be 1.
                'ppp_index' => $country[3] == 'NULL' ? 1 : $country[3], ]);
        }

        // Create the only user that can have access to nova.
        User::create([
            'name' => 'Bruno Falcao',
            'email' => 'bruno@masteringnova.com',
            'password' => bcrypt('MoraisSoares1#!'),
        ]);

        // Create a test user.
        User::create([
            'name' => 'Bruno Falcao (live)',
            'email' => 'bruno.falcao@live.com',
            'password' => bcrypt('MoraisSoares1#!'),
        ]);

        // Create all chapters.
        $chapter = Chapter::create(
            ['title' => 'Nova Fundamentals']
        );

        $chapter->addMedia(resource_path('images/chapters/the-fundamentals-social-card.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('social');

        $chapter->addMedia(resource_path('images/chapters/the-fundamentals-featured.jpg'))
                ->preservingOriginal()
                ->toMediaCollection();

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Installing Nova',
                'details' => "Let's learn how to install Nova using the direct local folder repository or via composer update. Also, why you should use symlinks to sync your files and not mirror them into the vendor directory",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '426578439',
                'duration' => '09:46',
            ], 'installing-nova.jpg')
        );

        // Create respective video links.
        $videoId = Video::latest()->first()->id;
        $link = Link::create(['title' => 'Laravel Nova Docs reference',
                              'url' => 'https://nova.laravel.com/docs/3.0/installation.html#installing-nova',
                              'video_id' => $videoId, ]);

        $link = Link::create(['title' => 'Youtube video',
                              'url' => 'https://www.youtube.com/watch?v=52jZ4Foh1EY',
                              'video_id' => $videoId, ]);

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'First glance at the file structure',
                'details' => "After installing Nova, let's look at what have changed in your web app folders. What resources were installed and how you can use them to customize your frontend view partials, a walkthrough the nova.php configuration file, the nova source files and how Nova communicates your user actions via the nova-api",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440095119',
                'duration' => '11:49',
            ], 'first-glance-at-the-file-structure.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'What is a Resource?',
                'details' => "Let's take a look to the Resource that comes by default when you install your Nova instance, that is the Users Resource. You'll learn the default basic properties and also see what happens when you change them. And after this lesson we will create our first Resource and start working from there",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440130924',
                'duration' => '09:03',
            ], 'what-is-a-resource.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating your first Resource',
                'details' => "After using a migration to create our Products table, and the respective Eloquent Model, time to create our first Resource and start working from there. You'll learn how to use the Resource default properties, plus some that will very useful, and also how to create the fields for your Resource. We will then do a first try in creating the Fields and prepare to deep dive a little further in this scope",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440233416',
                'duration' => '15:38',
            ], 'creating-your-first-resource.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'First glance to the Resource Fields',
                'details' => 'Fields are one of the most important attributes of your Resource. There is tons of things you can configure them, validations, visibilty, display computation, besides extending them with your own business logic. In this tutorial we will pay a visit to the most popular Field methods, like visibility and validation',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440237994',
                'duration' => '09:18',
            ], 'first-glance-to-the-resource-fields.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'The beauty of Filters',
                'details' => "Lets start interacting with other functionalities of Nova, in this case the Filters. Let's create a first Filter, and apply it to 2 different Resources for filter active statuses. Also, you will learn how to dynamically render the header of the filter given the resource singular name that you working with",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440406246',
                'duration' => '13:12',
            ], 'the-beauty-of-filters.jpg')
        );

        // Uploaded on Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Getting deeper on data viewing using Lenses',
                'details' => "Lenses allows you to completely redesign your index query in order to show the data in a customized way. So, in this lesson we will create a Lens about the Top Buyers from our users and Products. We will also learn how to be able to sort computed columns since normally you can't do that without transforming your query in a different way",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440457414',
                'duration' => '17:17',
            ], 'getting-deeper-on-data-viewing-using-lenses.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Executing Actions on your Resources',
                'details' => "Actions allows you to bulk execute operations in the Resources that you select. So, let's create a first action that will change the status value in the Users Resources that we select, and also we will learn how to run Actions directly in the rows and not only in the Resources that we check",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440566590',
                'duration' => '11:52',
            ], 'executing-actions-on-your-resources.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Visualizing data using Metrics',
                'details' => "Metrics are charts that allows you to quickly display data from your Resources. In this tutorial let's go by the 3 types of metrics you can create and see how easy they are to customize",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440572988',
                'duration' => '13:01',
            ], 'visualizing-data-using-metrics.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'First glance at Resource Relationships',
                'details' => "Relationships are the heart of Laravel Nova. It's the way you connect resources with other resources by using the Eloqunet relationships that were defined in your Eloquent models. In this tutorial let's pass by the most common relationships and also see in detail the Polymorphic 1-to-Many relationships, leaving the Polymorphic Many-to-Many and the 1-to-Many with pivot editing for a later video",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440590153',
                'duration' => '23:30',
            ], 'first-glance-at-resource-relationships.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Using customized accessors on Global Search',
                'details' => "What if you need to have results in your Global Search but not given by by a native eloquent attribute but by a computer attribute (Accessor) that you will create? Let's deep dive in a way to completely generate computed columns with the results you want to show in your Global Search results",
                'is_visible' => true,
                'is_active' => true,
                'is_free' => true,
                'vimeo_id' => '417004687',
                'duration' => '05:57',
            ], 'using-customized-accessors-on-global-search.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Recompiling Nova assets',
                'details' => 'Nova comes with assets that you can change, and recompile to fit your needs. In this tutorial we will learn how to recompile the Nova assets and publish them in your public directory. At the end we will also correct the field TextArea to become aligned with width, so we can correct the Vue component, recompile, publish and see it corrected in your forms',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440640368',
                'duration' => '10:04',
            ], 'recompiling-nova-assets.jpg')
        );

        // Uploaded to Vimeo.
        $chapter->videos()->save(
            $this->video([
                'title' => 'Data sync between server and client UI components',
                'details' => 'We have server and client components, life for instance a Field. There is a server configuration, and a Vue Field component. In this tutorial we we learn how to pass data from the server to the vue component so you can then use it to affect the field itself. For instance, in this case, to pass a RGB color from the server to change the background color of the Text Field',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440652958',
                'duration' => '05:47',
            ], 'data-sync-between-server-and-client-ui-components.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating your first UI Component - An enhanced Field',
                'details' => 'After learning how to pass data to default Nova UI components, time to create our first UI Component, a Field. We will then develop it to be able to receive an icon parameter from the server, to render a fontawesome icon. Pretty neat!',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440670577',
                'duration' => '15:15',
            ], 'creating-your-first-ui-component-enhanced-field.jpg')
        );

        // Create all chapters.
        $chapter = Chapter::create(
            ['title' => 'Deep Dive on Resources']
        );

        $chapter->addMedia(resource_path('images/chapters/deep-dive-on-resources-social-card.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('social');

        $chapter->addMedia(resource_path('images/chapters/deep-dive-on-resources-featured.jpg'))
                ->preservingOriginal()
                ->toMediaCollection();

        $chapter->videos()->save(
            $this->video([
                'title' => 'Sorting your Resources in the Sidebar',
                'details' => 'There is an undocumented feature that allows you to sort your Resources on your Sidebar, using a priority attribute. Lets find out how to use it correctly',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440796216',
                'duration' => '03:55',
            ], 'sorting-your-resources-in-the-sidebar.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'The power of abstract Resources',
                'details' => "We'll start by learning how we can use Abstract Resources to contextualize specific common features like Actions, Lenses, into a group of Resources, and also how to use a master abstract Resource that will able us to use default sorting outside of the ID field",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440802260',
                'duration' => '21:41',
            ], 'the-power-of-abstract-resources.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Loading custom location Resources',
                'details' => "By default, Nova stores your Resources in the App\Nova namespace. But there is a way to load your Resources from another namespaces. Lets find out how.",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '440813817',
                'duration' => '02:19',
            ], 'loading-resources-from-custom-locations.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating a filter to select columns for your Index view',
                'details' => 'Getting deeper in Abstract Resources, lets create a Filter that will dynamically use your Resource columns to be visible or not in your index View',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '443540783',
                'duration' => '21:36',
            ], 'filter-to-select-columns.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'The full power of Resource Policies',
                'details' => "One of the most flexible authorization models on Nova is to use Resource Policies to restrict specific data scopes. Let's see how to restrict certain activities via Policy configurations",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '444352691',
                'duration' => '09:21',
            ], 'the-full-power-of-resource-policies.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Single package creation for all of your UI Components',
                'details' => 'Normally you need to create a new composer package for each any extension UI component. This lesson we will learn how to keep things tidy and just have a single package for everything',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '446299838',
                'duration' => '13:59',
            ], 'single-package-creation-for-all-of-your-ui-components.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Customizing your Resource visibility',
                'details' => 'There will be cases where you want to have a Resource not visible in the Sidebar, but still use them in the Relationships. In this Lesson we will learn how to use them and also see how to authorize them to be displayable or not',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '458751323',
                'duration' => '04:03',
            ], 'customizing-your-resource-visibility.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'How to correctly use the Index Query',
                'details' => "If you ever need to filter data given your user permission, you shouldn't use index queries. For that, we will dynamically attach model local scopes. Let's find out how",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '462826941',
                'duration' => '05:02',
            ], 'how-to-correctly-use-the-index-query.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Using Resource data scopes',
                'details' => 'One of the critical features you might have is to only show the data that your current user needs/should be able to see (and interact). Lets use Model scopes to limit the data we make accessible to the Nova logged user',
                'is_visible' => true,
                'is_active' => true,
                'is_free' => true,
                'vimeo_id' => '462968160',
                'duration' => '04:36',
            ], 'using-resource-data-scopes.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Cloning Resources for a better Resource categories strategy',
                'details' => 'If you have to show Resources that will need to categorize data, you might need to look at a Resource/Model cloning approach. In this lesson we will learn how to use a package to close our Model, and to attach it with a specific scope, as a possible approach',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '463216529',
                'duration' => '09:46',
            ], 'cloning-resources-for-a-better-resource-strategy.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Polymorphic Relationships',
                'details' => "Let's create a more advanced relationship that is the polymorphic relationship (MorphTo) and see how we can use it with our Resources",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '463229822',
                'duration' => '06:48',
            ], 'polymorphic-relationships.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Many-to-Many Relationships with additional pivot columns',
                'details' => 'Another complex relationship, but with the fact that you will also have access to the additional fields in your pivot table, and also how to use it with custom pivot names',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '463255054',
                'duration' => '03:22',
            ], 'many-to-many-relationship-with-additional-pivot-columns.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Changing Stub Files',
                'details' => "You can export the default stub files and change them. Let's get an example on one of them and see how you can further use it",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '463822872',
                'duration' => '02:28',
            ], 'changing-stub-files.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Configuring field groups for each display context',
                'details' => "On Nova 3.1.0 you have the ability to change the behavior of fields based on their visibility context (index, form, detail). Let's see a pratical example on how to change a field data based on these display contexts",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '463832522',
                'duration' => '02:23',
            ], 'configuring-field-groups-for-each-display-context.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Resource 1-o-1 Checklist Guidelines',
                'details' => 'Time to wrap up a bit and create what I call a Resource checklist! Meaning, how to do you follow a sequence of actions and validations to guarantee that you have covered it all when creating your Resources',
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '463966964',
                'duration' => '15:48',
            ], 'resource-1-o-1-checklist-guidelines.jpg')
        );

        $chapter = Chapter::create(
            ['title' => 'Deep Dive on UI Components']
        );

        $chapter->addMedia(resource_path('images/chapters/deep-dive-on-ui-components-social-card.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('social');

        $chapter->addMedia(resource_path('images/chapters/deep-dive-on-ui-components-featured.jpg'))
                ->preservingOriginal()
                ->toMediaCollection();

        $chapter->videos()->save(
            $this->video([
                'title' => 'What is an UI Component?',
                'details' => "Anything that you normally extend on Nova is an UI component: A Field, Card, Lenses, Filter, Metric or a Tool. Let's see the structure and start understanding how Nova interacts with custom UI Components",
                'is_visible' => true,
                'is_active' => false,
            ], 'what-is-an-ui-component.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Designing a simple UI Component',
                'details' => "Let's start by creating a very simple component just to understand how to send data to the server, and receive data to affect our UI component",
                'is_visible' => true,
                'is_active' => false,
            ], 'designing-a-simple-ui-component.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'UI Component properties you can use',
                'details' => "What Vue properties do you have that are given by Nova? Let's explore these properties and take the best of them",
                'is_visible' => true,
                'is_active' => false,
            ], 'ui-component-properties-you-can-use.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Extending default Nova UI Components',
                'details' => "You want to create your UI component, but what if you want already to use a base one from Nova? Let's learn how to not re-invent the wheel",
                'is_visible' => true,
                'is_active' => false,
            ], 'extending-default-nova-ui-components.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Using $emit events',
                'details' => 'A Nova way to transfer data between frontend UI components is to use the emit event. It will broadcast an event, for others to then trigger further actions',
                'is_visible' => true,
                'is_active' => false,
            ], 'using-emit-events.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Pratical example with $emit on 2 Dropdowns',
                'details' => "Let's see the \$emit event in practise working between 2 dropdowns. One dropdown will affect the value change of another dropdown",
                'is_visible' => true,
                'is_active' => false,
            ], 'practical-example-2-dropdowns.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => "Let's build a Tool! Helpdesk System",
                'details' => "Let's create a ticketing system together! Starting by creating the composer package",
                'is_visible' => true,
                'is_active' => false,
            ], 'creating-the-composer-package.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Sidebar Resource Cloning',
                'details' => "I really like to use the Resource cloning logic. So, let's create the My Tickets, and the All Tickets resources. We could do it too using a Filter, but it would have been too simple :)",
                'is_visible' => true,
                'is_active' => false,
            ], 'sidebar-cloning.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating the Assign Ticket action',
                'details' => 'After having our All Tickets Resource index, we need to create an action to fetch tickets to our queue to work on them',
                'is_visible' => true,
                'is_active' => false,
            ], 'creating-the-assign-ticket-action.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating the My Tickets index using local scopes',
                'details' => "Let's create our index view for our tickets, and then take it from there to resolve the ticket",
                'is_visible' => true,
                'is_active' => false,
            ], 'creating-the-my-tickets-index-using-local-scopes.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Having an admin permission to manage any ticket',
                'details' => "So what if you are on vacations and someone needs to resolve your tickets that you had pending? Let's create an admin role so anyone that has this role can manage tickets",
                'is_visible' => true,
                'is_active' => false,
            ], 'having-an-admin-permission-to-manage-any-ticket.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating the Ticket Resolved action',
                'details' => 'We can now create an action that will trigger an email to the client, with the response message',
                'is_visible' => true,
                'is_active' => false,
            ], 'creating-the-ticket-resolved-action.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating another Action to unassign tickets',
                'details' => "So, let's create a final action that will allow you to put back the ticket into the tickets queue",
                'is_visible' => true,
                'is_active' => false,
            ], 'creating-another-action-to-unassign-tickets.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Creating Ticket Performance Cards',
                'details' => "Finally, let's put some visual KPI's to create a My performance Card, and All Tickets per day Card",
                'is_visible' => true,
                'is_active' => false,
            ], 'creating-ticket-performance-cards.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Resource Testing 1-o-1',
                'details' => 'A pratical scenario on how to test your Resources so you can get an initial view on it',
                'is_visible' => true,
                'is_active' => false,
            ], 'resource-testing-1-o-1.jpg')
        );

        $chapter = Chapter::create(
            ['title' => 'Best community Packages']
        );

        $chapter->addMedia(resource_path('images/chapters/best-community-packages-social-card.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('social');

        $chapter->addMedia(resource_path('images/chapters/best-community-packages-featured.jpg'))
                ->preservingOriginal()
                ->toMediaCollection();

        $chapter->videos()->save(
            $this->video([
                'title' => 'Search Relations',
                'details' => "By default, Laravel Nova doesn't allow you to search in the Index View, in Relationship columns. This package will make that available to you",
                'is_visible' => true,
                'is_active' => true,
                'vimeo_id' => '463990113',
                'duration' => '03:01',
            ], 'search-relations.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Button Field',
                'details' => 'Brian Dillingham made an awesome field that is a button that can have any action you want',
                'is_visible' => true,
                'is_active' => false,
            ], 'button-field.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Ajax Child Select',
                'details' => 'When you have several dropdowns you can connect them so the child ones will be updated given the value of the parent dropdown',
                'is_visible' => true,
                'is_active' => false,
            ], 'ajax-child-select.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Nova Assertions',
                'details' => 'This is an essential package for your testing. Brian made new assertions that will help you a lot on resource testing',
                'is_visible' => true,
                'is_active' => false,
            ], 'nova-assertions.jpg')
        );

        $chapter->videos()->save(
            $this->video([
                'title' => 'Responsive Theme',
                'details' => 'By default, Nova is not responsive. This package gives you the minimum responsiveness under the default framework',
                'is_visible' => true,
                'is_active' => false,
            ], 'responsive-theme.jpg')
        );
    }

    protected function video(array $data, string $path)
    {
        $video = Video::create($data);

        $video->save();

        $video->addMedia(resource_path("images/videos/{$path}"))
              ->preservingOriginal()
              ->toMediaCollection();

        return $video;
    }
}
