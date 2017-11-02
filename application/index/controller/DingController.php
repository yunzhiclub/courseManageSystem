<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Ding;

class DingController extends Controller {

    /**
     * 自动推送钉钉消息方法
     */
    public function autoPushMsg() {

        $ding = new Ding();

        $time = time();
        $time = $time % 86400;

        // 上午
        if ($time <= 600) {

            $message = $ding->getMessageByTimenode(0);
            $ding->pushDing($message);
        
        }
        // 下午
        else if ($time >= 20700 && $time <= 21300) {

            $message = $ding->getMessageByTimenode(1);
            $ding->pushDing($message);

        }
        // 晚上
        else if ($time >= 35700 && $time <= 36300) {

            $message = $ding->getMessageByTimenode(2);
            $ding->pushDing($message);
        }
    }
}