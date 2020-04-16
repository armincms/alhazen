<?php

namespace Armincms\Alhazen\Nova;

use Armincms\Tab\Tab;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\BelongsTo; 

class Company extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Alhazen\\AlhazenCompany';

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
        'name',
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
            
            Text::make(__("Slug"), "slug")
                ->nullable(), 

            BelongsTo::make(__("A subsidiary of"), 'company', static::class)
                ->nullable()
                ->withoutTrashed(),

            $this->abstractField(),

            // $this->gutenbergField(), 
        ];
    } 
}
