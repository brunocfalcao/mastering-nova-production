<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;

class Chapter extends ResourceAbstract
{
    public static $indexDefaultOrder = ['index' => 'desc'];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Chapter::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
              ->showOnDetail()
              ->showOnUpdating()
              ->hideFromIndex(),

            Text::make('Title', 'title')
                ->rules('required', 'string'),

            Number::make('Index', 'index')
                  ->rules('numeric'),

            Images::make('Featured images', 'default'),

            Images::make('Social image', 'social'),

            HasMany::make('Videos', 'videos', Video::class),

            HasMany::make('Visible Videos', 'visibleVideos', Video::class),

            HasMany::make('Active Videos', 'activeVideos', Video::class),

            HasMany::make('Premium Videos', 'premiumVideos', Video::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
