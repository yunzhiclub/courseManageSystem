<?php

namespace app\index\model;
/**
* 张喜硕
* 节类
* 构造函数请不要更改
* @getItsWeeks 获取与该节时间相关的20个周对象
* @getCourse 获个周合条件的课程数组
* @getCourse 获取课程数组的长度
* @getCourseWeek 获取课程的上课周次
*/
class Knob
{
    function __construct($knob = 0 , $course = 0 , $term = 0 , $day = 0)
    {
        $this->Knob   = $knob;
        $this->Course = $course;
        $this->Term   = $term;
        $this->Day    = $day;
    }

    public function getCourseLength(){

        $Length = sizeof($this->getCourse());

        return $Length;
    }

    public function getCourseWeek(){
        $Length      = $this->getCourseLength();
        $Coursetimes = $this->getCourse();

        for($temp = 0 ; $temp < $Length ; $temp ++){
            echo $Coursetimes[$temp]->week;
            echo ' ';
        }
    }

    private function getCourse(){
        $map = array();

        $map = [
            'course_id' => $this->Course,
            'term_id'   => $this->Term,
            'day'       => $this->Day,
            'knob'      => $this->Knob
        ];

        $Coursetime  = new Coursetime();
        $Coursetimes = $Coursetime->where($map)->select();

        return $Coursetimes;
    }
    
    public function getItsWeeks(){
        $weeks = [];
        for($temp = 1 ; $temp <= 20 ; $temp ++) {

            $Week = new Week($temp , $this->Course , $this->Term , $this->Day , $this->Knob);
            
            array_push($weeks, $Week);
        }

        return $weeks;
    }
    public function getUsers(){
        $map = array();
        $map['power'] = 0;
        $users = User::all($map);
        $length = sizeof($users);
        for($a = 0;$a < $length;$a++){
            $users[$a]->term = $this->Term;
            $users[$a]->day = $this->Day;
            $users[$a]->knob = $this->Knob;
        }
        return $users;
    }
}