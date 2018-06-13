<?php

namespace app\index\model;

/**
 * 张喜硕
 * 钉钉推送类
 */
class Ding
{
    // 定义节次
    static $knobs = array(
        '第一节',
        '第二节',
        '第三节',
        '第四节',
        '第五节'
    );

    // 定义星期
    static $days = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    ];

    /**
     * 推送钉钉消息
     * @param $test boolean 是否为测试状态
     * updateBy: panjie
     */
    static function pushDingMessage($test = false)
    {
        $hour = (int)date("G");
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
            // 获取课表信息
            $timetables = self::getTimetablesBySectionNum($sectionNum);

            // 转换为dingding信息推送需要的二维数据
            $dingTimeTable = self::getColumnTimetablesByTimetables($timetables);

            // 进行消息拼接
            $message = self::getDingTimetablesByArray($dingTimeTable);
            if (!$test) {
                self::autoPush($message);
            } else {
                dump($message);
            }
        }
    }

    /**
     * 将数组转换为DINGDING想需要的格式
     * @param $array
     * @return string
     * panjie
     */
    static public function getDingTimetablesByArray($array) {
        $message = '';
        foreach ($array as $row) {
            foreach ($row as $unit) {
                $message .= $unit . '   ';
                if (strlen($unit) === 6) {
                    $message .= '   ';
                }
            }
            $message .= "\n";
        }

        return $message;
    }

    /**
     * 钉钉Hook推送消息方法
     * @param $message string
     */
    static public function autoPush($message)
    {

        $webhook = config('hook');

        $data = array(
            'msgtype' => 'text',
            'text' => array(
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
    static public function request_by_curl($remote_server, $post_string)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * 获取课表
     * 先填充第一行，再第二行，依次填充。最后，将行列进行数据互换
     * @param $timetables [users] => 用户信息 [datas] => 状态信息
     * @return array
     * panjie
     */
    static public function getColumnTimetablesByTimetables($timetables)
    {
        $users = $timetables['users'];

        $rows = [];
        $rows[0][] = "      ";
        foreach ($users as $key => $user) {
            $name = $user->name;
            if (strlen($name === 6)) {
                $name .= '  ';
            }
            $rows[0][$user->username] = $name;
        }

        foreach ($timetables['datas'] as $key => $timetable) {
            $row = [];
            array_push($row, self::$knobs[$key - 1]);

            foreach ($users as $user) {
                $row[$user->username] = $timetable[$user->username];
            }
            array_push($rows, $row);
        }

        return self::flip($rows);
    }

    /**
     * 行列互换
     * 例：
     * 1 2
     * 3 4
     * 互换后：
     * 1 3
     * 2 4
     * @param $arr
     * @return array
     */
    static public function flip($arr)
    {
        $out = array();

        foreach ($arr as $key => $subArr) {
            foreach ($subArr as $subKey => $subValue) {
                $out[$subKey][$key] = $subValue;
            }
        }

        return $out;
    }

    /**
     * 通过传入的节次获取当前的课程表
     * @param $sectionNum int 节次
     * @return array
     * @Author panjie
     */
    static public function getTimetablesBySectionNum($sectionNum)
    {
        // 获取初始化信息
        $users = User::getUsualUsers();
        $week = Week::getCurrentWeekNumber();
        $term = Term::getCurrentTerm();
        $weekDay = date("w") == 0 ? 7 : date("w");
        $timetables = ['users' => $users, 'datas' => []];
        $array = [];

        // 今次获取当天每节课的状态信息
        while ($sectionNum <= 5) {
            $row = [];
            foreach ($users as $key => $user) {
                $status = $user->getStateByWeekAndDayAndKnobAndTermId($week, $weekDay, $sectionNum, $term->id);
                $row[$user->username] = $status;
            }
            $array[$sectionNum] = $row;
            $sectionNum++;
        }

        $timetables['datas'] = $array;

        return $timetables;
    }

    /**
     * 获取当天某个节次的课程表
     * @param $sectionNum 节次 （1 - 5）
     * @return string
     * updateBy: panjie
     */
    static public function getMessage($sectionNum)
    {
        $users = User::getUsualUsers();
        $term = Term::getCurrentTerm();
        $week = new Week();
        $time = strtotime($term->start_time);

        dump($term);
        $current_day = User::getDay();
        $current_week = $week->WeekDay($time, time());

        foreach ($users as $key => $user) {
            $user->term = $term->id;
            $user->day = $current_day;
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
    static public function putMessage($messages, $users, $week, $knob)
    {

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
    static public function getState(User $user, $week, $knob)
    {

        $user->knob = $knob;

        $state = $user->CheckedState($week);

        switch ($state) {
            case 1:
                $message = '请假';
                break;

            case 2:
                $message = User::$isCourseStatus;
                break;

            case 3:
                $message = '加班';
                break;

            case 4:
                $message = '休息';
                break;

            case 5:
                $message = User::$isFreeStatus;
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
    static public function dataFormat($key, $user, $message)
    {

        $temp = '' . $key + 1 . '.' . $user->name . ' ' . $message;
        return $temp;
    }

    /**
     * 钉钉推送贡献值消息
     * zhangxishuo
     */
    public static function pushContributionMessage($test = false) {
        if (self::isPushTime()) {                          // 如果当前时间为推送时间
            $message = self::getContributionMessage();     // 获取贡献值信息
            if (!$test) {
                self::autoPush($message);                  // 如果非测试，直接推送
            } else {
                var_dump($message);                        // 打印数据
            }
        }
    }

    /**
     * 判断是否为推送时间
     * zhangxishuo
     */
    public static function isPushTime() {
        $index    = (int)date('w');                        // 获取星期
        $hour     = (int)date("G");                        // 获取小时
        $weekday  = self::$days[$index];                   // 获取星期几的字符串
        $pushDays = config('contribute')['push'];          // 获取配置
        foreach ($pushDays as $key => $day) {
            if ($weekday === $day && $hour >= 7 && $hour < 9) {
                return true;                               // 如果是相应天并且相应时间，返回真
            }
        }
        return false;                                      // 返回假
    }

    /**
     * 获取贡献值信息
     * zhangxishuo
     */
    public static function getContributionMessage() {
        $users = User::getUsualUsers();                    // 获取状态为正常的用户
        $infos = "姓名     | 贡献值\n";                      // 表头
        foreach ($users as $key => $user) {
            $name = $user->name;                           // 获取姓名
            if (strlen($name) === 6) {                     // 如果名字为两个字
                $name .= "   ";                            // 拼接空格保持对齐
            }
            $infos .= $name . "  |    " . $user->contribution . "\n";   // 拼接信息
        }
        return $infos;                                     // 返回
    }

    /**
     * @return array
     */
    public static function getKnobs()
    {
        return self::$knobs;
    }

    /**
     * @param array $knobs
     */
    public static function setKnobs($knobs)
    {
        self::$knobs = $knobs;
    }
}
