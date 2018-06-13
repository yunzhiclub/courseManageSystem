<?php
namespace app\index\controller;
use app\index\controller\IsloginController;
use app\index\model\UserCourse;
use app\index\model\User;
use think\Request;

class UserController extends IsloginController
{
	/**
	 * 显示用户信息
	 * @author poshichao
	 */
	public function index()
	{
		// 获取查询信息
        $name = Request::instance()->get('name');
        $size = Request::instance()->get('pagesize');

        if ($size === '' || is_null($size)) {
        	$pageSize = 5;
        } else {
        	$pageSize = $size;
        }
        
		// 实例化空对象
		$User = new User();
		
		$users = $User
				 ->where('name' , 'like' , '%' . $name . '%')
				 ->where('power','<>','1')
				 ->paginate($pageSize,false,[
				 'query'=>[
					'name' 		=> $name,
					'pagesize' 	=> $pageSize,
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
		// 实例化空对象
		$User = new User();

		// 设置默认值
		$User->username = '';
		$User->name = '';
		$User->phone = '';
		$User->coefficient = 1;

		$this->assign('User', $User);

		// 调用edit模板
		return $this->fetch('edit');
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

        // 返回保存结果
        if (!$this->saveUser($User,true)) {
        	return $this->error('新增失败:' . $User->getError());
        }
        	
        return  $this->success('用户' . $User->username . '新增成功!', url('index'));

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
        if (!is_null($username)) {

            // 在User表模型中获取当前记录
        	if ($User = User::get($username)) {
        	
             	// 将数据传给V层
        		$this->assign('User', $User);

        		// 获取封装好的V层内容,并返回
        		return $this->fetch();
        	}
        }
        
        return $this->error('未获取到到用户名信息!');   
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

        // 返回更新结果
        if (false === $this->saveUser($User)) {	
            return $this->error('更新失败!' . $User->getError());
        }

        return $this->success('更新成功!', url('index'));
	}

	/**
	 * 删除学生信息
	 * @author poshichao
	 */
	public function delete()
	{
        // 获取要删除的username.
        $username = Request::instance()->param('username');

        if (!is_null($username)) {

            // 获取要删除的对象
        	$User = User::get($username);

        	// 要删除的对象存在
        	if (!is_null($User)) {

        		// 实例化空对象
        		$UserCourse = new UserCourse();
        		
        		// 判断用户是否绑定课程，绑定就无法删除
        		if ($UserCourse->userIsChecked($username)) {
        			return $this->error('该用户已绑定课程，不能删除！');
        		}

            	// 删除对象
        		if (!$User->delete()) {
            		return $this->error('删除失败:' . $User->getError());
        		}

        		return $this->success('删除成功!', url('index'));
        	}
        }

        return $this->error('未获取到用户名信息!');  
	}

	/**
	 * 重置密码
	 * @author  poshichao
	 */
	public function resetpassword()
	{
		// 获取重置密码的用户名
		$username = Request::instance()->param('username');
		
		if (is_null($username)) {
			return $this->error('未获取到用户名信息！');
		}

		// 获取当前对象
		$User = User::get($username);

		// 写入默认密码
		$User->password = '456';

		// 更新
		if (false === $User->isUpdate(true)->save()) {
			return $this->error('重置失败!' . $User->getError());
		}

		return $this->success('重置成功!新密码为' . $User->password, url('index'));
	}

	/**
	 * 用户冻结
	 * @author poshichao
	 */
	public function freeze()
	{
		// 获取要冻结的用户名
		$username = Request::instance()->param('username');

		if (is_null($username)) {
			return $this->error('未获取到用户名信息！');
		}

		$User = User::get($username);

		// 将用户权限改为冻结
		$User->power = '2';

		// 更新冻结权限，返回更新结果
		if(false === $User->isUpdate(true)->save()) {
			return $this->error('冻结失败！' . $User->getError());
		}

		return $this->success('用户' . $User->username . '成功冻结', url('index'));
	}

	/**
	 * 用户解冻
	 * @author poshichao
	 */
	public function thaw()
	{
		// 获取要解冻的用户名
		$username = Request::instance()->param('username');

		if (is_null($username)) {
			return $this->error('未获取到用户名信息！');
		}

		$User = User::get($username);

		// 将用户权限改为正常
		$User->power = '0';

		// 更新正常状态，返回更新结果
		if (false === $User->isUpdate(true)->save()) {
			return $this->error('解冻失败！');
		}
		return $this->success('用户' . $User->username . '成功解冻', url('index'));
	}

	/**
	 * 对用户保存或更新
	 * @param User &$User  用户
	 * @param bool $isSave 是否为保存操作
	 * @return bool 
	 * @author poshichao
	 */
	private function saveUser(User &$User,$isSave = false)
	{	
		// 写入要更新的数据
		if ($isSave) {
			$User->username = input('post.username');
		}
		$User->name = input('post.name');
		$User->phone = input('post.phone');
		$User->coefficient = input('post.coefficient');

		// 更新或保存
		return $User->validate(true)->save($User->getData());
	}
}