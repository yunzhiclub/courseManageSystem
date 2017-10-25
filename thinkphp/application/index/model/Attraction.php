<?php

namespace app\index\model;

use think\Model;
use app\index\model\Material;
use app\index\model\Hotel;
/**
 * Created by PhpStorm.
 * User: zhangxishuo
 * Date: 2017/8/30
 * Time: 15:37
 */

class Attraction extends Model {

    public function getMealIsChecked($checkMeal) {
        $meals = json_decode($this->meal);
        if(!is_null($meals)) {
            foreach ($meals as $meal) {
                if($meal == $checkMeal) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getCheckedMaterial() {
        $map = ['attraction_id' => $this->id];
        $AttractionMaterials = AttractionMaterial::where($map)->select();
        $materials = [];
        if(!is_null($AttractionMaterials)) {
            foreach ($AttractionMaterials as $AttractionMaterial) {
                $materialId = $AttractionMaterial->material_id;
                $material = Material::get($materialId);
                array_push($materials, $material);
            }
        }
        return $materials;
    }

    public function getHotelDesignation() {
        if(!is_null($this->hotel_id)) {
            return Hotel::get($this->hotel_id)->designation;
        } else {
            return '';
        }
    }

    public function getCar() {
        $car = $this->car;
        if($car == 'sevenToNineBusinessCar') {
            return '7-9座商务车';
        } else if($car == 'train') {
            return '火车';
        } else if($car == 'car') {
            return '汽车';
        } else if($car == 'plane') {
            return '飞机';
        }
    }

    public function getMeals() {
        $meals = json_decode($this->meal);
        $str = null;
        if (!is_null($meals)) {
            foreach ($meals as $meal) {
                if ($meal == 'breakfast') {
                    $str = $str.'早餐 ';
                } else if ($meal == 'lunch') {
                    $str = $str.'午餐 ';
                } else if ($meal == 'supper') {
                    $str = $str.'晚餐';
                } else if ($meal == 'selfcare') {
                    $str = $str.'自理';
                }
            }
        }
        return $str;
    }

    public function Materials() {
        return $this->belongsToMany('Material', 'attraction_material');
    }

    public function AttractionMaterials() {
        return $this->hasMany('AttractionMaterial');
    }

    public function getMainMaterial() {
        return Material::get($this->material_id);
    }

    public function getMaterials() {
        $attractionMaterials = AttractionMaterial::where('attraction_id', '=', $this->id)->select();
        $materials = [];
        foreach ($attractionMaterials as $attractionMaterial) {
            if (!is_null($attractionMaterial->material_id)) {
                $material = Material::get($attractionMaterial->material_id);
                array_push($materials, $material);
            }
        }
        return $materials;
    }

    public function defaultCheck($param) {
        if ($param == 'add') {
            return true;
        } else {
            return false;
        }
    }

    public function getOneImage() {
        //获取当前的景点儿的素材
        $materials = $this->getMaterials();

        //获取当前第一个素材的第一张图片
        $image = "";
        if (!empty($materials)) {
            $images = $materials[0]->getMaterialImages;
            $image = $images[0];
        }

        //返回图片地址
        return $image;
    }
}