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

    public function search($pageSize , $CourseName){
        if (!empty($CourseName)) {

            $this->where('name' , 'like' , '%' . $CourseName . '%');
        }

        $Courses    = $this->paginate($pageSize , false , [
            'query' => [
                'name' => $CourseName,
                'pageSize' => $pageSize
                ],
            ]);

        return $Courses;
    }

    public static function saveCourseTime($course,$term,$day,$knob,$weeks){

        $w = sizeof($weeks);

        for($temp = 0 ; $temp < $w ; $temp ++){

            $Coursetime = new Coursetime();

            $Coursetime->course_id = $course;
            $Coursetime->term_id   = $term;
            $Coursetime->day       = $day;
            $Coursetime->knob      = $knob;
            $Coursetime->week      = (int)$weeks[$temp];

            if(!$Coursetime->save()){

                return false;
            }
        }

        return true;
    }

}