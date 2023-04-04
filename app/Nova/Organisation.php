<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Organisation extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Organisation';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

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
        'title',
        'nin',
        'email',
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
            Text::make('Title')
                ->help('The name of the organisation')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('NiN')
                ->help('The organisation\'s National Identification Number')
                ->rules('required'),

            Text::make('Email')
                ->help('The organisation\'s email address. Will be shown to the user.')
                ->sortable()
                ->rules('required', 'email', 'max:254'),

            Text::make('Phone')
                ->help('The organisation\'s phone number. Will not be shown to the user.')
                ->sortable()
                ->rules('required', 'max:254'),

            Text::make('URL')
                ->help('The organisation\'s website. Will be shown to the user.')
                ->sortable()
                ->rules('required', 'max:254'),

            Textarea::make('Address')
                ->help('The organisation\'s address. Will be shown to the user.')
                ->creationRules('required'),

            Text::make('Stripe Public Key')
                ->help('The organisation\'s Stripe public key.')
                ->sortable()
                ->rules('required', 'max:254'),

            Text::make('Stripe Secret Key')
                ->help('The organisation\'s Stripe secret key.')
                ->sortable()
                ->rules('required', 'max:254'),
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
