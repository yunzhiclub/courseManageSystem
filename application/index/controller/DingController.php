<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Ding;

class DingController extends Controller {

    /**
     * 自动推送钉钉消息方法
     */
    public function push() {
        // 直接调用M层的方法
        Ding::pushDingMessage();
        Ding::pushContributionMessage();
    }

    public function pushTest() {
        Ding::pushDingMessage(true);
    }
}