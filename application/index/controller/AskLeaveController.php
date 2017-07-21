<?php
namespace app\index\controller;
use app\index\controller\IsloginController;
use app\index\model\ALWeek;
use think\Request;
use app\index\model\User;
use app\index\model\Leave;

class AskLeaveController extends IsloginController
{
    public function index()
    {
    	$Week = new ALWeek(User::getWeek('weekTime'),User::getCurrentLoginUser(),User::getWeek('termId'));
    	$this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
    public function query()
    {
        $postData = Request::instance()->post();
        $Week = new ALWeek($postData['weekTime'],User::getCurrentLoginUser(),User::getWeek('termId'));
        $this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
    public function leave()
    {
        $getData = Request::instance()->get();
        $this->assign('days', User::selected($getData['day']));
        $this->assign('weekTime', $getData['weekTime']);
        $this->assign('konbs', User::checked($getData['konb']));
        return $this->fetch('AskLeave/leave');
    }
    public function checkLeave()
    {
        $postData = Request::instance()->post();
        if ($postData['weekTime']==null)
            return $this->error('操作失败，未选择周次。', url('index'));
        if (array_key_exists("konbs", $postData)==null) 
            return $this->error('操作失败，未选择节次。', url('index'));
        foreach ($postData['konbs'] as $konb) 
        {
            $Leave = new Leave();
            $Leave->week = $postData['weekTime'];
            $Leave->day = $postData['day'];
            $Leave->knob = $konb;
            $Leave->term_id = User::getWeek('termId');
            $Leave->username = User::getCurrentLoginUser();
            if (array_key_exists("reason", $postData)==null)
                $postData['reason'] = null ;
            $Leave->reason = $postData['reason'].':'.$postData['explain'];
            if (User::isLeave($Leave))
            $Leave->save();
        }
        $Week = new ALWeek($postData['weekTime'],User::getCurrentLoginUser(),User::getWeek('termId'));
        $this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
    public function unLeave()
    {
        $getData = Request::instance()->get();
        $map = ['week'=>$getData['weekTime'],'day'=>$getData['day'],'knob'=>$getData['konb'],'term_id'=>User::getWeek('termId'), 'username'=>User::getCurrentLoginUser()];
        $leave = Leave::get($map);
        if($leave == null)
            return $this->error('未找到相关记录', url('index'));
        $leave->delete();
        $Week = new ALWeek($getData['weekTime'],User::getCurrentLoginUser(),User::getWeek('termId'));
        $this->assign('ALWeek', $Week);
        return $this->fetch('AskLeave/index');
    }
}
