<?php

namespace app\index\model;

/**
* 张喜硕
* 天类
* @getKnobs 获取节
*/
class Day
{
    
<<<<<<< HEAD
    function __construct($day = 0){
        $this->Day = $day;
=======
    function __construct($day = 0 , $course = 0 , $term = 0){
        $this->Day = $day;
        $this->Course = $course;
        $this->Term = $term;
>>>>>>> development
    }

    public function getKnobs(){
        $Knobs = [];
        for($temp = 1 ; $temp <= 5 ; $temp ++){
<<<<<<< HEAD
            $Knob = new Knob();
            $Knob->Course = $this->Course;
            $Knob->Term = $this->Term;
            $Knob->Day = $this->Day;
            $Knob->Knob = $temp;
=======
            $Knob = new Knob($temp , $this->Course , $this->Term , $this->Day);
>>>>>>> development
            array_push($Knobs, $Knob);
        }

        return $Knobs;
    }
}