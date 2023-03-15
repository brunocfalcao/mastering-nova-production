<?php

namespace Brunocfalcao\NovaStatsTracker;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class NovaStatsTracker extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-stats-tracker', __DIR__.'/../dist/js/tool.js');
        Nova::style('nova-stats-tracker', __DIR__.'/../dist/css/tool.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-stats-tracker::navigation');
    }
}
