<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;

class Occurrence extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Occurrence::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'date_from';

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Event';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the value that should be displayed to represent the resource.
     *
     * @return string
     */
    public function title()
    {
        return $this->date_from . ' - ' . $this->date_to . ' (' . $this->location . ')';
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            BelongsTo::make('Event')
                ->help('The event this occurrence belongs to.')
                ->sortable()
                ->rules('required', 'exists:events,id'),

            DateTime::make('Date From')
                ->help('The date and time this occurrence starts.')
                ->sortable()
                ->rules('required', 'date'),

            DateTime::make('Date To')
                ->help('The date and time this occurrence ends.')
                ->sortable()
                ->rules('required', 'date'),

            Text::make('Location')
                ->help('The location of this occurrence.')
                ->sortable()
                ->rules('required', 'max:255'),

            Number::make('Delta Price')
                ->help('WIP: If you want another price for this occurrence, enter it here. Otherwise leave it empty and the main ticket type price will be used.')
                ->rules('required', 'integer'),

            Number::make('Ticket Limit')
                ->help('The maximum number of tickets that can be sold for this occurrence. Leave empty for no limit.')
                ->rules('required', 'integer', 'min:0'),

            Number::make('Tickets Left')
                ->readonly(),
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
