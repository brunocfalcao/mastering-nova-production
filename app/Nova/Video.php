<?php

namespace App\Nova;

use App\Nova\Filters\VideoChapterFilter;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Video extends ResourceAbstract
{
    public static $indexDefaultOrder = ['index' => 'asc'];

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Video::class;

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
        'title', 'details',
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

            Textarea::make('Details', 'details')
                    ->hideFromIndex()
                    ->rules('nullable', 'string'),

            Number::make('Index', 'index')
                  ->rules('nullable', 'numeric'),

            Boolean::make('Is Visible?', 'is_visible'),

            Boolean::make('Is Active?', 'is_active')
                   ->help('If it is active, then it can be clickable'),

            Boolean::make('Is Free?', 'is_free'),

            Number::make('Vimeo Id', 'vimeo_id')
                  ->rules('nullable', 'numeric'),

            Text::make('Duration', 'duration')
                ->displayUsing(function ($value) {
                    if ($value !== null) {
                        return explode(':', $value)[0].' mins '.explode(':', $value)[1].' secs ';
                    }
                }),

            Images::make('Social image', 'default')
                  ->conversionOnForm('thumb')
                  ->rules('required'),

            Text::make('Video File', 'filename')
                ->hideFromIndex()
                ->rules('required'),

            /*
            File::make('Video File', 'video_path')
                ->disk('b2')
                ->storeAs(function (Request $request) {
                    return $request->video_path->getClientOriginalName();
                }),
            */

            BelongsTo::make('Chapter', 'chapter', Chapter::class)
                     ->withoutTrashed(),

            HasMany::make('Links', 'links', Link::class),

            BelongsToMany::make('Completed By', 'completedBy', User::class, 'video_id', 'user_id')
                         ->singularLabel('User'),
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
        return [
            new VideoChapterFilter(),
        ];
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
