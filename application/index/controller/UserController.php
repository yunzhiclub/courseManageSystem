<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;
use think\Request;

class UserController extends Controller
{
	/**
	 * 显示用户信息
	 * @author poshichao
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
	 * @author poshichao
	 */
	public function add()
	{
		return $this->fetch();
	}

	/**
	 * 保存信息
	 * @author poshichao
	 */
	public function save()
	{
		// 接收传入数据
        $postData = Request::instance()->post();    

        // 实例化空对象
        $User = new User();

        // 为对象赋值
        $User->username = $postData['username'];
        $User->name = $postData['name'];
        $User->phone = $postData['phone'];

        // 新增对象至数据表
        $result = $User->save();

        if (!$result) {
        	return $this->error('新增失败:' . $Teacher->getError());
        }

        return  $this->success('用户' . $User->username . '新增成功', url('index'));

	}

	/**
	 * 修改用户信息
	 * @author poshichao
	 */
	public function edit()
	{
		// 获取传入username
        $username = Request::instance()->param('username');
        
        // 判断是否成功接收
        if (is_null($username)) {
            return $this->error('未获取到用户名信息');
        }
        
        // 在User表模型中获取当前记录
        if (null === $User = User::get($username))
        {
            return $this->error('系统未找到username为' . $username . '的记录');
        } 
            
        // 将数据传给V层
        $this->assign('User', $User);

        // 获取封装好的V层内容,并返回
        return $this->fetch();
	}

	/**
	 * 更新信息
	 * @author poshichao
	 */
	public function update()
	{
		// 接收数据
        $username = Request::instance()->post('username');

        // 获取当前对象
        $User = User::get($username);

        if (!is_null($User)) {
        	$User->name = Request::instance()->post('name');
        	$User->phone = Request::instance()->post('phone');
        }
        
        // 依据状态定制提示信息
        if (false === $User->isUpdate(true)->save()) {	
            return $this->error('更新失败' . $User->getError());
        }

        return $this->success('更新成功', url('index'));
	}

	/**
	 * 删除学生信息
	 * @author poshichao
	 */
	public function delete()
	{
        // 获取要删除的username.
        $username = Request::instance()->param('username');


        if (is_null($username)) {
            return $this->error('未获取到username信息');
        }

        // 获取要删除的对象
        $User = User::get($username);

        // 要删除的对象不存在
        if (is_null($User)) {
            return $this->error('不存在username为' . $username . '的用户，删除失败');
        }

        // 删除对象
        if (!$User->delete()) {
            return $this->error('删除失败:' . $User->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('index'));
	}

	/**
	 * 重置密码
	 * @author  poshichao
	 */
	public function resetpassword()
	{
		// 获取重置密码的用户名
		$password = Request::instance()->post('password');
		
		// 获取当前对象
		$User = User::get($password);

		// 写入默认密码
		$User->password = '123';

		// 更新
		if (!$User->save()) {
			return $this->error('重置失败' . $User->getError());
		}

		return $this->success('重置成功，新密码为123', url('index'));
	}
}