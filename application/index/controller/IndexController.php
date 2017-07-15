<?php
namespace app\index\controller;
use think\Controller;
use think\model\User;
class IndexController extends Controller
{
    public function index()
    {
        return $this->fetch('Login/index');
    }
    public function login()
    {
    	$map = array('username'  => $_POST['username']);
        $User = User::get($map);
        // $User要么是一个对象，要么是null。
        if (!is_null($User)) {
            // 验证密码是否正确
            if ($User->getData('password') !== $postData['password']) {
                // 用户名密码错误，跳转到登录界面。
                return $this->error('password incrrect', url('index'));
            } else {
                // 用户名密码正确，将UserId存session。
                //session('name', $User->getData('name'));
                return $this->success('login success', url('AskLeave/index'));
            }
            
        } else {
            // 用户名不存在，跳转到登录界面。
            return $this->error('username not exist', url('index'));
        }
    }
}
