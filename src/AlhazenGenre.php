<?php

namespace Armincms\Alhazen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class AlhazenGenre extends Model
{
    use SoftDeletes, Sluggable; 

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    { 
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];   
    }  
}
