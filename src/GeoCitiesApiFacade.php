<?php


namespace fGalvao\GeoCitiesApi;

use Illuminate\Support\Facades\Facade;

class GeoCitiesApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'geoCitiesApi';
    }
}