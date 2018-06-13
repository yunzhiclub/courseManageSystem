<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
class IndexController extends Controller
{
    public function index()
    {
        return $this->fetch('login/index');
    }

    public function login()
    {
    	$User = new User();
    	$power = $User->log($_POST['username'], $_POST['password']);
        if ($power == 0)
        	return $this->success('login success', url('ask_leave/index'));
        else if ($power == 1) 
        	return $this->success('login success', url('home/index'));
        else
        	return $this->error('password incrrect or no right', url('index'));
    }
    public function logout()
    {
        session('username',null);
        return $this->success('logout success', url('index'));
    }
}
