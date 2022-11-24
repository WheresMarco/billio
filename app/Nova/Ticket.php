<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Actions\Actionable;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class Ticket extends Resource
{
    use Actionable, Notifiable;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Models\Ticket';

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
        'uuid',
        'event_id',
        'ticket_type_id',
        'user_id',
        'status',
        'ticket_code',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Ticket';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Text::make('Ticket Code')->readonly(),

            BelongsTo::make('Event'),

            BelongsTo::make('Ticket Type'),

            BelongsTo::make('User'),

            Text::make('Status')
                ->rules('required'),

            Text::make('Price')
                ->rules('required'),

            MorphToMany::make('Modifiers'),

            Text::make('Modifiers', function () {
                if (! $this->modifiers->first()) {
                    return;
                }

                $returnString = array_map(
                    function ($modifier) {
                        return $modifier->name;
                    },
                    $this->modifiers->all()
                );

                return implode(', ', $returnString);
            })->onlyOnIndex(),
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
            new Filters\TicketType,
            new Filters\TicketModifier,
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
        return [
            (new DownloadExcel)->withHeadings(),
            new Actions\FinalizeTicket,
            new Actions\ResendTicket,
            new Actions\ImportTickets,
        ];
    }
}
