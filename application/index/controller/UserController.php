<?php
namespace app\index\controller;
use think\Controller;

class UserController extends Controller
{
	/**
	 * 显示用户信息
	 */
	public function index()
	{
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