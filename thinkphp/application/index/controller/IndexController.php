<?php
namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\service\Loginservice;

class IndexController extends Controller
{
	//构造函数实例化Loginservice
	function __construct(Request $request = null)
    {
    	 parent::__construct($request);

        //实例化服务层
        $this->loginService = new Loginservice();

        // 验证用户是否登陆
        if (!$this->loginService->isLogin(Request::instance())) {
            return $this->error('请先登录！', url('Login/index'));
        }
    }
}
