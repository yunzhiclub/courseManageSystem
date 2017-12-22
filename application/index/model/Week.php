<?php

namespace app\index\model;

use think\Model;

/**
* 张喜硕
* 周类
* 构造函数请不要更改
* @getIsChecked用于判断该周次是否已在数据库中存在
* @WeekDay根据当前时间与起始时间时间戳计算当前周数
*/

class Week
{

    function __construct($week = 0 , $course = 0 , $term = 0 , $day = 0 , $knob = 0){
        
        $this->Week   = $week;
        $this->Course = $course;
        $this->Term   = $term;
        $this->Day    = $day;
        $this->Knob   = $knob;
    }

    public function getIsChecked($num){

        $map = array();
        $map = [
            'course_id' => $this->Course,
            'term_id'   => $this->Term,
            'day'       => $this->Day,
            'knob'      => $this->Knob
        ];

        $Coursetime  = new Coursetime();
        $Coursetimes = $Coursetime->where($map)->select();
        $Length      = sizeof($Coursetimes);

        for($temp = 0 ; $temp < $Length ; $temp ++){
            if($Coursetimes[$temp]->week == $num){
                return true;
            }
        }

        return false;
    }

    static public function WeekDay($startTimestamp, $currentTimestamp){

        $TimeInterval = $currentTimestamp - $startTimestamp;

        $DayInterval = $TimeInterval / 86400;

        $Week = (int)($DayInterval / 7) + 1;
        return $Week;
    }

    /**
     * 获取本周是第多少周
     * @author panjie
     */
    static public function getCurrentWeekNumber() {
        $term  = Term::getCurrentTerm();
        $time  = strtotime($term->start_time);
        return self::WeekDay($time, time());
    }
}