<?php

namespace Armincms\Alhazen;
 

class AlhazenEpisode extends Media
{   
	public function series()
	{
		return $this->belongsTo(static::class, 'media_id');
	}
}
