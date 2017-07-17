<?php
namespace app\index\model;
use think\Model;
use app\index\model\UserCourse;
use app\index\model\Coursetime;
use app\index\model\Leave;

class User extends Model
{ 

    public $week;
    // 关联中间表 澍
	public function Courses()
    {
        return $this->belongsToMany('Course', 'user_course');
    }
    // 检查是否存在数据 澍
	public function getIsChecked(&$Course)
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
                    // var_dump($course[$b]);
                    // var_dump($courseids[$a]);
                    if($course[$b]->course_id==$courseids[$a]->course_id){
                        return true;
                    }
                }
            }
        return false;
    }
    // 检查是否请假 澍
    public function CheckedLeave()
    {
        $map = array();
        $map = [
            'week' => $this->week,
            'term_id' => $this->term,
            'day' => $this->day,
            'knob' => $this->knob
        ];
        $leave = new Leave;
        $leaves = $leave->where($map)->select();
        
        $leavelength = sizeof($leaves);
        
        for($l=0;$l<$leavelength;$l++){
            // var_dump($leaves[$l]->username);
            // var_dump($this->username);
            if($leaves[$l]->username==$this->username){
                return true;
            }
        }
        return false;
    }

    static public function log($username, $password)
    {
        $map = array('username'  => $username);
        $User = self::get($map);
        // $User要么是一个对象，要么是null。
        if (!is_null($User)) {
            // 验证密码是否正确
            if ($User->getData('password') !== $password) {
                // 用户名密码错误，跳转到登录界面。
                return 2;
            } else {
                // 用户名密码正确，将UserId存session。
                session('username', $User->getData('username'));
                if ($User->getData('power') == 0)
                    return 0;
                else if ($User->getData('power') == 1)
                    return 1;
                else
                    return 2;
            }
            
        } else {
            return 2;
        }
    }
}