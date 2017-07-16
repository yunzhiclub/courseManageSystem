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
    
<<<<<<< HEAD
    function __construct($knob = 0)
    {
        $this->Knob = $knob;
=======
    function __construct($knob = 0 , $course = 0 , $term = 0 , $day = 0)
    {
        $this->Knob = $knob;
        $this->Course = $course;
        $this->Term = $term;
        $this->Day = $day;
>>>>>>> development
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
<<<<<<< HEAD
=======

    public function getWeeks(){
        $weeks = [];
        for($temp = 1 ; $temp <= 20 ; $temp ++) {
            $Week = new Week($temp , $this->Course , $this->Term , $this->Day , $this->Knob);
            array_push($weeks, $Week);
        }

        return $weeks;
    }
>>>>>>> development
}