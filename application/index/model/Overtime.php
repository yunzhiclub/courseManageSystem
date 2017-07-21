<?php

namespace app\index\model;

use think\Model;

/**
* 张喜硕
* @getOvertime获取某人某学期的加时数
*/
class Overtime extends Model
{
    
    public function getOvertime($username , $termId){

        $map = [
            'username' => $username,
            'term_id'  => $termId
        ];

        $Overtimes = Overtime::where($map)->select();

        return sizeof($Overtimes);
    }
}