<?php
namespace app\index\controller;

use app\index\model\Eletivecourse;
use app\index\model\Course;
use app\index\model\User;
use app\index\model\Term;
use app\index\model\Absent;
use app\index\model\UserCourse;
use think\Request;
use app\index\model\Week;
use app\index\controller\IsloginController;
/**
* 教师主页
* @author 朱晨澍
* @index   用户主界面
*/
class HomeController extends IsloginController
{
	public function index()
	{
		$weeke = (int)Request::instance()->get('week');
		if($weeke>20){
			return $this->error('输入周次不存在',url('index'));
		}elseif ($weeke<0) {
			return $this->error('输入周次不存在',url('index'));
		}
		$map = array();
		$map['state'] = 1;
		$term = Term::get($map);
		$this->assign('Term',$term);
		$week = new Week;
		$weeks = $week->WeekDay(strtotime($term->start_time),time());
		if($weeke==0){
		$this->assign('week',$weeks);
		}else{
			$this->assign('week',$weeke);
		}
		return $this->fetch();
	}
	public function miss()
	{
		$term = Request::instance()->param('term');
		$week = Request::instance()->param('week');
		$knob = Request::instance()->param('knob');
		$day  = Request::instance()->param('day');
		$username = Request::instance()->param('username');

		$absent = new Absent;
		$absent->term_id = $term;
		$absent->week = $week;
		$absent->knob = $knob;
		$absent->day = $day;
		$absent->username = $username;

		$absent->save();

		if(!$absent->save()){

			return $this->error('写入失败' . $absent->getError());
		}
	}
}