<?php

namespace app\index\model;

use think\Model;

/**
* 张喜硕
* 课程类
*/
class Course extends Model
{
    
    public function checkName() {
        if(is_null($this->name)) {
            return false;
        }

        if(sizeof($this->name)>20) {
            return false;
        }

        $Courses = Course::all();

        $Length = sizeof($Courses);

        for($temp = 0 ; $temp < $Length ; $temp ++) {
            if($Courses[$temp]->name == $this->name) {
                return false;
            }
        }

        return true;
    }

}