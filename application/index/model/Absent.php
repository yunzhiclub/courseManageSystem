<?php

namespace app\index\model;

use think\Model;

/**
* 张喜硕 旷课表
* @getAbsent返回某人某学期的旷课数
*/
class Absent extends Model
{
    
    public function getAbsent($username , $termId){

        $map = [
            'username' => $username,
            'term_id'  => $termId
        ];

        $Absents = Absent::where($map)->select();

        return sizeof($Absents);
    }
}