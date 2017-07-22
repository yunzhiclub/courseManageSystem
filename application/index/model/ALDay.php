<?php
namespace app\index\model;
use app\index\model\Coursetime;
use app\index\model\User_course;
use app\index\model\Course;
use app\index\model\Leave;
use app\index\model\Term;
use app\index\model\Overtime;
/**
* 周杰
*/
class ALDay
{
	// $konb;
	// $weekTime;
    // $color;
    // $char;
    // $coursename；
    // $style;
    // $day;

	function __construct($konb , $weekTime , $day , $userName , $termId)
	{
        $this->termId = $termId;
        $this->userName = $userName;
        $this->konb = $konb; 
        $this->weekTime = $weekTime;
        $this->day = $day;
        $this->Day = $this->makeDay($konb , $weekTime , $day , $userName);
        $this->leave();
        $this->isPastTime();
        $this->addCourse();
    }

    public function makeDay($konb , $weekTime , $day , $userName)
    {
        $Coursetime = new Coursetime();
        $coursetime = $Coursetime->where(' week = '.$weekTime.' and knob = '.$konb.' and day = '.$day.' and term_id = '.$this->termId)->select();
        if (!$coursetime == null)
        {
            $Courseid = $coursetime[0]['course_id'];
            $User_course = new UserCourse();
            $result = $User_course->where('username = "'.$userName.'" and course_id = '.$Courseid)->select();
            if (!$result == null)
            {
                $Course = new Course();
                $course = $Course->get($Courseid);
                $this->coursename = $course['name'];
                $this->color = null;
                $this->char = null;
                $this->style = 'hidden';
                $this->state = null;
                Leave::checkingLeave($this->userName , $this->weekTime , $this->day , $this->konb);
            }
            else
            {
                $this->coursename = null;
                $this->color = 'btn-primary';
                $this->char = '请假';
                $this->style = null;
                $this->state = "/courseManageSystem/public/index.php/index/ask_leave/leave.html?weekTime=".$this->weekTime.'&&day='.$this->day.'&&konb='.$this->konb;
                
            }
        }
        else
        {
            $this->coursename = null;
            $this->color = 'btn-primary';
            $this->char = '请假';
            $this->style = null;
            $this->state = "/courseManageSystem/public/index.php/index/ask_leave/leave.html?weekTime=".$this->weekTime.'&&day='.$this->day.'&&konb='.$this->konb;
           
        }
    }

    public function addCourse() // 放假时间的补课按钮添加出来
    {
        if ($this->day == 7) 
        {
            $this->char = '补课';
            $this->color = 'btn-info';
            $this->state = "/courseManageSystem/public/index.php/index/ask_leave/addCourse.html?weekTime=".$this->weekTime.'&&day='.$this->day.'&&konb='.$this->konb;
            Leave::checkingLeave($this->userName , $this->weekTime , $this->day , $this->konb);
            $this->addedCourse();
        }
        if ($this->day == 6)
        {
            if ($this->konb <= 2)
            {
                $this->char = '补课';
                $this->color = 'btn-info';
                $this->state = "/courseManageSystem/public/index.php/index/ask_leave/addCourse.html?weekTime=".$this->weekTime.'&&day='.$this->day.'&&konb='.$this->konb;
                Leave::checkingLeave($this->userName , $this->weekTime , $this->day , $this->konb);
                $this->addedCourse();
            }
        }
    }

    public function leave()  // 检查是否请假
    {
        $Leave = new Leave();
        $result = $Leave->where('username = "'.$this->userName.'" and week = '.$this->weekTime.' and day = '.$this->day.' and knob = '.$this->konb.' and term_id = '.$this->termId)->select();
        if (!$result == null)
        {
            $this->color = 'btn-warning';
            $this->char = '取消';
            $this->state = '/courseManageSystem/public/index.php/index/ask_leave/unLeave.html?weekTime='.$this->weekTime.'&&day='.$this->day.'&&konb='.$this->konb;
        }
    }
    public function isPastTime()  // 时间过了就不能取消请假
    {
        $Term = new Term();
        $result = $Term->get($this->termId);    
        $startTime = strtotime($result['start_time'])- date('w',strtotime($result['start_time'])-1)*(24*60*60);

        $askTime = $startTime + ($this->weekTime-1)*7*24*60*60 + ($this->day)*24*60*60;
        if (time() > $askTime)
        {
            $this->style = 'hidden';
            if($this->char == '取消')
            {
                $this->color = 'btn-danger';
                $this->state = '#';
                $this->style = null;
            }
            
        }
    }
    public function addedCourse()
    {
        $Overtime = new Overtime();
        $result = $Overtime->where('username = "'.$this->userName.'" and week = '.$this->weekTime.' and day = '.$this->day.' and knob = '.$this->konb.' and term_id = '.$this->termId)->select();
        if (!$result == null)
        {
            $this->char = '取消';
            $this->state = '/courseManageSystem/public/index.php/index/ask_leave/unaddCourse.html?weekTime='.$this->weekTime.'&&day='.$this->day.'&&konb='.$this->konb;
        }
    }
}