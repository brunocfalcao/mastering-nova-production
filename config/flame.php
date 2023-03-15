<?php

use Brunocfalcao\Flame\PathFinders\FlamePathFinder;

return [

    'groups' => [
        /* Flame namespace groups.
            You need to specify your flame groups that you want to create features inside.
            Accepts 1 group key (namespace group) and 2 keys inside (namespace and path).

            '<namespace_group>' => [
                'namespace' => '<your feature namespace root>',
                'path' => '<the physical path to your feature namespace root>'
            ]
        */

        /* Suggested namespace group for your Laravel app.
            It will create features in your Your/Application/Features folder.
            You need to replace the \Your\Application\Features to your base
            namespace where you want the Features to be created.

            You need to replace the path by a specific string, function or
            an invokable class (__invoke()).
            E.g.:
            'path'      => FlamePathFinder::class,
        */
        'masteringnova' => [
            'namespace' => 'App\Features',
            'path'      => \App\PathFinders\MasteringNovaPathFinder::class,
        ],
        /*****/
    ],
];
