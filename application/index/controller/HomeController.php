<?php
namespace app\index\controller;

use app\index\model\Eletivecourse;
use app\index\model\Course;
use app\index\model\User;
use app\index\model\Term;
use app\index\model\UserCourse;
use think\Controller;
use think\Request;
use app\index\model\Week;

/**
* 教师主页 朱晨澍
*/
class HomeController extends Controller
{
	public function index()
	{
		$weeke = (int)Request::instance()->post('week');
		$map = array();
		$map['state'] = 1;
		$term = Term::get($map);
		$this->assign('Term',$term);
		$week = new Week;
		$weeks = $week->WeekDay(strtotime($term->start_time),time());
		
		if($weeke==0){
		$this->assign('week',$weeks);}else{
			$this->assign('week',$weeke);
		}
		return $this->fetch();
	}
}