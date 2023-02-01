<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;

class Modifier extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Modifier';

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
            BelongsTo::make('Ticket Type'),

            Text::make('Name')
                ->help('The name of the modifier.')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Slug')
                ->help('The slug of the modifier. This is used in the URL. It should be unique and not change.')
                ->sortable()
                ->rules('required', 'max:255'),

            Textarea::make('Description')
                ->help('The description of the modifier.')
                ->rules('required'),

            Select::make('Modifier Type')->options([
                'modifier' => 'Default Modifier',
                'donation' => 'Donation',
                'hidden' => 'Hidden',
            ]),

            Number::make('Sorting Order')
                ->help('The sorting order of the modifier. Used to sort modifiers in the frontend.')
                ->default(0)
                ->rules('required'),

            Number::make('Delta')
                ->help('The amount to add to the base price of the item. Enter a negative number to subtract from the base price.')
                ->rules('required'),

            Number::make('Limit')
                ->help('The maximum number of times this modifier can be applied to an item. Enter 0 for unlimited.')
                ->rules('required'),
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
