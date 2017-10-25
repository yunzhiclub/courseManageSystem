<?php

namespace app\index\model;

use think\Model;
use think\Db;
/**
 * Created by PhpStorm.
 * User: zhangxishuo
 * Date: 2017/8/30
 * Time: 15:55
 */

class Hotel extends Model {
	public function getHotelByCity($city) {
        $map = ['city' => $city];
        return Db::table('hotel')->where($map)->select();
    }
    // public function getHotelByCountry($country) {
    //     $map = ['country' => $country];
    //     return Db::table('hotel')->where($map)->select();    
    // }
    public function getHotelByCountry($country) {
        $map = ['country' => $country];
        return Hotel::get($map);
    }
    public function getHotelByStarLevel($starlevel) {
        $map = ['star_level' => $starlevel];
        return Db::table('hotel')->where($map)->select();    
    }

    public function getAllCountries() {
        $countries = [];
        $hotels = Hotel::all();
        if (!is_null($hotels)) {
            foreach ($hotels as $hotel) {
                array_push($countries, $hotel->country);
            }
        }
        $countries = array_unique($countries);
        return $countries;
    }

    public function getCitiesByCountry($country) {
	    $cities = [];
	    $hotels = Hotel::where('country', '=', $country)->select();
	    if (!is_null($hotels)) {
	        foreach ($hotels as $hotel) {
	            array_push($cities, $hotel->city);
            }
        }
        $cities = array_unique($cities);
	    return $cities;
    }

    public function getStarsByCountryAndCity($country, $city) {
	    $stars = [];
	    $map = [];
	    $map['country'] = $country;
	    $map['city']    = $city;
	    $hotels = Hotel::where($map)->select();
	    if(!is_null($hotels)) {
	        foreach ($hotels as $hotel) {
	            array_push($stars, $hotel->star_level);
            }
        }
        $stars = array_unique($stars);
	    return $stars;
    }

    public function getHotelsByCountryAndCityAndStar($country, $city, $star) {
        $map = [];
        $map['country']    = $country;
        $map['city']       = $city;
        $map['star_level'] = $star;
        $hotels = Hotel::where($map)->select();
        return $hotels;
    }
}