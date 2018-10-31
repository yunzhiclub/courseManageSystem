<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Ding;
use app\index\model\User;

/**
 * 将选中的人其中的一个人的名字随机推送到钉钉群
 * @author    陈杰
 * @index     随机推送主页面
 * @randomPush随机推送
 * 
 */
class RandompushController extends IsloginController
{
    public function index() {
        $Users = User::getUsualUsers();

        $this->assign('Users', $Users);

        return $this->fetch();
    }

    // 随机推送
    public function randomPush() {
    	// 获取所有已选人的名字
    	$stringArray = Request::instance()->post();

    	// 如果为空，则报错，并返回主页面
    	if (empty($stringArray)) {
    		$this->error('请选择要推送的人', url('index'));
    	}

    	// 随机选择一个人的名字
    	$randomPosition = array_rand($stringArray["user_name"], 1);
    	$randomName = $stringArray["user_name"][$randomPosition];

    	// 向钉钉推送消息
    	$message = '本周随机汇报人是：' . $randomName;
    	Ding::pushRandomUserName($message);

        // 发送成功，返回主页面
    	return $this->success('推送成功', url('index'));
    }
}