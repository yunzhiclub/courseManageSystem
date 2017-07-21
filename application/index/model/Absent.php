<?php

namespace app\index\model;

use think\Model;

/**
* 
*/
class Absent extends Model
{
    
    public function getAbsent($username , $termId){

        $map = [
            'username' => $username,
            'term'     => $termId
        ];

        $Absents = Absent::get($map);

        return sizeof($Absents);
    }
}