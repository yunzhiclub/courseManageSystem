<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User;

/**
 * 判断是否登录，每个controller继承本controller
 * @author  poshichao 
 */
class IsloginController extends Controller
{
	public function __construct()
    {
        // 调用父类构造函数(必须)
        parent::__construct();

        // 验证用户是否登陆
        if (User::isLogin() === 2) {
        	return $this->error('为获取到用户名信息！', url('Index/index'));
        }

		if (!User::isLogin()) {
		    return $this->error('请先登录', url('Index/index'));
		}

    }
}