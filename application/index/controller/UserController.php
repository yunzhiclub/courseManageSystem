<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;

class UserController extends Controller
{
	/**
	 * 显示用户信息
	 */
	public function index()
	{
		// 声明一个空对象
		$User = new User;
		$users = $User->select();

		// 向v层传递数据
		$this->assign('users',$users);

		// 取回打包好的数据,并返回
		return $this->fetch();		
	}

	/**
	 * 新增用户信息
	 */
	public function add()
	{
		return $this->fetch();
	}

	/**
	 * 修改用户信息
	 */
	public function edit()
	{
		return $this->fetch();
	}
}