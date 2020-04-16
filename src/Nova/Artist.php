<?php

namespace Armincms\Alhazen\Nova;
 
use Illuminate\Support\Facades\Date;
use Illuminate\Http\Request; 
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text; 
use Laravel\Nova\Fields\Select; 
use Laravel\Nova\Fields\Boolean; 
use Laravel\Nova\Fields\Heading; 
use Laravel\Nova\Fields\DateTime; 
use Laravel\Nova\Fields\belongsTo; 
use Armincms\Location\Nova\City;
use Armincms\RawData\Common;
use Inspheric\Fields\Email;
use Inspheric\Fields\Url;

class Artist extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Armincms\\Alhazen\\AlhazenArtist';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'fullname';

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

            Text::make(__("Fullname"), "fullname")
                ->required(),

            Text::make(__("Stagename"), "stagename")
                ->nullable(), 

            Select::make(__("Gender"), 'gender')
                    ->options(Common::genders())
                    ->default('male'),

            BelongsTo::make(__("Residence City"), 'residence', City::class)
                    ->withoutTrashed()
                    ->nullable(),

            BelongsTo::make(__("Birthplace"), 'birthplace', City::class)
                    ->withoutTrashed()
                    ->nullable(),

            $this->imageField(__("Avatar"), 'avatar'),

            $this->imageField(__("Gallery"), 'gallery')->customPropertiesFields([
                Boolean::make(__("Cover"), "cover"),
            ]),

            $this->abstractField(__("Biography"), 'biography')
                ->nullable(),

            $this->panel(__("Profile"), $this->jsonField("profile", [ 
                
                Text::make(__("Phone"), 'phone')
                    ->nullable(),

                Text::make(__("Mobile"), 'mobile')
                    ->nullable(),

                Text::make(__("Fax"), 'fax')
                    ->nullable(),

                Email::make(__("Email"), 'email')
                    ->nullable(),

                Url::make(__("Official Page"), 'official_page')
                    ->nullable(),  
                    
                DateTime::make(__("Birthday"), 'birthday')
                        ->nullable()
                        ->resolveUsing(function($value, $resource, $attribute) { 
                            return is_null($value) ? null : Date::createFromTimestamp($value); 
                        }),

                DateTime::make(__("Death"), 'death')
                        ->nullable()
                        ->resolveUsing(function($value, $resource, $attribute) {
                            return is_null($value) ? null : Date::createFromTimestamp($value);
                        }),

                DateTime::make(__("Working Start"), 'working_start')
                        ->nullable()
                        ->resolveUsing(function($value, $resource, $attribute) {
                            return is_null($value) ? null : Date::createFromTimestamp($value);
                        }),

            ])->hideFromIndex()->toArray()),

            $this->panel(__("Agent"), $this->jsonField("profile", [
                $this->jsonField("agent", [ 
                    Text::make(__("Fullname"), "fullname")
                        ->nullable(),

                    Text::make(__("Phone"), 'phone')
                        ->nullable(),

                    Text::make(__("Mobile"), 'mobile')
                        ->nullable(),

                    Text::make(__("Fax"), 'fax')
                        ->nullable(),

                    Email::make(__("Email"), 'email')
                        ->nullable(),

                    Text::make(__("Address"), 'address')
                        ->nullable(),
                ]),  
            ])->saveHistory()->hideFromIndex()->toArray()),
        ];
    } 
}
