<?php
namespace app\index\model;
use think\Model;
use app\index\model\UserCourse;
use app\index\model\Coursetime;

class User extends Model
{ 

    public $week;
    // 关联中间表 澍
	public function Courses()
    {
        return $this->belongsToMany('Course', 'user_course');
    }
    // 检查是否存在数据 澍
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
    // 检查中间表中的数据 澍
    public function UserCourses()
    {
        $username = $this->username;
        $UserCourse = UserCourse::get($username);
        return $UserCourse;
    }
    // 检查user是否有课 澍
    public function CheckedCourse()
    {
        $map = array();
        $map = [

            'week' => $this->week,
            'term_id' => $this->term,
            'day' => $this->day,
            'knob' => $this->knob
        ];
        $coursetime = new Coursetime;

        $course = $coursetime->where($map)->select();
        
        $map = ['username' => $this->username];
        $usercourse = new UserCourse;
        $courseids = $usercourse->where($map)->select();

        $usid = sizeof($courseids);
        $ctid = sizeof($course);
        for($a=0;$a <$usid;$a++){
                for($b=0;$b<$ctid;$b++){
                    if($course[$b]==$courseids[$a]){
                        return true;
                    }
                }
            }
        return false;
    }
    // 检查是否请假 澍
    public function CheckedLeave()
    {
        
    }
}