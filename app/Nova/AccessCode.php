<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;

class AccessCode extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\AccessCode::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Event';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Code')
                ->help('This is the code that will be used to access the tickets. (https://billio.test/event/[EVENT_SLUG]?access_code=[CODE])')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsTo::make('Event')
                ->help('The event that the code is valid for.')
                ->sortable()
                ->rules('required'),

            Number::make('Limit')
                ->help('The number of tickets that can be purchased with this code.')
                ->sortable()
                ->rules('required', 'numeric', 'min:1'),

            DateTime::make('Valid From')
                ->help('The date and time that the code will be valid from.')
                ->sortable()
                ->rules('required', 'date'),

            DateTime::make('Valid To')
                ->help('The date and time that the code will be valid to.')
                ->sortable()
                ->rules('required', 'date'),
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
