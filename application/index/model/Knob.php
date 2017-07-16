<?php

namespace app\index\model;

/**
* 张喜硕
* 节类
* @getCourse 获取符合条件的课程数组
* @getCourse 获取课程数组的长度
* @getCourseWeek 获取课程的上课周次
*/
class Knob
{
    
    function __construct($knob = 0)
    {
        $this->Knob = $knob;
    }

    public function getCourseLength(){

        $Length = sizeof($this->getCourse());

        return $Length;
    }

    public function getCourseWeek(){
        $Length = $this->getCourseLength();
        
        $Coursetimes = $this->getCourse();

        for($temp = 0 ; $temp < $Length ; $temp ++){
            echo $Coursetimes[$temp]->week;
            echo ' ';
        }
    }

    private function getCourse(){
        $map = array();
        $map['course_id'] = $this->Course;
        $map['term_id'] = $this->Term;
        $map['day'] = $this->Day;
        $map['knob'] = $this->Knob;

        $Coursetime = new Coursetime();
        $Coursetimes = $Coursetime->where($map)->select();

        return $Coursetimes;
    }
}