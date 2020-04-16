<?php

namespace Armincms\Alhazen;
 
use Illuminate\Support\ServiceProvider; 
use Laravel\Nova\Nova as LaravelNova; 

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {  
        LaravelNova::serving([$this, 'servingNova']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    { 
    }

    public function servingNova()
    { 
        LaravelNova::resources([ 
            Nova\Tag::class,
            Nova\Role::class,
            Nova\Genre::class,
            Nova\Movie::class,
            Nova\Series::class,
            Nova\Episode::class,
            Nova\Artist::class,
            Nova\Company::class,
        ]);
    } 
}
