<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\HasMany;
use Whitecube\NovaFlexibleContent\Flexible;
use OptimistDigital\NovaSimpleRepeatable\SimpleRepeatable;
use NovaAttachMany\AttachMany;


class TicketType extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\TicketType';

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
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Items';

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
                ->help('What event is this ticket type for?'),

            Text::make('Name')
                ->help('The name of the ticket type.')
                ->rules('required'),

            Text::make('Slug')
                ->help('The slug of the ticket type. This is used in the URL.')
                ->rules('required'),

            Textarea::make('Description')
                ->help('The description of the ticket type.')
                ->rules('required'),

            Number::make('Price')
                ->help('The price of the ticket type.')
                ->rules('required'),

            Number::make('Sorting Order')
                ->help('The sorting order of the ticket type in listings.')
                ->rules('required'),

            Boolean::make('Active')
                ->help('Is this ticket type active?'),

            Boolean::make('Check student')
                ->help('Check if the user is a student?'),

            Number::make('Limit')
                ->help('The limit of the ticket type.')
                ->rules('required'),

            Number::make('Limit per person', 'limit_person')
                ->help('The limit per person of the ticket type.')
                ->rules('required'),

            Flexible::make('Custom Fields')
                ->button('Add Field')
                ->help('Add custom fields to the ticket type.')
                ->addLayout('Text field', 'text', [
                    Text::make('Question'),
                ])
                ->addLayout('Select field', 'select', [
                    Text::make('Question'),
                    SimpleRepeatable::make('Options', 'options', [
                        Text::make('Option'),
                    ]),
                ]),

            AttachMany::make('Modifiers')
                ->help('Add modifiers to the ticket type.'),

            AttachMany::make('Occurrences')
                ->help('Add occurrences to the ticket type.'),

            AttachMany::make('Donation Types')
                ->help('WIP: Add donation types to the ticket type.'),
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
