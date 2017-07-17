<?php

namespace app\index\model;

use think\Model;

/**
* 
*/
class UserCourse extends Model
{
    
    public function getIsChecked($id){
        $UserCourses = $this->all();
        $Length = sizeof($UserCourses);
        for($temp = 0 ; $temp < $Length ; $temp ++){
            if($UserCourses[$temp]->course_id == $id){
                return true;
            }
        }
        return false;
    }
}