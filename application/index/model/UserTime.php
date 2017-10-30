<?php
namespace app\index\model;

use think\Model;
use app\index\model\User;
use app\index\model\Knob;
/**
* 用户与时间集合
*/
class UserTime extends Model
{
	 public function UserTime($week){
        $map = array();
        $map['power'] = 0;
        $users = User::all($map);
        $length = sizeof($users);
        $knob = new Knob;
        for($a = 0;$a < $length;$a++){
        	$users[$a]->week = $week;
            $users[$a]->term = $knob->Term;
            $users[$a]->day = $knob->Day;
            $users[$a]->knob = $knob->Knob;
        }
        return $users;
    }
}