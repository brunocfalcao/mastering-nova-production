<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends ResourceAbstract
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'email',
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

            Text::make('Name', 'name')
                ->rules('required', 'max:255'),

            Text::make('Email', 'email')
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password', 'password')
                ->onlyOnForms()
                ->creationRules('string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Text::make('Remember Token', 'remember_token')
                ->withMeta(['placeholder' => 'No token defined'])
                ->readonly()
                ->onlyOnDetail(),

            Text::make('UUID', 'uuid')
                ->readonly(),

            Text::make('Invoice Link', function () {
                $invoiceLink = $this->invoice_link;

                return "<a href='{$invoiceLink}'>Click here</a>";
            })->asHtml(),

            Boolean::make('Allows Emails?', 'allows_emails'),

            KeyValue::make('Properties', 'properties')->rules('json'),

            BelongsToMany::make('Videos Viewed', 'videosCompleted', Video::class)
                         ->singularLabel('Video'),

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
