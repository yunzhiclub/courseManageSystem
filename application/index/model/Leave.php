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
}