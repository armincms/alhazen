<?php

namespace Armincms\Alhazen\Nova;

use Armincms\Tab\Tab;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 

class Role extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Alhazen\\AlhazenRole';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
    ]; 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return[
            ID::make("ID")->sortable(), 
            
            Text::make(__("Name"), "name")
                ->required()
                ->rules("required"),
        ];
    }

    /**
     * Get the URI key for the resource.
     *
     * @return string
     */
    public static function uriKey()
    {
        return 'alhazen-'. parent::uriKey(); 
    }
}
