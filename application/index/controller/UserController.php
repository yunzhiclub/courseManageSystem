<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use think\Request;

class UserController extends Controller
{
	/**
	 * 显示用户信息
	 */
	public function index()
	{
		// 获取查询信息
		$name = input('name');
		// 获取查询信息
        $name = Request::instance()->get('name');

        $pageSize = 5;

		// 实例化空对象
		$User = new User;
		$users = $User->where('name' , 'like' , '%' . $name . '%')->paginate($pageSize,false,[
				'query'=>[
					'name' => $name,
				],
			]);

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
	 * 保存信息
	 */
	public function save()
	{
		echo 'this is save';
	}

	/**
	 * 修改用户信息
	 */
	public function edit()
	{
		return $this->fetch();
	}

	/**
	 * 更新信息
	 */
	public function update()
	{
		echo 'this is update';
	}

	/**
	 * 删除学生信息
	 */
	public function delete()
	{
		echo 'this is delete';
	}
}