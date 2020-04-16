<?php

namespace Armincms\Alhazen\Nova;
  
use Armincms\Taggable\Nova\Taggable;
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;  
use Laravel\Nova\Fields\Boolean;  

class Alhazen extends Taggable
{  
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static function fields(Request $request) : array
    {
        return [
            ID::make("ID")
                ->sortable()
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }), 

             
        ];
    }  
}
