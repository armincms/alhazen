<?php

namespace Armincms\Alhazen\Nova;
 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID; 
use Laravel\Nova\Fields\Number; 

class Episode extends Movie
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Alhazen\\AlhazenEpisode';  

    /**
     * Determine if this resource is available for navigation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public static function availableForNavigation(Request $request)
    {
        return false;
    } 

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return array_merge([ 
            ID::make("ID")->sortable(),

        ], $this->jsonField('detail', [
            Number::make(__("Season"), "season")
                ->sortable()
                ->required()
                ->rules('required')
                ->default(1),

            Number::make(__("Episode"), "episode")
                ->sortable()
                ->required()
                ->rules('required')
                ->default(1),

        ])->toArray(), parent::fields($request)); 
    } 

    /**
     * Get the filters available on the entity.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\Seasons
        ];
    }
}
