<?php

namespace app\index\model;

use think\Model;

/**
 * 贡献值系统方法类
 * zhangxishuo
 */

class Contribution extends Model
{
    protected $autoWriteTimestamp = true;                    // 设置自动写入时间戳
    protected $updateTime         = false;                   // 不启用更新时间
    protected $createTime         = 'time';                  // 创建时间的字段名为time
    protected static $state       = [                        // 静态数组，用于下文过滤时使用
        'add'   => '增加',
        'minus' => '减少'
    ];

    /**
     * 以下为过滤器方法
     * 使用魔法函数对待显示数据进行处理，充当过滤器
     * zhangxishuo
     */

    /**
     * 处理时间戳
     * zhangxishuo
     */
    public function getTimeAttr($value) {
        return date('Y-m-d H:i:s', $value);                  // 格式化时间戳
    }

    /**
     * 处理贡献值的状态(将正负过滤为增加或减少)
     * zhangxishuo
     */
    public function getStateAttr($value) {
        $message = self::$state['add'];                      // 初始化$message为增加
        if ($value < 0) {                                    // 如果值为负
            $message = self::$state['minus'];                // 将$message设置为减少
            $value = -$value;                                // value值取反
        }
        return $message . $value . '点贡献值';                // 拼接字符串，返回
    }

    /**
     * 以下为与贡献值相关的逻辑处理
     * zhangxishuo
     */

    /**
     * 累计贡献值
     * zhangxishuo
     */
    public static function count($json) {
        $data = json_decode($json);                          // json反序列化
        if (self::isMerged($data)) {                         // 如果该提交被合并
            $name = self::getUsername($data);                // 获取提交代码的用户名
            $num  = self::getNum($data);                     // 获取本次贡献值
            self::revise($name, $num);                       // 修改贡献值
        }
    }

    /**
     * 代码是否合并
     * zhangxishuo
     */
    public static function isMerged($data) {
        if ($data->pull_request->merged) {                   // 如果merged属性为true
            return true;                                     // 返回真
        } else {
            return false;                                    // 返回假
        }
    }

    /**
     * 获取提交代码的贡献值
     * zhangxishuo
     */
    public static function getNum($data) {
        $message = self::getContributeStr($data);            // 获取贡献值相关字符串
        return self::strFilter($message);                    // 从字符串中过滤出贡献值
    }

    /**
     * 过滤字符串，获取贡献值
     * zhangxishuo
     */
    public static function strFilter($message) {
        $action = config('contribute')['action'];            // 获取关键字
        $length = strlen($message);                          // 获取信息长度
        $actLen = strlen($action);                           // 获取关键字长度
        $subLen = $length - $actLen - 1;                     // 计算截取长度
        $str    = substr($message, $actLen, $subLen);        // 截取数字信息
        return self::numFilter($str);                        // 过滤该数字字符串
    }

    /**
     * 过滤数字字符串
     * 去空格同时转化为数字
     * zhangxishuo
     */
    public static function numFilter($str) {
        $str = trim($str);                                   // 去除前后空格
        return (float) $str;                                 // 转化为浮点型数字
    }

    /**
     * 获取提交中与贡献值相关的字符串
     * zhangxishuo
     */
    public static function getContributeStr($data) {
        $message = self::getStr($data);                      // 获取本次合并的所有字符串
        $action  = config('contribute')['action'];           // 获取关键字
        $keyword = config('contribute')['keyword'];          // 获取关键字
        $regular = self::getRegular($action, $keyword);      // 拼接正则表达式
        preg_match($regular, $message, $array);              // 匹配正则
        return $array[0];                                    // 返回匹配的字符串
    }

    /**
     * 获取本次代码合并时提交的所有字符串
     * zhangxishuo
     */
    public static function getStr($data) {
        $url    = $data->repository->commits_url;            // 获取接口格式
        $sha    = $data->pull_request->merge_commit_sha;     // 获取合并时提交的加密码
        $url    = str_replace('{/sha}', '/' . $sha, $url);   // 根据接口格式拼接url
        $header = config('github')['organization'];          // 获取配置中github相关的header信息
        $return = self::curl($url, $header);                 // 访问该url
        $object = json_decode($return);                      // 将结果反序列化
        return $object->commit->message;                     // 返回信息
    }

    /**
     * 根据关键字拼接正则表达式
     * zhangxishuo
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
     * 根据header信息访问url
     * zhangxishuo
     */
    public static function curl($url, $info) {
        $ch     = curl_init();                               // 初始化
        curl_setopt($ch, CURLOPT_URL, $url);                 // 设置url
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');      // 设置方法为get
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent:' . $info));  // 设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      // 设置将信息以字符串返回
        $return = curl_exec($ch);                            // 执行并获取返回值
        curl_close($ch);                                     // 关闭
        return $return;                                      // 返回
    }

    /**
     * 获取用户名
     * zhangxishuo
     */
    public static function getUsername($data) {
        $name = $data->pull_request->user->login;            // 获取用户名
        return $name;
    }

    /**
     * 修改用户的贡献值
     * zhangxishuo
     */
    public static function revise($name, $num) {
        $contStatus = self::countContribution($name, $num);  // Contribution表添加数据
        $userStatus = User::addContribution($name, $num);    // User表添加数据
        if ($contStatus && $userStatus) {                    // 都成功
            return true;                                     // 返回真
        }
        return false;                                        // 返回假
    }

    /**
     * 为用户在Contribution表中保存记录
     * zhangxishuo
     */
    public static function countContribution($name, $num) {
        $contribution = model('Contribution');               // 用助手函数实例化一个对象
        $contribution->username = $name;                     // 设置username
        $contribution->state    = $num;                      // 设置state
        try {
            $contribution->save();                           // 保存
        } catch (\Exception $e) {
            return false;                                    // 抛出异常，返回假
        }
        return true;                                         // 返回真
    }

    /**
     * 保存贡献值
     * zhangxishuo
     */
    public static function saveContribution($request) {
        $name   = $request->param('username');               // 获取用户名
        $action = $request->post('action');                  // 获取增加或者减少的操作
        $number = $request->post('number/f');                // 获取操作贡献值点数
        if ($action === 'minus') {                           // 如果操作为减小
            $number = -$number;                              // 贡献值取负
        }
        return self::revise($name, $number);                 // 进行修改操作
    }

    /**
     * 根据用户名查询相关贡献值记录
     * zhangxishuo
     */
    public static function searchByUsername($name) {
        $pageSize = config('paginate')['list_rows'];         // 获取分页信息
        /* 查询数据，按时间戳逆序排序并分页 */
        $infos = self::where('username', $name)->order('time desc')->paginate($pageSize);
        return $infos;
    }
}
