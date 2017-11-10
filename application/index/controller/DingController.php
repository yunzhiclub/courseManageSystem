<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Ding;

class DingController extends Controller {

    /**
     * 自动推送钉钉消息方法
     */
    public function push() {

        $ding = new Ding();

        $time = time();
        $time = $time % 86400;

        // 上午
        if ($time <= 600) {

            $message = $ding->getMessage('morning');
            $ding->autoPush($message);
        }
        // 下午
        else if ($time >= 20700 && $time <= 21300) {

            $message = $ding->getMessage('afternoon');
            $ding->autoPush($message);
        }
        // 晚上
        else if ($time >= 35700 && $time <= 36300) {

            $message = $ding->getMessage('night');
            $ding->autoPush($message);
        }
    }
}