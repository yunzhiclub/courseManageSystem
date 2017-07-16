<?php

namespace app\index\model;

/**
* 张喜硕
* 天类
* @getKnobs 获取节
*/
class Day
{
    
    function __construct($day = 0){
        $this->Day = $day;
    }

    public function getKnobs(){
        $Knobs = [];
        for($temp = 1 ; $temp <= 5 ; $temp ++){
            $Knob = new Knob();
            $Knob->Course = $this->Course;
            $Knob->Term = $this->Term;
            $Knob->Day = $this->Day;
            $Knob->Knob = $temp;
            array_push($Knobs, $Knob);
        }

        return $Knobs;
    }
}