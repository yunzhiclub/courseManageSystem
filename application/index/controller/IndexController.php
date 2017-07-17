<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
class IndexController extends Controller
{
    public function index()
    {
        return $this->fetch('Login/index');
    }

    public function login()
    {
        
    	$User = new User();
    	$power = $User->log($_POST['username'], $_POST['password']);
        if ($power == 0)
        	return $this->success('login success', url('AskLeave/index'));
        else if ($power == 1) 
        	return $this->success('login success', url('Eletivecourse/index'));
        else
        	return $this->error('password incrrect or no right', url('index'));

    }
}
