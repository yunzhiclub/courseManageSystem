<?php

namespace app\index\model;

use think\Model;

/**
 * 贡献值系统方法类
 * zhangxishuo
 */

class Contribution extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'time';
    protected $updateTime = false;
    protected static $state = [
        'add'   => '增加',
        'minus' => '减少'
    ];

    public function getTimeAttr($value) {
        return date('Y-m-d H:i:s', $value);
    }

    public function getStateAttr($value) {
        $message = self::$state['add'];
        if ($value < 0) {
            $message = self::$state['minus'];
            $value = -$value;
        }
        return $message . $value . '点贡献值';
    }

    /**
     * 累计贡献值
     */
    public static function count($json) {
        $data = json_decode($json);              // json反序列化
        if (self::isMerged($data)) {             // 如果该提交被合并
            $name = self::getUsername($data);    // 获取提交代码的用户名
            $num  = self::getNum($data);         // 获取本次贡献值
            self::revise($name, $num);
        }
    }

    /**
     * 代码是否合并
     */
    public static function isMerged($data) {
        if ($data->pull_request->merged) {       // 如果merged属性为true
            return true;                         // 返回真
        } else {
            return false;                        // 返回假
        }
    }

    /**
     * 获取提交代码的贡献值
     */
    public static function getNum($data) {
        $message = self::getContributeStr($data);   // 获取贡献值相关字符串
        $num     = self::strFilter($message);       // 从字符串中过滤出贡献值
        return $num;
    }

    /**
     * 过滤字符串，获取贡献值
     */
    public static function strFilter($message) {
        $action = config('contribute')['action'];         // 获取关键字
        $length     = strlen($message);             // 获取信息长度
        $actLen  = strlen($action);          // 获取关键字长度
        $str        = substr($message, $actLen, $length - $actLen - 1);  // 截取数字信息
        $num        = self::numFilter($str);        // 过滤该数字字符串
        return $num;
    }

    /**
     * 过滤数字字符串
     * 去空格同时转化为数字
     */
    public static function numFilter($str) {
        $str = trim($str);               // 去除前后空格
        $num = (float) $str;             // 转化为浮点型数字
        return $num;
    }

    /**
     * 获取提交中与贡献值相关的字符串
     */
    public static function getContributeStr($data) {
        $message = self::getStr($data);                  // 获取本次合并的所有字符串
        $action  = config('contribute')['action'];                 // 获取关键字
        $keyword = config('contribute')['keyword'];                    // 获取关键字
        $regular = self::getRegular($action, $keyword);  // 拼接正则表达式
        preg_match($regular, $message, $array);             // 匹配正则
        return $array[0];                                   // 返回匹配的字符串
    }

    /**
     * 获取本次代码合并时提交的所有字符串
     */
    public static function getStr($data) {
        $url    = $data->repository->commits_url;           // 获取url
        $sha    = $data->pull_request->merge_commit_sha;    // 获取合并时的提交
        $url    = str_replace('{/sha}', '/' . $sha, $url);  // 拼接字符串
        $header = config('github')['organization'];         // 获取github用户名
        $return = self::curl($url, $header);                  // 访问该url
        $object = json_decode($return);                     // 将结果反序列化
        return $object->commit->message;                    // 返回信息
    }

    /**
     * 根据关键字拼接正则表达式
     */
    public static function getRegular($action, $keyword) {
        /**
         * 拼接正则表达式
         * ([\s]|[^\s])+ : 空白符或非空白符匹配1次以上
         *      i        : 不分区大小写
         */
        $regular = '/' . $action . '([\s]|[^\s])+' . $keyword . '/i';
        return $regular;
    }

    /**
     * 访问github接口
     */
    public static function curl($url, $info) {
        $ch = curl_init();                                    // 初始化
        curl_setopt($ch, CURLOPT_URL, $url);                  // 设置url
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');       // 设置方法为get
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent:' . $info));  // 设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);       // 设置将信息以字符串返回
        $return = curl_exec($ch);                             // 执行并获取返回值
        curl_close($ch);                                      // 关闭
        return $return;
    }

    /**
     * 获取用户名
     */
    public static function getUsername($data) {
        $name = $data->pull_request->user->login;             // 获取github用户名
        return $name;
    }

    public static function revise($name, $num) {
        if (self::countContribution($name, $num) && User::addContribution($name, $num)) {
            return true;
        }
        return false;
    }

    public static function countContribution($name, $num) {
        $contribution = model('Contribution');
        $contribution->username = $name;
        $contribution->state = $num;
        try {
            $contribution->save();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public static function saveContribution($request) {
        $name = $request->param('username');
        $action = $request->post('action');
        $number = $request->post('number/f');
        if ($action === 'minus') {
            $number = -$number;
        }
        return self::revise($name, $number);
    }

    public static function searchByUsername($name) {
        $pageSize = config('paginate')['list_rows'];
        $infos = self::where('username', $name)->order('time desc')->paginate($pageSize);
        return $infos;
    }
}
