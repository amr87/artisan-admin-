<?php

 namespace Artisan\Policy;
 use Illuminate\Support\Facades\Facade;
 
class Policy extends Facade{
    
    public static function getFacadeAccessor() {
       
        return "Policy";
    }
}
