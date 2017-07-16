<?php

namespace app\index\model;

use think\Model;

/**
* 张喜硕
* 周类
*/
<<<<<<< HEAD
class Week extends Model
{
    
    
=======
class Week
{

    function __construct($week = 0 , $course = 0 , $term = 0 , $day = 0 , $knob = 0){
        
        $this->Week = $week;
        $this->Course = $course;
        $this->Term = $term;
        $this->Day = $day;
        $this->Knob = $knob;
    }

    public function getIsChecked($num){
        $map = array();
        $map = [
            'course_id' => $this->Course,
            'term_id'   => $this->Term,
            'day'       => $this->Day,
            'knob'      => $this->Knob
        ];

        $Coursetime = new Coursetime();
        $Coursetimes = $Coursetime->where($map)->select();

        $Length = sizeof($Coursetimes);

        for($temp = 0 ; $temp < $Length ; $temp ++){
            if($Coursetimes[$temp]->week == $num){
                return true;
            }
        }

        return false;
    }
>>>>>>> development
}