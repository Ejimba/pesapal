<?php namespace Ejimba\Pesapal\Facades;

use Illuminate\Support\Facades\Facade;

class Pesapal extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'pesapal'; }

}