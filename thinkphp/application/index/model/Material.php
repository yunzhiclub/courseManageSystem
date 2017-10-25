<?php
/**
 * Created by PhpStorm.
 * User: liming
 * Date: 17-9-7
 * Time: 上午8:41
 */

namespace app\index\model;

use think\Model;

class Material extends Model
{
    public function getIsChecked($attractionId) {
        $map['material_id'] = $this->id;
        $map['attraction_id'] = $attractionId;
        $attractionMaterial = AttractionMaterial::get($map);
        if(!is_null($attractionMaterial)) {
            return true;
        } else {
            return false;
        }
    }

    public function getMaterialImages() {
        $images = json_decode($this->images);
        return $images;
    }

    public function getAllCountries() {
        $countries = [];
        $materials = Material::all();
        if (!is_null($materials)) {
            foreach ($materials as $material) {
                array_push($countries, $material->country);
            }
        }
        $countries = array_unique($countries);
        return $countries;
    }
    public function getAreasByCountry($country) {
        $areas = [];
        $materials = Material::where('country', '=', $country)->select();
        if (!is_null($materials)) {
            foreach ($materials as $material) {
                array_push($areas, $material->area);
            }
        }
        $areas = array_unique($areas);
        return $areas;
    }
    public function getMaterialByCountryAndCity($country, $area)
    {
        $materials = [];
        $map = [];
        $map['country'] = $country;
        $map['area']    = $area;
        $materials = Material::where($map)->select();
        return $materials;
    }
}