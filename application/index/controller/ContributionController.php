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
     * 以下为课表管理系统中使用的方法
     */

    /**
     * 贡献值管理-主页
     * zhangxishuo
     */
    public function index() {
        $users = User::getUsualUsers();                    // 获取正常用户
        $this->assign('users', $users);                    // 传入视图层
        return $this->fetch();
    }

    public function view() {
        $name = $this->request->param('username');
        $user = User::get($name);
        $info = Contribution::searchByUsername($name);
        $this->assign('user', $user);
        $this->assign('info', $info);
        return $this->fetch();
    }

    public function revise() {
        $name = $this->request->param('username');
        $user = User::get($name);
        $this->assign('user', $user);
        return $this->fetch();
    }

    public function save() {
        if (Contribution::saveContribution($this->request)) {
            return $this->success('修改成功', url('contribution/index'));
        } else {
            return $this->success('修改失败', url('contribution/index'));
        }
    }

    /**
     * 以下为对Github提供的接口
     */

    /**
     * 解析Github数据的接口
     * zhangxishuo
     */
    public function interface() {
        $json = file_get_contents('php://input');          // 获取传来的json数据
        Contribution::count($json);                        // 调用count方法计数
    }
}
