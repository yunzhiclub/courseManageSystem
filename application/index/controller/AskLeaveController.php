<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
class AskLeaveController extends Controller
{
    public function index()
    {
        return $this->fetch('AskLeave/index');
    }
}
