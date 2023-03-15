<?php

namespace App\Nova;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Requests\NovaRequest;

abstract class ResourceAbstract extends Resource
{
    /**
     * Based the trashed behavior on a new policy called trashedAny().
     *
     * @return bool
     */
    public static function softDeletes()
    {
        // Is this resource authorized on trashedAny?
        if (static::authorizable()) {
            return method_exists(Gate::getPolicyFor(static::newModel()), 'trashedAny')
                ? Gate::check('trashedAny', get_class(static::newModel()))
                : true;
        }

        return parent::softDeletes();
    }

    /**
     * Configurable indexQuery columns.
     *
     * @param  NovaRequest  $request
     * @param  QueryBuilder $query
     *
     * @return QueryBuilder $query
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        $uriKey = static::uriKey();

        if (! is_null(optional($request)->orderByDirection)) {
            return $query;
        }

        if (! empty(static::$indexDefaultOrder)) {
            $query->getQuery()->orders = [];

            return $query->orderBy(key(static::$indexDefaultOrder), reset(static::$indexDefaultOrder));
        }
    }
}
