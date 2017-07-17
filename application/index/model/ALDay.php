<?php
namespace app\index\model;
use app\index\model\Coursetime;
use app\index\model\Course;
/**
* 周杰
*/
class ALDay
{
	// $konbName;
	// $weekTime;
    // $state;
    // $char;
    // $coursename；
    // $style;

	function __construct($konb , $weekTime , $day)
	{
        $this->konbName = $konb; 
        $this->weekTime = $weekTime;
        $this->Day = $this->makeDay($konb , $weekTime , $day);
    }
    public function makeDay($konb , $weekTime , $day)
    {
        $Coursetime = new Coursetime();
        $coursetime = $Coursetime->where(' week = '.$weekTime.' and knob = '.$konb.' and day = '.$day.' and term_id = 1')->select();
        if(!$coursetime == null)
        {
        $Courseid = $coursetime['course_id'];
        die();
        $Coursetime = get($Courseid);
        $result = $Coursetime->$Coursetimes()->where('username = '.$_SESSION['think']['username'])->select();
        if(!$result == null)
        {
            $Course = new Course();
            $course = $Course->get($Courseid);
            $this->coursename = $course[0]['name'];
            $this->state = 0;
            $this->char = 0;
            $this->style = 'hidden';
        }
        else
        {
            $this->coursename = null;
            $this->state = 0;
            $this->char = 0;
            $this->style = 0;

        }
        }
        else
        {
            $this->coursename = null;
            $this->state = 0;
            $this->char = '请假';
            $this->style = 0;
        }
    }
}