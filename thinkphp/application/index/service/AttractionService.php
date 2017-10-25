<?php
/**
 * Created by PhpStorm.
 * User: liming
 * Date: 17-9-7
 * Time: 上午8:37
 */

namespace app\index\service;


use app\index\model\Attraction;

class AttractionService {

    public function getNullAttraction($article_id) {
        $attraction = new Attraction();
        $attractionexist = Attraction::where("article_id",$article_id)->select();
        $length = sizeof($attractionexist);
        if ($length!=0) {
            $attraction->date =  date("Y-m-d",strtotime("+1 day",strtotime($attractionexist[$length-1]->date)));

        } else {
            $attraction->date = '';
        }
        $attraction->trip = '';
        $attraction->guide = '';
        $attraction->description = '';
        $attraction->meal = 'breakfast';
        $attraction->car = 'sevenToNineBusinessCar';
        $attraction->id = 0;
        $attraction->hotel_id = '';
        return $attraction;
    }

    public function saveAttraction($param) {
        $message = [];
        $message['status'] = 'success';
        $message['message'] = '保存成功';

        $trip = $param->post('trip');
        $date = $param->post('date');
        $guide = $param->post('guide');
        $description = $param->post('description');
        $meals = $param->post('meal/a');
        $car = $param->post('car');
        $materialIds = $param->post('materialId/a');
        $articleId = $param->param('articleId');
        $hotelId = $param->post('hotelId');


        $Attraction = new Attraction();
        $Attraction->trip = $trip;
        if (empty($date)) {
            $date = "0000-00-0";
        }
        $Attraction->date = $date;
        $Attraction->guide = $guide;
        $Attraction->description = $description;
        if(!is_null($meals)) {
            $Attraction->meal = json_encode($meals);
        }else {
            $Attraction->meal = '';
        }
        $Attraction->car = $car;
        $Attraction->hotel_id = $hotelId;
        $Attraction->article_id = $articleId;
        $Attraction->weight = Attraction::where('article_id', '=', $articleId)->max("weight")+1;
        if(!$Attraction->validate(true)->save()) {
            $message['status'] = 'error';
            $message['message'] = $Attraction->getError();
            return $message;
        }

        if(!is_null($materialIds)) {
            if(!$Attraction->Materials()->saveAll($materialIds)) {
                $message['status'] = 'error';
                $message['message'] = '保存失败';
            }
        }else{
            $message['status'] = 'error';
            $message['message'] = '素材未选择';
        }

        return $message;
    }

    public function updateAttraction($param) {
        $message = [];
        $message['status'] = 'success';
        $message['message'] = '更新成功';

        $attractionId = $param->param('attractionId');
        $trip = $param->post('trip');
        $date = $param->post('date');
        $guide = $param->post('guide');
        $description = $param->post('description');
        $meals = $param->post('meal/a');
        $car = $param->post('car');
        $materialIds = $param->post('materialId/a');
        $articleId = $param->param('articleId/d');
        $hotelId = $param->post('hotelId/d');

        $Attraction = Attraction::get($attractionId);
        $ContrastAttraction = clone $Attraction;

        $Attraction->trip = $trip;
        $Attraction->date = $date;
        $Attraction->guide = $guide;
        $Attraction->description = $description;
        $Attraction->meal = json_encode($meals);
        $Attraction->car = $car;
        $Attraction->hotel_id = $hotelId;
        $Attraction->article_id = $articleId;

        if(json_encode($Attraction) != json_encode($ContrastAttraction)) {
            if(!$Attraction->save()) {
                $message['status'] = 'error';
                $message['message'] = '更新失败';
            }
        }

        $map = ['attraction_id' => $attractionId];
        if(false === $Attraction->AttractionMaterials()->where($map)->delete()) {
            $message['status'] = 'error';
            $message['message'] = '删除原始数据失败';
        }

        if(!is_null($materialIds)) {
            if(!$Attraction->Materials()->saveAll($materialIds)) {
                $message['status'] = 'error';
                $message['message'] = '更新失败';
            }
        }

        return $message;
    }

    public function deleteAttraction($param) {
        $message = [];
        $message['status'] = 'success';
        $message['message'] = '删除成功';

        $attractionId = $param->param('attractionId');
        $Attraction = Attraction::get($attractionId);

        $map = ['attraction_id' => $attractionId];
        if(false === $Attraction->AttractionMaterials()->where($map)->delete()) {
            $message['status'] = 'error';
            $message['message'] = '删除原始数据失败';
        }

        if(!$Attraction->delete()) {
            $message['status'] = 'error';
            $message['message'] = '删除失败';
        }

        return $message;
    }
}