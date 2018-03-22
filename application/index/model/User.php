<?php

namespace app\index\model;

use think\Model;
use app\index\model\UserCourse;
use app\index\model\Coursetime;
use app\index\model\Leave;

class User extends Model
{
     static $isCourseStatus = "有课";
     static $isLeaveStatus = "请假";
     static $isFreeStatus = "  --  ";

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
        for ($i = 1; $i <= 7; $i++) {
            if ($day == $i)
                $days[$i] = 'selected';
            else
                $days[$i] = null;
        }
        return $days;
    }

    public static function checked($knob)
    {
        $knobs = [];
        for ($i = 1; $i <= 5; $i++) {
            if ($knob == $i)
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
        $startTime = strtotime($result[0]['start_time']) - date('w', strtotime($result[0]['start_time']) - 1) * (24 * 60 * 60);
        $weekTime = ceil((time() - $startTime) / (7 * 24 * 60 * 60));
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


    /**
     * 获取学生的当前状态
     * @param $week 周
     * @param $day 天
     * @param $knob 节
     * @param $termId 周期
     * @return string 状态值
     * @Author panjie
     */
    public function getStateByWeekAndDayAndKnobAndTermId($week, $day, $knob, $termId)
    {
        // 判断是否请假
        if ($this->isLeaved($week, $day, $knob, $termId)) {
            return self::$isLeaveStatus;
        } else if ($this->isCourse($week, $day, $knob, $termId)) {
            return self::$isCourseStatus;
        } else {
            return self::$isFreeStatus;
        }
    }

    /**
     * 是否请假
     * @param $week 周
     * @param $day 天
     * @param $knob 节
     * @param $termId 学期
     * @return bool 请假：是；
     * @author panjie
     */
    protected function isLeaved($week, $day, $knob, $termId)
    {
        $map = [
            'knob' => $knob,
            'week' => $week,
            'day' => $day,
            'term_id' => $termId,
            'username' => $this->username
        ];

        // 检查是否请假
        $leaves = Leave::where($map)->select();
        if ($leaves) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否有课
     * @param $week
     * @param $day
     * @param $knob
     * @param $termId
     * @return bool 有课：是
     * @author panjie
     */
    protected function isCourse($week, $day, $knob, $termId)
    {
        $map = [
            'knob' => $knob,
            'week' => $week,
            'day' => $day,
            'term_id' => $termId,
            'username' => $this->username
        ];


        $list = CourseTimeView::get($map);
        if ($list !== null) {
            return true;
        } else {
            return false;
        }
    }

    // 检查user的状态 澍
    public function CheckedState($week)
    {
        // 现在时间的数组
        $map = [
            'knob' => $this->knob,
            'week' => $week,
            'day' => $this->day,
            'term_id' => $this->term
        ];

        // 检查缺班
        $mapr = [
            'knob' => $this->knob,
            'week' => $week,
            'day' => $this->day,
            'term_id' => $this->term
        ];
        $miss = 0;
        $absent = new Absent;
        $absebts = $absent->where($mapr)->select();
        $absentlength = sizeof($absebts);
        for ($x = 0; $x < $absentlength; $x++) {
            if ($absebts[$x]->username == $this->username) {
                $miss = 1;
            }
        }
        // 检查是否请假
        $leave = new Leave;
        $leaves = $leave->where($map)->select();
        $leavelength = sizeof($leaves);
        $leavec = 0;
        for ($l = 0; $l < $leavelength; $l++) {
            if ($leaves[$l]->username == $this->username) {
                $leavec = 1;
            }
        }
        // 检查是否有课
        $coursetime = new Coursetime;
        $course = $coursetime->where($map)->select();
        $map = ['username' => $this->username];
        $usercourse = new UserCourse;
        $courseids = $usercourse->where($map)->select();
        $usid = sizeof($courseids);
        $ctid = sizeof($course);
        $coursec = 0;
        for ($a = 0; $a < $usid; $a++) {
            for ($b = 0; $b < $ctid; $b++) {
                // var_dump($course[$b]);
                // var_dump($courseids[$a]);
                if ($course[$b]->course_id == $courseids[$a]->course_id) {
                    $coursec = 1;
                }
            }
        }
        // 检查是否加班
        $mapa = [
            'knob' => $this->knob,
            'week' => $week,
            'day' => $this->day,
            'term_id' => $this->term
        ];
        $times = Overtime::where($mapa)->select();

        $worklength = sizeof($times);
        $workc = 0;
        for ($l = 0; $l < $worklength; $l++) {
            if ($times[$l]->username == $this->username) {
                $workc = 1;
            }
        }
        // 检查是否休息
        $rest = 0;
        if ($this->day == 7) {
            $rest = 1;
        }
        // 请假判断
        if ($leavec == 1) {
            return 1;
        }
        // 课程判断
        if ($coursec == 1) {
            return 2;
        }
        // 休息判断
        if ($rest == 1) {
            // 加班判断
            if ($workc == 0) {
                return 4;
            } else {
                return 3;
            }
        } else {
            // 缺班判断
            if ($miss == 0) {
                return 5;
            } else {
                return 6;
            }
        }
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
        $map = array('username' => $username);
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
        $result = $Leave->where('username = "' . $leave->username . '" and term_id = ' . User::getWeek('termId') . ' and week = ' . $leave->week . ' and day = ' . $leave->day . ' and knob = ' . $leave->knob)->select();
        if ($result == null)
            return true;
        else
            return false;
    }

    /*
    * 张喜硕
    * @getUsualUsers获取未被冻结的正常用户
    */
    public static function getUsualUsers()
    {

        $Users = [];
        $tempUsers = User::all();
        $Length = sizeof($tempUsers);

        for ($vol = 0; $vol < $Length; $vol++) {

            if ($tempUsers[$vol]->power == 0) {

                array_push($Users, $tempUsers[$vol]);
            }
        }

        return $Users;
    }

    /*
    * 张喜硕
    * @getSickLeave获取该对象某学期请的病假数
    */
    public function getSickLeave($termId)
    {

        $Leave = new Leave();

        return $Leave->getSickLeave($this->username, $termId);
    }

    /*
    * 张喜硕
    * @getEventLeave获取该对象某学期请的事假数
    */
    public function getEventLeave($termId)
    {

        $Leave = new Leave();

        return $Leave->getEventLeave($this->username, $termId);
    }

    /*
    * 张喜硕
    * @getEventLeave获取该对象某学期的旷课数
    */
    public function getAbsent($termId)
    {

        $Absent = new Absent();

        return $Absent->getAbsent($this->username, $termId);
    }

    /*
    * 张喜硕
    * @getOvertime获取当前对象某学期的加时数
    */
    public function getOvertime($termId)
    {

        $Overtime = new Overtime();

        return $Overtime->getOvertime($this->username, $termId);
    }

    public static function getDay()
    {
        if (date('w') == 0)
            return 7;
        else
            return date('w');
    }

    public static function getAsktime($weekTime, $day, $konb)
    {
        $Term = new Term();
        $result = $Term->get(self::getWeek('termId'));
        $startTime = strtotime($result['start_time']) - date('w', strtotime($result['start_time']) - 1) * (24 * 60 * 60);
        $askTime = $startTime + ($weekTime - 1) * 7 * 24 * 60 * 60 + ($day - 1) * 24 * 60 * 60 + self::knonTime($konb);
        return $askTime;
    }

    public static function knonTime($knob)
    {
        if ($knob == 1)
            return 8 * 60 * 60 + 30 * 60;
        if ($knob == 2)
            return 10 * 60 * 60 + 5 * 60;
        if ($knob == 3)
            return 14 * 60 * 60;
        if ($knob == 4)
            return 16 * 60 * 60;
        if ($knob == 5)
            return 20 * 60 * 60;
    }

    /**
     * 为用户添加贡献值
     * zhangxishuo
     */
    public static function addContribution($username, $contribution) {
        $map['username'] = $username;                   // 定义线索
        $user = self::get($map);                        // 获取用户
        $user->contribution += $contribution;           // 添加贡献值
        try {
            $user->save();                              // 保存
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
