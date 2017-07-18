<?php
namespace app\index\model;

use think\Model;
use app\index\model\Day;
/**
* 
*/
class Term extends Model
{
	// 学期获得天的的属性 澍
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