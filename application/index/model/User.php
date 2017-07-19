<?php
namespace app\index\model;
use think\Model;
use app\index\model\Term;
/**
* 周杰
*/
class User extends Model
{
    static public function log($username, $password)
    {
        $map = array('username'  => $username);
        $User = self::get($map);
        // $User要么是一个对象，要么是null。
        if (!is_null($User)) {
            // 验证密码是否正确
            if ($User->getData('password') !== $password) 
            {
                // 用户名密码错误，跳转到登录界面。
                return 2;
            } 
            else 
            {
                // 用户名密码正确，将UserId存session。
                session('username', $User->getData('username'));
                if ($User->getData('power') == 0)
                    return 0;
                else if ($User->getData('power') == 1)
                    return 1;
                else
                    return 2;
            }
            
        } 
        else 
        {
            return 2;
        }
    }

    public static function getCurrentLoginUser()
    {
        return session('username');
    }

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
    public static function getWeek($code)  // $code == 'weekTime':获取周；$code == 'termId'：获取学期id。
    {
        $Term = new Term();
        $result = $Term->where('state = 1')->select();
        $weekTime = ceil((time() - strtotime($result[0]['start_time']))/(7*24*60*60));
        if ($code == 'weekTime')
            return $weekTime;
        if ($code == 'termId')
            return $result[0]['id'];
    }
    public static function selected($day) 
    {
        $days = [];
        for($i=1;$i<=7;$i++)
        {
            if($day == $i)
                $days[$i] = 'selected';
            else
                $days[$i] = null;
        }
        return $days;
    }
    public static function checked($knob) 
    {
        $knobs = [];
        for($i=1;$i<=5;$i++)
        {
            if($knob == $i)
                $knobs[$i] = 'checked';
            else
                $knobs[$i] = null;
        }
        return $knobs;
    }
}