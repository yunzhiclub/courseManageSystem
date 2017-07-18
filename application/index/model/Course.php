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

        if(is_null($CourseName)) {
            return false;
        }

        $Courses = Course::all();

        $Length = sizeof($Courses);

        for($temp = 0 ; $temp < $Length ; $temp ++) {
            if($Courses[$temp]->name == $CourseName) {
                return false;
            }
        }

        return true;
    }

}