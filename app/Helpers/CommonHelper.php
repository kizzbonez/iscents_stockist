<?php
namespace App\Helpers;

use App\Models\Product;
use App\Models\User;

class CommonHelper
{


    public  static function getCities(){
        $cities = \App\Models\City::all();
        return $cities;
    }

    public  static function getCitiesById($id){
        $city = \App\Models\City::find($id);
        if(self::isNotNullOrEmpty($city)){
            return $city['city_municipality_description'];
        }else{
            return 'N/A';
        }
    }

    public static function getProvinces(){
        $provinces = \App\Models\Province::all();
        return $provinces;
    }
    public static function getProvincesById($id){
        $province = \App\Models\Province::find($id);
        if(self::isNotNullOrEmpty($province)){
            return $province['province_description'];
        }else{
            return 'N/A';
        }

    }

    public static function getInfoFromArray($array,$key){
        if(isset($array[$key])){
            return $array[$key];
        }
        return null;
    }

    /**
     * Check if variable is empty or null
     * @param null $field
     * @return bool
     */
    public static function isNullOrEmpty($field)
    {
        return (!isset($field) || is_null($field) || empty($field) || $field == '');
    }
    /**
     * Check if variable is not empty or null
     * @param null $field
     * @return bool
     */
    public static function isNotNullOrEmpty($field)
    {
        return !self::isNullOrEmpty($field);
    }

    public static function userInfoToFormData(User $userInfo){
        $userInfoArr = array();
        $userInfoArr['username'] = $userInfo['username'];
        $userInfoArr['name'] = $userInfo['name'];
        $userInfoArr['id'] = $userInfo['id'];
        $userInfoArr['email'] = $userInfo['email'];
        $userInfoArr['address'] = $userInfo['address'];
        $userInfoArr['province'] = $userInfo['province'];
        $userInfoArr['contact_number'] = $userInfo['contact_number'];
        $userInfoArr['stockist_type'] = $userInfo['stockist_type_id'];
        $userInfoArr['city'] = $userInfo['city'];

        return $userInfoArr;

    }
    /**
     * Remove dash from the string
     * @param  string $string
     * @return string
     */
    public static function  removeDash($string,Array $segment = [])
    {
        if(is_numeric($string))
        {
            if(in_array('stocks',$segment) || in_array('products',$segment)){
                 $product = Product::find($string);
                 if(CommonHelper::isNotNullOrEmpty($product)){
                     $string = $product['name'];
                 }
            }
        }else{
            if((preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $string) !== 1))
            {
               $string =  ucwords(str_replace('-',' ',$string));
            }else{
                $string = null;
            }
        }

        return $string ;
    }


}
