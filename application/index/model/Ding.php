<?php

namespace app\index\model;

use app\index\model\Term;
use app\index\model\User;
use app\index\model\Week;

/**
 * 张喜硕
 * 钉钉推送类
 */

class Ding {

    /**
     * 钉钉Hook推送消息方法
     */
    public function autoPush($message) {

        $webhook = config('hook');

        $data = array (
            'msgtype'  => 'text',
            'text'     => array (
                'content' => $message
            )
        );

        $data_string = json_encode($data);

        $result = $this->request_by_curl($webhook, $data_string);

        echo $result;
    }

    /**
     * 官方提供的推送方法
     */
    public function request_by_curl($remote_server, $post_string) {

        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);
        curl_close($ch);  
                   
        return $data;  
    }

    /**
    * 根据时间获取相应消息
    */
    public function getMessage($timeMsg) {

        $knobs = [
            '[第一节]',
            '[第二节]',
            '[第三节]',
            '[第四节]',
            '[第五节]'
        ];

        $users = User::getUsualUsers();
        $term  = Term::getCurrentTerm();
        $week  = new Week();
        $time  = strtotime($term->start_time);

        $current_day  = User::getDay();
        $current_week = $week->WeekDay($time, time());

        foreach ($users as $key => $user) {
            $user->term = $term->id;
            $user->day  = $current_day;
        }

        $messages = [];

        if ($timeMsg == 'morning') {

            $messages = $this->putMessage($messages, $knobs, $users, $current_week, 1);
            $messages = $this->putMessage($messages, $knobs, $users, $current_week, 2);
        } else if ($timeMsg == 'afternoon') {

            $messages = $this->putMessage($messages, $knobs, $users, $current_week, 3);
            $messages = $this->putMessage($messages, $knobs, $users, $current_week, 4);
        } else if ($timeMsg == 'night') {

            $messages = $this->putMessage($messages, $knobs, $users, $current_week, 5);
        }

        $dingMsg = "";

        foreach ($messages as $key => $message) {

            $dingMsg = $dingMsg . $message . "\n";
        }

        return $dingMsg;
    }

    /**
    * 拼接用户课程状态字符串
    */
    public function putMessage($messages, $knobs, $users, $week, $knob) {

        array_push($messages, $knobs[$knob - 1]);

        foreach ($users as $key => $user) {
            
            $message = $this->getState($user, $week, $knob);
            $message = $this->dataFormat($key, $user, $message);

            array_push($messages, $message);
        }

        return $messages;
    }

    /**
    * 获取用户状态信息
    */
    public function getState($user, $week, $knob) {

        $user->knob = $knob;

        $state = $user->CheckedState($week);

        switch ($state) {
            case 1:
                $message = '请假';
                break;
            
            case 2:
                $message = '有课';
                break;

            case 3:
                $message = '加班';
                break;

            case 4:
                $message = '休息';
                break;

            case 5:
                $message = '无课';
                break;

            case 6:
                $message = '缺班';
                break;
        }

        return $message;
    }

    /**
    * 格式化数据
    */
    public function dataFormat($key, $user, $message) {

        $temp = '' . $key + 1 . '.' . $user->name . ' ' . $message;
        return $temp;
    }

}