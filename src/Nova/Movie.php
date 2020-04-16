<?php

namespace Armincms\Alhazen\Nova;
 
use Illuminate\Support\Facades\Date; 
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Number; 
use Laravel\Nova\Fields\Select; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\DateTime; 
use Laravel\Nova\Fields\BelongsTo; 
use OptimistDigital\MultiselectField\Multiselect;
use Whitecube\NovaFlexibleContent\Flexible;
use Inspheric\Fields\Url;
use Armincms\RawData\Common;
use Armincms\Fields\BelongsToMany; 

class Movie extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Alhazen\\AlhazenMovie';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name', 'names', 'label', 'type'
    ]; 

    /**
     * The number of resources to show per page via relationships.
     *
     * @var int
     */
    public static $perPageViaRelationship = 25;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make("ID")
                ->sortable()
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }), 

            BelongsTo::make(__("Company"), 'company', Company::class)
                ->nullable()
                ->withoutTrashed()
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }),
            
            Text::make(__("Name"), "label")
                ->required()
                ->rules($request->resource() !== Episode::class ? "required" : null), 
            
            Text::make(__("Latin Name"), "name")
                ->required()
                ->rules($request->resource() !== Episode::class ? "required" : null), 
            
            $this->slugField(),
                
            $this->tagsInput(__("The other names"), 'names')
                ->nullable(), 

            BelongsToMany::make(__("Genres"), 'genres', Genre::class)
                ->hideFromIndex()
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }),

            BelongsToMany::make(__("Artists"), 'artists', Artist::class)
                ->fields(function() { 
                    return [
                        Select::make(__("Role"), 'role_id')
                            ->options(Role::$model::get()->pluck('name', 'id'))
                            ->required()
                            ->rules('required')
                            ->displayUsingLabels(),
                    ];
                })
                ->pivots()
                ->duplicate()
                ->hideFromIndex(),

            BelongsToMany::make(__("Tags"), 'tags', Tag::class) 
                ->hideFromIndex()
                ->fillUsing(function($pivots) {
                    return array_merge($pivots, [
                        'taggable_type' => static::newModel()->getMorphClass() 
                    ]);
                }),

            $this->imageField(__("Gallery"), 'gallery')->customPropertiesFields([
                Boolean::make(__("Cover"), "cover"),
            ]),

            $this->abstractField(__("Story"), 'story'),

            $this->abstractField()
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }), 

            $this->panel(__("Detail"), $this->detail()), 

            $this->panel(__("Links"), $this->links()),
        ];
    } 

    public function detail()
    {
        return $this->jsonField('detail', [ 
            $this->heading("Release"),

            Boolean::make(__("Coming Soon"), 'coming_soon'),

            DateTime::make(__("Release Date"), "release_date")
                ->nullable()
                ->resolveUsing(function($value, $resource, $attribute) { 
                    return is_null($value) ? null : Date::createFromTimestamp($value); 
                }),

            Number::make(__("Duration"), "duration")
                ->help(__("Minutes"))
                ->canSee(function($request) {
                    return $request->resource() !== Series::class;
                }),


            $this->jsonField('audience', [
                $this->heading("Audience"),

                Text::make(__("Min Age"), "min")
                    ->nullable(),

                Text::make(__("Max Age"), "max")
                    ->nullable(),
            ])->canSee(function($request) {
                return $request->resource() !== Episode::class;
            }),

            $this->heading("Other")
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }),

            Multiselect::make(__("Countries"), 'countries')
                ->options(Common::countries()->pluck("name", "code"))
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }),

            Multiselect::make(__("Languages"), 'languages')
                ->options(Common::locales()->pluck("native", "regional_locale"))
                ->canSee(function($request) { 
                    return $request->resource() !== Episode::class;
                }),

        ])->saveHistory()->hideFromIndex()->toArray();
    }

    public function links()
    { 
        return [
            Flexible::make("links")
                ->addLayout(__('Video'), 'video', $this->linkDetail())
                ->addLayout(__('Duubed'), 'dubbed', $this->linkDetail())
                ->addLayout(__('Subtitle'), 'subtitle', $this->linkDetail())
                ->button(__("New Link")) 
                ->confirmRemove() 
                ->collapsed(false) 
        ];
    }

    public function linkDetail()
    {
        return [
            Url::make('Url')
                ->required()
                ->rules('required'),  

            Select::make(__("Language"), 'language')
                ->options(Common::locales()->pluck("native", "regional_locale")),

            Select::make(__("Quality"), 'quality')->options(Common::qualities()),

            $this->heading(__("Size")),

            Select::make(__("Volume"), 'volume')->options(Common::volumes()),

            Number::make(__("Value"), 'value')->onlyOnForms(),  
        ];
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
            new Filters\Company, 
            new Filters\Artist,
            new Filters\Genre,
        ];
    }
}
