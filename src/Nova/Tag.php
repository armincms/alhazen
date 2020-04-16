<?php

namespace Armincms\Alhazen\Nova;

use Armincms\Taggable\Nova\Tag as Resource;

class Tag extends Resource
{  
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Alhazen';   

    public function taggables() : array
    {
        return [
            Alhazen::class,
        ];
    }
}
