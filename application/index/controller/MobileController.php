<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\User;
use app\index\model\Contribution;

/**
 * 移动端贡献值查看控制器
 * zhangxishuo
 */
class MobileController extends Controller
{
    /**
     * 贡献值-主页
     * zhangxishuo
     */
    public function index() {
        $users = User::getUsualUsers();                      // 获取本系统中状态为正常的用户
        $show  = Contribution::hasRecentContribution();      // 最新消息的new图标是否显示
        $this->assign('users', $users);                      // 传入视图层
        $this->assign('show', $show);                        // 传入视图层
        return $this->fetch();
    }

    /**
     * 贡献值-详情
     * zhangxishuo
     */
    public function detail() {
        $name = $this->request->param('username');           // 获取url中的参数username
        $user = User::get($name);                            // 获取用户
        $size = config('mobile')['list_rows'];               // 获取分页配置
        $info = Contribution::searchByUsername($name, $size);// 查询该用户相关的贡献值记录
        $this->assign('user', $user);                        // 传入视图层
        $this->assign('info', $info);                        // 传入视图层
        return $this->fetch();
    }

    /**
     * 贡献值-最近消息
     * zhangxishuo
     */
    public function recent() {
        $size = config('mobile')['size'];                    // 获取分页配置
        $info = Contribution::getRecentContribution($size);  // 获取最新的贡献值修改信息
        $this->assign('info', $info);                        // 传入视图层
        return $this->fetch();
    }
}
