<?php

namespace app\index\model;

use think\Model;

/**
* 张喜硕
* 课程时间类
*/
class Coursetime extends Model
{
    public function Coursetimes()
    {
    	return $this->belongsToMany('user',  config('database.prefix') . 'user_course');
    }

}