<?php


namespace fGalvao\GeoDbApi;

use Illuminate\Support\Facades\Facade;

class GeoDbFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'geodb';
    }
}