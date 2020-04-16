<?php

namespace Armincms\Alhazen\Nova;
 
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\HasMany; 

class Series extends Movie
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Alhazen\\AlhazenSeries';  

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return array_merge(parent::fields($request), [
            HasMany::make(__("Episodes"), "episodes", Episode::class),
        ]);
    }

    public function links()
    { 
        return [
            // not need
        ];
    }
}
