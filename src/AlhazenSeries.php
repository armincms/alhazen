<?php

namespace Armincms\Alhazen;
 

class AlhazenSeries extends Media
{   
	public function episodes()
	{
		return $this->hasMany(AlhazenEpisode::class, 'media_id');
	}
}
