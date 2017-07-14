<?php
namespace app\controller;

use app\model\Eletivecourse;
use think\Controller;

/**
* 选课管理
*/
class EletivecourseController extends Controller
{
	public function index()
	{
		return $this->fetch();
	}
	public function eletive()
	{
		return $this->fetch();
	}
}
