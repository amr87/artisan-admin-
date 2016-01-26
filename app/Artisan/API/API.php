<?php

 namespace Artisan\API;
 use Illuminate\Support\Facades\Facade;
 
class API extends Facade{
    
    public static function getFacadeAccessor() {
       
        return "API";
    }
}
