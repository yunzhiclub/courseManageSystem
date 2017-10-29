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
     * 根据不同的时间节点获取正常用户的状态信息
     */
    public function getMessageByTimenode($timenode) {

        $users = User::getUsualUsers();
        $term  = Term::getCurrentTerm();
        $week  = new Week();
        $currentWeek = $week->WeekDay(strtotime($term->start_time),time());
        $currentDay  = $week->getCurrentDay(strtotime($term->start_time),time());

        foreach ($users as $user) {
            $user->term = $term->id;
            $user->day  = $currentDay;
        }

        $messages = [];

        if ($timenode == 0) {
            // 上午
            array_push($messages, "【第一节】");
            foreach ($users as $key =>  $user) {
                $message = $this->getStateByKnob($user, $currentWeek, 1);
                $message = $this->dataFormat($key, $user, $message);
                array_push($messages, $message);
            }

            array_push($messages, "【第二节】");
            foreach ($users as $key => $user) {
                $message = $this->getStateByKnob($user, $currentWeek, 2);
                $message = $this->dataFormat($key, $user, $message);
                array_push($messages, $message);
            }
        } else if ($timenode == 1) {
            // 下午
            array_push($messages, "【第三节】");
            foreach ($users as $key => $user) {
                $message = $this->getStateByKnob($user, $currentWeek, 3);
                $message = $this->dataFormat($key, $user, $message);
                array_push($messages, $message);
            }
            array_push($messages, "【第四节】");
            foreach ($users as $key => $user) {
                $message = $this->getStateByKnob($user, $currentWeek, 4);
                $message = $this->dataFormat($key, $user, $message);
                array_push($messages, $message);
            }
        } else {
            // 晚上
            array_push($messages, "【第五节】");
            foreach ($users as $key => $user) {
                $message = $this->getStateByKnob($user, $currentWeek, 5);
                $message = $this->dataFormat($key, $user, $message);
                array_push($messages, $message);
            }
        }

        $dingMsg = "";

        foreach ($messages as $key => $message) {
            $dingMsg = $dingMsg . $message . "\n";
        }

        return $dingMsg;
    }

    public function getStateByKnob($user, $week, $knob) {

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

    public function dataFormat($key, $user, $message) {

        $temp = '' . $key + 1 . '.' . $user->name . ' ' . $message;
        return $temp;
    }
}