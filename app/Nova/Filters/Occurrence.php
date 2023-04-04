<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class Occurrence extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'select-filter';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('occurrence_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        $occurrences = \App\Models\Occurrence::all();
        $returnArray = [];

        foreach ($occurrences as $occurrence) {
            $title = $occurrence->date_from->format('Y-m-d H:i') . ' - ' . $occurrence->date_to->format('Y-m-d H:i') . '(' . $occurrence->location . ')';
            $returnArray[$title] = $occurrence->id;
        }

        return $returnArray;
    }
}
