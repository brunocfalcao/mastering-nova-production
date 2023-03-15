<?php

namespace App\PathFinders;

class MasteringNovaPathFinder
{
    public function __invoke()
    {
        return app_path('Features');
    }
}
