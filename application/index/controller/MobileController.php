<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\User;
use app\index\model\Contribution;

class MobileController extends Controller
{
    public function index() {
        $users = User::getUsualUsers();                      // 获取本系统中状态为正常的用户
        $show  = Contribution::hasRecentContribution();
        $this->assign('users', $users);                      // 传入视图层
        $this->assign('show', $show);
        return $this->fetch();
    }

    public function detail() {
        $name = $this->request->param('username');           // 获取url中的参数username
        $user = User::get($name);                            // 获取用户
        $size = config('mobile')['list_rows'];
        $info = Contribution::searchByUsername($name, $size);       // 查询该用户相关的贡献值记录
        $this->assign('user', $user);                        // 传入视图层
        $this->assign('info', $info);                        // 传入视图层
        return $this->fetch();
    }

    public function recent() {
        $size = config('mobile')['size'];
        $info = Contribution::getRecentContribution($size);
        $this->assign('info', $info);
        return $this->fetch();
    }
}