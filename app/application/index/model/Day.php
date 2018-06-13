<?php

namespace app\index\model;

/**
* 张喜硕
* 天类
* 构造函数请不要更改
* @getKnobs 获取节
*/
class Day
{
    
    function __construct($day = 0 , $course = 0 , $term = 0){
        $this->Day    = $day;
        $this->Course = $course;
        $this->Term   = $term;
    }

    public function getKnobs(){
        $Knobs = [];

        for($temp = 1 ; $temp <= 5 ; $temp ++){

            $Knob = new Knob($temp , $this->Course , $this->Term , $this->Day);

            array_push($Knobs, $Knob);
        }

        return $Knobs;
    }
    // 从天获取节 澍
    public function getKnob(){
        $Knobs = [];

        for($temp = 1 ; $temp <= 5 ; $temp ++){

            $Knob = new Knob($temp ,0 , $this->Term , $this->Day);

            array_push($Knobs, $Knob);
        }

        return $Knobs;
    }
}