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
    	$map = array('username'  => $_POST['username']);
        echo $_POST['password'];
        $User = new User();
        $User->select();

        // $User要么是一个对象，要么是null。
    }
}
