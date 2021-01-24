<?php

namespace CodeByFlame\Thumbnails\Facades;

use CodeByFlame\Thumbnails\Storage\GlobalsStorage;
use Illuminate\Support\Facades\Facade;

class ThumbnailsStorage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return GlobalsStorage::class;
    }
}
