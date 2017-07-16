<?php
namespace app\index\model;
use think\Model;
use app\index\model\UserCourse;


class User extends Model
{ 
	 public function Courses()
    {
        return $this->belongsToMany('Course', 'user_course');
    }
	public function getIsChecked(Course &$Course)
    {
    	$username = $this->username;
    	$courseId = (int)$Course->id;
    	$map = array();
    	$map['username'] = $username;
    	$map['course_id'] = $courseId;
    	//有记录，返回true；没记录，返回false
    	$UserCourse = UserCourse::get($map);
    	if (is_null($UserCourse)) {
    		return false;
    	} else {
    		return true;
    	}
    }
      public function UserCourses()
    {
        $username = $this->username;
        $UserCourse = UserCourse::get($username);
        return $UserCourse;
    }
}