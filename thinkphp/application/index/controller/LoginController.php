<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\User;
use app\index\service\Loginservice;

class LoginController extends Controller
{
	protected $loginService = null;

	//构造函数实例化Loginservice
	function __construct(Request $request = null)
    {
    	 parent::__construct($request);
        //实例化服务层
        $this->loginService = new Loginservice();
    }

	public function index()
	{
		return $this->fetch();
	}

	public function login()
	{
		// 接收信息
		$param = Request::instance();

		// 调用service层方法
		$message = $this->loginService->ifLogin($param);

		// 返回相应信息
		if ($message['status'] === 'success') {
			// 返回登录成功界面
			return $this->success($message['message'], url($message['route']));

		} else {
			// 返回登录失败界面
			return $this->error($message['message'], url($message['route']));
		}		
	}

	public function logout()
	{
		if ($this->loginService->logOut()) {
			return $this->success('注销成功！', url('index'));
		} else {
			return $this->error('注销失败！');
		}
	}
}