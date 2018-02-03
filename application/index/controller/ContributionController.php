<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\User;
use app\index\model\Contribution;

/**
 * 贡献值系统控制器
 * zhangxishuo
 */

class ContributionController extends Controller {

    /**
     * 贡献值管理-主页
     */
    public function index() {
        $users = User::getUsualUsers();
        $this->assign('users', $users);
        return $this->fetch();
    }

    /**
     * 解析github数据的接口
     */
    public function interface() {
        $json = file_get_contents('php://input');          // 获取传来的json数据
        Contribution::count($json);                        // 调用count方法计数
    }
}
