<?php

namespace app\index\model;

use think\Model;
use app\index\model\Day;

/**
* 
*/
class Term extends Model
{
	public function getDays(){
        $days = [];
        for($temp = 1 ; $temp <= 7 ; $temp ++) {
            $Day = new Day($temp , 0,$this->id);
            $Day->Day = $temp;
            array_push($days, $Day);
        }

        return $days;
    }
}