<?php

namespace Armincms\Alhazen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Armincms\Concerns\IntractsWithMedia; 
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Cviebrock\EloquentSluggable\Sluggable;
use Armincms\Taggable\Taggable;

class Media extends Model implements HasMedia
{
    use SoftDeletes, IntractsWithMedia, Sluggable, Taggable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "alhazen_medias";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	"link" => "json",
    	"names" => "json",
    	"detail" => "json",
    	"seo" => "json",
    ];


    protected $medias = [
        'gallery' => [
            'multiple' => true,
            'disk' => 'armin.image',
            'schemas' => [
                'cover', 'alhazen.movie', '*',
            ],
        ], 
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        $name = mb_strtolower(class_basename(static::class)); 

        if($name !== 'media') { 
            static::addGlobalScope(function($query) use ($name) { 
            	$query->where(
            		$query->qualifyColumn('group'), str_replace('alhazen', '', $name)
            	);
            });

            static::saving(function($model) use ($name) {
                $model->group = str_replace('alhazen', '', $name);
            }); 
        }
    }  

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

    public function company()
    {
     	return $this->belongsTo(AlhazenCompany::class);
    }   

    public function artists()
    {
        return $this->belongsToMany(
            AlhazenArtist::class, 
            'alhazen_artist_media', 
            'media_id', 
            'artist_id'
        )->withPivot('id', 'role_id');
    }

    public function genres()
    {
        return $this->belongsToMany(
            AlhazenGenre::class, 
            'alhazen_genre_media', 
            'media_id', 
            'genre_id'
        );
    }

    /**
     * Get the class name for polymorphic relations.
     *
     * @return string
     */
    public function getMorphClass()
    { 
        return Media::class;
    }

    public function scopeHasTags($builder, array $tags = [])
    { 
        return $builder->when($tags, function($query, $tags) {
            $query->whereHas('tags', function($q) use ($tags) {
                return $q->whereIn($q->qualifyColumn('id'), $tags);
            }); 
        }); 
    }

    public function scopeHasGenres($builder, array $genres = [])
    { 
        return $builder->when($genres, function($query, $genres) {
            $query->whereHas('genres', function($q) use ($genres) {
                return $q->whereIn($q->qualifyColumn('id'), $genres);
            }); 
        }); 
    } 

    public function scopeTypeOf($builder, array $groups = [])
    { 
        return $builder->when($groups, function($query, $groups) {
            $query->whereIn($query->qualifyColumn('group'), $groups); 
        });
    }  
}
