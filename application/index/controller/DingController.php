<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Ding;

class DingController extends Controller {

    private function pushDing($message) {

        $webhook = "https://oapi.dingtalk.com/robot/send?access_token=99979e34710037a4c4e8cbf7eee40dde748a82b2abb8690f4964e046be5fb5ee";

        $data = array (
            'msgtype'  => 'text',
            'text'     => array (
                'content' => $message
            )
        );

        $data_string = json_encode($data);

        $ding = new Ding();

        $result = $ding->request_by_curl($webhook, $data_string);

        echo $result;
    }

    public function autoPushMsg() {

        $ding = new Ding();

        $time = time();
        $time = $time % 86400;
        if ($time >= 0 && $time <= 600) {
            $message = $ding->getMessageByTimenode(0);
            $this->pushDing($message);
        } else if ($time >= 21000 && $time <= 21600) {
            $message = $ding->getMessageByTimenode(1);
            $this->pushDing($message);
        } else if ($time >= 36000 && $time <= 36600) {
            $message = $ding->getMessageByTimenode(2);
            $this->pushDing($message);
        }
    }
}