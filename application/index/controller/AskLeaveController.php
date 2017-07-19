<?php
namespace app\index\controller;
use app\index\IsloginController;
use app\index\model\ALWeek;
use app\index\model\User;
use app\index\model\Leave;
class AskLeaveController extends IsloginController
{
    public function index()
    {
    	$Week = new ALWeek(User::getWeek('weekTime'),session('username'),User::getWeek('termId'));
    	$this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
    public function query()
    {
        $Week = new ALWeek($_POST['weekTime'],session('username'),User::getWeek('termId'));
        $this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
    public function leave()
    {
        $this->assign('days', User::selected($_GET['day']));
        $this->assign('weekTime', $_GET['weekTime']);
        $this->assign('konbs', User::checked($_GET['konb']));
        return $this->fetch('AskLeave/leave');
    }
    public function checkLeave()
    {
        if ($_POST['weekTime']==null)
            return $this->error('操作失败，未选择周次。', url('index'));
        if (array_key_exists("konbs", $_POST)==null) 
            return $this->error('操作失败，未选择节次。', url('index'));
        foreach ($_POST['konbs'] as $konb) 
        {
            $Leave = new Leave();
            $Leave->week = $_POST['weekTime'];
            $Leave->day = $_POST['day'];
            $Leave->knob = $konb;
            $Leave->term_id = User::getWeek('termId');
            $Leave->username = session('username');
            if (array_key_exists("reason", $_POST)==null)
                $_POST['reason'] = null ;
            $Leave->reason = $_POST['reason'].':'.$_POST['explain'];
            $Leave->save();
        }
        $Week = new ALWeek(User::getWeek('weekTime'),session('username'),User::getWeek('termId'));
        $this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
    public function unLeave()
    {
        $map = ['week'=>$_GET['weekTime'],'day'=>$_GET['day'],'knob'=>$_GET['konb'],'term_id'=>User::getWeek('termId'), 'username'=>session('username')];
        $leave = Leave::get($map);
        if($leave == null)
            return $this->error('未找到相关记录', url('index'));
        $leave->delete();
        $Week = new ALWeek(User::getWeek('weekTime'),session('username'),User::getWeek('termId'));
        $this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
}
