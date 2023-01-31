<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\DateTime;
use Whitecube\NovaFlexibleContent\Flexible;
use OptimistDigital\NovaSimpleRepeatable\SimpleRepeatable;
use NovaAttachMany\AttachMany;

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
            BelongsTo::make('Organisation')
                ->help('What organisation is this event for?'),

            Text::make('Name')
                ->help('Name of the event')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug')
                ->help('The slug is used in the URL for this event. It should be unique and not change.')
                ->rules('required', 'max:255'),

            DateTime::make('Date From')
                ->help('When does the event start?')
                ->sortable()
                ->rules('required', 'date'),

            DateTime::make('Date To')
                ->help('When does the event end?')
                ->sortable()
                ->rules('required', 'date'),

            Text::make('Location')
            ->help('Whare is the main location for the event?')
                ->sortable()
                ->rules('required', 'max:255'),

            Flexible::make('Content', 'description')
                ->help('The content for the event page')
                ->addLayout('Simple Content Section', 'wysiwyg', [
                    Text::make('Title'),
                    Markdown::make('Content')
                ]),

            Textarea::make('Excerpt')
                ->help('The excerpt is used in the event list and on social media')
                ->rules('required'),

            Image::make('Hero image')
                ->help('The hero image is used on the event page')
                ->creationRules('required'),
            Image::make('Share image')
                ->help('The share image is used on social media')
                ->creationRules('required'),
            Image::make('Excerpt image')
                ->help('The excerpt image is used in the event list')
                ->creationRules('required'),

            HasMany::make('Access Codes'),
            HasMany::make('Ticket Types'),
            HasMany::make('Tickets'),
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
