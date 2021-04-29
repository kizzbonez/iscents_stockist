<?php
namespace App\Helpers;

class CommonHelper
{


    public  static function getCities(){
        $cities = \App\Models\City::all();
        return $cities;
    }

    public static function getProvinces(){
        $provinces = \App\Models\Province::all();
        return $provinces;
    }

}
