<?php

namespace app\index\controller;

use app\index\model\User;
use app\index\service\Loginservice;
use app\index\service\UserService;
use think\Request;

/**
 * Created by PhpStorm.
 * User: zhangxishuo
 * Date: 2017/9/6
 * Time: 10:46
 */

class UserController extends IndexController {

    function __construct() {
        parent::__construct();
        //实例化服务层
        $this->loginService = new Loginservice();
        $this->userService = new UserService();
    }

    public function index() {
        $user = $this->loginService->getCurrentUser();
        $this->assign('user', $user);
        return $this->fetch();
    }

    public function update() {
        $param = Request::instance();
        $message = $this->userService->updateUser($param);
        if($message['status'] == 'success') {
            return $this->success($message['message'], url('user/index'));
        } else {
            return $this->error($message['message'], url('user/index'));
        }
    }
}