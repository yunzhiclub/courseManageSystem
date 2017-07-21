<?php
namespace app\index\model;

use think\Model;

/**
* 
*/
class Leave extends Model
{

    public static function checkingLeave($username , $week , $day , $knob)
    {
        $Leave = new Leave();
        $Leave->where('username = "'.$username.'" and term_id = '.User::getWeek('termId').' and week = '.$week.' and day = '.$day.' and knob = '.$knob)->delete();
    }

    /*
    * 张喜硕
    * @getSickLeave获取某学生某学期请的病假数
    */
    public function getSickLeave($username , $termId){

        $map = [
            'username' => $username,
            'term'     => $termId
        ];
    }

    /*
    * 张喜硕
    * @getEventLeave获取某学生某学期请的事假数
    */
    public function getEventLeave($username , $termId){

        $map = [
            'username' => $username,
            'term'     => $termId
        ];
    }
}