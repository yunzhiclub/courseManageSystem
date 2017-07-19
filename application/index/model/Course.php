<?php

namespace app\index\model;

use think\Model;

/**
* 张喜硕
* 课程类
*/
class Course extends Model
{
    
    public function checkName($CourseName) {
        if($CourseName=='') {
            return false;
        }

        $map =['name' => $CourseName];
        $Course = Course::get($map);
        if(!is_null($Course)){
            return false;
        }

        return true;
    }

}