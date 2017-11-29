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
    // 定义节次
    static $knobs = [
        '[第一节]',
        '[第二节]',
        '[第三节]',
        '[第四节]',
        '[第五节]'
    ];

    /**
     * 推送钉钉消息
     * updateBy: panjie
     */
    static function pushDingMessage() {
        $hour = (int) date("G");
        $sectionNum = 0;

        // 根据当前的时间，获取节次
        if ($hour >= 7 && $hour < 9) {
            $sectionNum = 1;
        } else if ($hour < 12) {
            $sectionNum = 2;
        } else if ($hour < 15) {
            $sectionNum = 3;
        } else if ($hour < 17) {
            $sectionNum = 4;
        } else if ($hour < 21) {
            $sectionNum = 5;
        }

        // 如果当前
        if ($sectionNum > 0) {
            $message = self::getMessage($sectionNum);
            self::autoPush($message);
        }
    }

    /**
     * 钉钉Hook推送消息方法
     */
    static public function autoPush($message) {

        $webhook = config('hook');

        $data = array (
            'msgtype'  => 'text',
            'text'     => array (
                'content' => $message
            )
        );

        $data_string = json_encode($data);

        $result = self::request_by_curl($webhook, $data_string);

        echo $result;
    }

    /**
     * 官方提供的推送方法
     */
    static public function request_by_curl($remote_server, $post_string) {

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
     * 获取当天某个节次的课程表
     * @param $sectionNum 节次 （1 - 5）
     * @return string
     * updateBy: panjie
     */
    static public function getMessage($sectionNum) {
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

        // 显示本节以后的课表
        $messages = [];
        for (; $sectionNum <= 5; $sectionNum++) {
            $messages = self::putMessage($messages, $users, $current_week, $sectionNum);
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
    static public function putMessage($messages, $users, $week, $knob) {

        array_push($messages, self::$knobs[$knob - 1]);

        foreach ($users as $key => $user) {
            
            $message = self::getState($user, $week, $knob);
            $message = self::dataFormat($key, $user, $message);

            array_push($messages, $message);
        }

        return $messages;
    }

    /**
    * 获取用户状态信息
    */
    static public function getState($user, $week, $knob) {

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
    static public function dataFormat($key, $user, $message) {

        $temp = '' . $key + 1 . '.' . $user->name . ' ' . $message;
        return $temp;
    }

}