<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\ALWeek;
class AskLeaveController extends IsloginController
{
    public function index()
    {
    	$Week = new ALWeek(2);
    	$this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
}
