<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Ding;

/**
 * 钉钉自动推送
 * zhangxishuo
 */
class DingController extends Controller {

    /**
     * 自动推送钉钉消息方法
     * zhangxishuo
     */
    public function push() {
        Ding::pushDingMessage();                        // 直接调用M层的方法
        Ding::pushContributionMessage();                // 直接调用M层的方法
    }

    /**
     * 推送方法测试
     * zhangxishuo
     */
    public function pushTest() {
        Ding::pushDingMessage(true);
        Ding::pushContributionMessage(true);
    }
}
