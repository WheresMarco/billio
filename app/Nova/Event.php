<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Facades\Storage;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Image;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;

class Event extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Event';

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
        'id',
        'name',
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
            BelongsTo::make('Organisation'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug')
                ->rules('required', 'max:255'),

            Markdown::make('Description'),

            Textarea::make('Excerpt'),

            HasMany::make('Event Dates'),

            HasMany::make('Ticket Types'),

            HasMany::make('Access Codes'),

            HasMany::make('Tickets'),

            Image::make('Hero image'),
            Image::make('Share image'),
            Image::make('Excerpt image'),
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
        return [
            (new Metrics\TicketsSold)->onlyOnDetail(),
            (new Metrics\TicketType)->onlyOnDetail(),
            (new Metrics\TicketStatus)->onlyOnDetail(),
        ];
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
