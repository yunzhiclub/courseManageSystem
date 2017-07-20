<?php
namespace app\index\model;
use think\Model;
use app\index\model\UserCourse;
use app\index\model\Coursetime;
use app\index\model\Leave;

class User extends Model
{ 
    public function getleavereason($week)
    {
        $map = [
            'week' => $week,
            'term_id' => $this->term,
            'day' => $this->day,
            'knob' => $this->knob
        ];
        $leave = Leave::get($map);
        return $leave->reason;

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
    public $week;
    // 关联中间表 澍
	public function Courses()
    {
        return $this->belongsToMany('Course', 'user_course');
    }
    // 检查中间表中的数据 澍
    public function UserCourses()
    {
        $username = $this->username;
        $UserCourse = UserCourse::get($username);
        return $UserCourse;
    }
    // 判断用户已选课程 澍
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
    // 检查user是否有课 澍
    public function CheckedCourse($week)
    {
        $map = array();
        $map = [
            'week' => $week,
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
    public function CheckedLeave($week)
    {
        $map = array();
        $map = [
            'week' => $week,
            'term_id' => $this->term,
            'day' => $this->day,
            'knob' => $this->knob
        ];
        $leave = new Leave;
        $leaves = $leave->where($map)->select();
        
        $leavelength = sizeof($leaves);
        
        for($l=0;$l<$leavelength;$l++){
            if($leaves[$l]->username==$this->username){
                return true;
            }
        }
        return false;
    }

    /**
     * 登录
     * @param  [string] $username 用户名
     * @param  [string] $password 密码
     * @return [int]   0:学生; 1:老师; 2:登录失败
     * @author 周杰 
     * @author poshichao  重构
     */
    static public function log($username, $password)
    {
        $map = array('username'  => $username);
        $User = self::get($map);
        // $User要么是一个对象，要么是null。
        if (!is_null($User)) {
            // 验证密码是否正确
            if ($User->getData('password') === $password) {
                // 用户名密码正确，将UserId存session。
                session('username', $User->getData('username'));
                if ($User->getData('power') == 0)
                    return 0;
                else if ($User->getData('power') == 1)
                    return 1;
            } 
        }
        return 2;
    }

    /**
     * 判断用户是否登录
     * @return  bool 登录为true
     * @author  poshichao
     * @author  朱晨澍
     */
    static public function isLogin()
    {
        $username = session('username');
        $user = User::get($username);
        $power = $user->power;
        if(request()->controller() == 'AskLeave'){
            if($power==0){
                return true;
            }else{
                return false;
            }
        }else{
            if($power==1){
                return true;
            }else{
                return false;
            }
        }
    }
    
    public static function getCurrentLoginUser()
    {
        return $_SESSION['think']['username'];
    }
}