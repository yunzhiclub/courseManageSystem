<?php
namespace app\index\model;
use think\Model;
use app\index\model\UserCourse;
use app\index\model\Coursetime;
use app\index\model\Leave;

class User extends Model
{ 
    // 返回请假理由
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
        $startTime = strtotime($result[0]['start_time'])- date('w',strtotime($result[0]['start_time'])-1)*(24*60*60);
        $weekTime = ceil((time() - $startTime)/(7*24*60*60));
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
            'week'    => $week,
            'term_id' => $this->term,
            'day'     => $this->day,
            'knob'    => $this->knob
        ];
        var_dump($map);
        // 请假
        $leave = new Leave;
        $leaves = $leave->where($map)->select();
        $leavelength = sizeof($leaves);
        
        // 上课
        $coursetime = new Coursetime;
        $course = $coursetime->where($map)->select();
        $map = ['username' => $this->username];
        $usercourse = new UserCourse;
        $courseids = $usercourse->where($map)->select();
        $usid = sizeof($courseids);
        $ctid = sizeof($course);

        // 休息


        // 加班
        // $time = new Overtime;
        $times = Overtime::where($map)->select();
        var_dump($times);
        $worklength = sizeof($times);
        var_dump($worklength);

        // 缺班
        $miss=0;

        // 检查是否请假
        $leavec= 0;
        for($l=0;$l<$leavelength;$l++){
            if($leaves[$l]->username==$this->username){
                $leavec = 1;
            }
        }
        // 检查是否有课
        $coursec = 0;
        for($a=0;$a <$usid;$a++){
                for($b=0;$b<$ctid;$b++){
                    // var_dump($course[$b]);
                    // var_dump($courseids[$a]);
                    if($course[$b]->course_id==$courseids[$a]->course_id){
                        $coursec = 1;
                    }
                }
            }
        // 检查是否加班
        $workc=0;
        for($l=0;$l<$worklength;$l++){
            if($times[$l]->username==$this->username){
                $workc = 1;
            }
        }
        // 检查是否休息
        $rest = 0;
        if($this->day==7){
            $rest = 1;
        }
        // 请假判断
        if($leavec==1){
            return 1;
        }
        // 课程判断
        if($coursec == 1){
            return 2;
        }
        // 休息判断
        if($rest == 1){
            // 加班判断
            if($workc==0){
                return 4;
            }else{
                return 3;
            }
        }else{
            // 缺班判断
            if($miss==0){
                return 5;
            }else{
                return 6;
            }
        }
    }
    // 检查是否请假 澍
    public function CheckedLeave($week)
    {
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
    // 检查是否加班 澍
    public function CheckedWork($week)
    {
        $map = [
            'week' => $week,
            'term' => $this->term,
            'day' => $this->day,
            'knob' => $this->knob
        ];
        $time = new Overtime;
        $times = $time->where($map)->select();
        
        $leavelength = sizeof($times);
        
        for($l=0;$l<$leavelength;$l++){
            if($times[$l]->username==$this->username){
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
        // 获取session中用户名信息
        $username = session('username');

        // session中没有用户名信息
        if (is_null($username)) {
            return 2;
        }

        // 获取数据表中用户名
        $user = User::get($username);

        // 数据表中没有对应用户名信息
        if (is_null($user)) {
            return 2;
        }

        $power = $user->power;
        // 访问用户界面，权限为0，登录
        if (request()->controller() == 'AskLeave') {
            if ($power === 0) {
                return true;
            } else {
                return false;
            }

        // 访问管理员界面，权限为1，登录
        } else {
            if ($power == 1) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    public static function getCurrentLoginUser()
    {
        return $_SESSION['think']['username'];
    }

    public static function isLeave($leave) // 判断是否过请假。
    {
        $Leave = new Leave();
        $result = $Leave->where('username = "'.$leave->username.'" and term_id = '.User::getWeek('termId').' and week = '.$leave->week.' and day = '.$leave->day.' and knob = '.$leave->knob)->select();
        if ($result == null)
            return true;
        else
            return false;
    }   

    /*
    * 张喜硕
    * @getUsualUsers获取未被冻结的正常用户
    */
    public static function getUsualUsers(){

        $Users      = [];
        $tempUsers  = User::all();
        $Length     = sizeof($tempUsers);

        for($vol = 0 ; $vol < $Length ; $vol ++){

            if($tempUsers[$vol]->power == 0){

                array_push($Users , $tempUsers[$vol]);
            }
        }

        return $Users;
    }

    /*
    * 张喜硕
    * @getSickLeave获取该对象某学期请的病假数
    */
    public function getSickLeave($termId){

        $Leave = new Leave();

        return $Leave->getSickLeave($this->username , $termId);
    }

    /*
    * 张喜硕
    * @getEventLeave获取该对象某学期请的事假数
    */
    public function getEventLeave($termId){

        $Leave = new Leave();

        return $Leave->getEventLeave($this->username , $termId);
    }

    /*
    * 张喜硕
    * @getEventLeave获取该对象某学期的旷课数
    */
    public function getAbsent($termId){

        $Absent = new Absent();

        return $Absent->getAbsent($this->username , $termId);
    }

    /*
    * 张喜硕
    * @getOvertime获取当前对象某学期的加时数
    */
    public function getOvertime($termId){

        $Overtime = new Overtime();

        return $Overtime->getOvertime($this->username , $termId);
    }
}