<?php

namespace Armincms\Alhazen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Armincms\Concerns\IntractsWithMedia; 
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Armincms\Location\Location;

class AlhazenArtist extends Model implements HasMedia
{
    use SoftDeletes, IntractsWithMedia;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    	'profile' => 'json'
    ];

	protected $medias = [
		'gallery' => [
			'multiple' => true,
			'disk' => 'armin.image',
			'schemas' => [
				'cover', '*',
			],
		],
		'avatar' => [
			'disk' => 'armin.image',
			'schemas' => [
				'avatar', 'thumbnail',
			],
		],
	];

    public function birthplace()
    {
     	return $this->belongsTo(Location::class);
    } 

    public function residence()
    {
     	return $this->belongsTo(Location::class);
    } 
}
