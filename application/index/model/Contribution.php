<?php

namespace app\index\model;

use app\index\input\GithubInput;
use think\db\exception\DataNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Model;

/**
 * 贡献值系统方法类
 * zhangxishuo
 */

class Contribution extends Model
{
    public $name;                                            // 该条贡献值对应的用户的姓名
    protected $autoWriteTimestamp = true;                    // 设置自动写入时间戳
    protected $updateTime         = false;                   // 不启用更新时间
    protected $createTime         = 'time';                  // 创建时间的字段名为time
    protected static $state       = [                        // 静态数组，用于下文过滤时使用
        'add'   => '增加',
        'minus' => '减少'
    ];

    /**
     * @param $number
     * @return bool
     * @throws DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 检测同样的NUMBER是否存在
     */
    private static function checkExistByNumber($number)
    {
        try {
            $map = [];
            $map['number'] = $number;
            $contribution = self::where($map)->find();
            if ($contribution === null) {
                return false;
            }
        } catch (DataNotFoundException $exception) {
            return false;
        }

        return true;
    }


    /**
     * 以下为过滤器方法
     * 使用魔法函数对待显示数据进行处理，充当过滤器
     * zhangxishuo
     */

    /**
     * 将时间戳转化为正常格式的时间
     * @param $value              时间戳
     * @return false|string       转化后的时间
     */
    public function getTimeAttr($value) {
        return date('Y-m-d H:i:s', $value);                  // 格式化时间戳
    }

    /**
     * 处理贡献值的状态(将正负过滤为增加或减少)
     * @param $value         原贡献值的值
     * @return string        拼接后的添加/减少 x贡献值
     */
    public function getStateAttr($value) {
        $message = self::$state['add'];                      // 初始化$message为增加
        if ($value < 0) {                                    // 如果值为负
            $message = self::$state['minus'];                // 将$message设置为减少
            $value   = -$value;                              // value值取反
        }
        return $message . $value . '点贡献值';                // 拼接字符串，返回
    }

    public function getState() {
        if (key_exists('state', $this->data)) {
            return $this->data['state'];
        } else {
            return 0;
        }
    }

    /**
     * 根据Github Json数据累计贡献值
     * @param string $json    Github Json数据
     * @return int|void
     * @throws DbException
     * zhangxishuo
     */
    public static function count($json) {
        $data = json_decode($json);                          // json反序列化
        if (self::isMerged($data)) {                         // 如果该提交被合并
            self::saveAllContribution($data);                // 保存所有贡献值数据
        }
    }

    /**
     * 代码是否被合并
     * @param $data   Github推送对象
     * @return bool   true是 | false否
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
     * 保存所有贡献值信息
     * @param $data           Github推送对象
     * @throws DbException
     * zhangxishuo
     * @return String jsonString
     */
    public static function saveAllContribution($data) {
        $githubInput =  GithubInput::fromJsonObject($data);
        $number = $githubInput->getNumber();
        if (self::checkExistByNumber($number)) {
            return json_encode(['message' => '本次请求已添加', 'code'=> 200]);
        }

        $url = $githubInput->getUrl();
        $title = $githubInput->getTitle();


        $source            = self::getSource($data);         // 获取仓库源
        $user_name         = self::getUsername($data);       // 获取用户名
        $user_contribution = self::getContribution($data);   // 获取贡献值
        $user = User::get($user_name);                       // 获取用户
        $user_contribution *= $user->coefficient;            // 乘以系数
        $user_remark       = 'github';   // 拼接备注



        // 如果本次合并与他人分享贡献值
        if (self::share($data)) {

            $helper_name          = self::getShareName($data);         // 获取帮助人用户名
            $helper_contribution  = self::getShareContribution($helper_name, $user_contribution, $data);  // 获取分享给帮助者的贡献值
            $helper_remark        = self::putHelpContributionRemark($user_name, $helper_contribution);    // 拼接帮助人的备注

            $user_contribution    = $user_contribution - $helper_contribution;  // 减掉当前用户的贡献值
            $user_remark          = self::putShareContributionRemark($user_remark, $helper_name, $helper_contribution);  // 为当前用户不备注拼接分享信息

            self::revise($helper_name, $helper_contribution, $source, $helper_remark, $title, $url, true, $number);  // 修改帮助者贡献值
        }
        self::revise($user_name, $user_contribution, $source, $user_remark, $title, $url, false, $number);  // 修改当前用户贡献值
    }

    /**
     * 获取当前用户贡献值，从Pull Request标题中抓取
     * @param $data              Github推送对象
     * @return float             标题中的贡献值信息
     * zhangxishuo
     */
    public static function getContribution($data) {
        $title = self::getTitle($data);                    // 获取标题
        return self::getContributionInStr($title);         // 获取标题字符串中的数字
    }

    /**
     * 获取分享给他人的贡献值
     * @param $helper_name         帮助者用户名
     * @param $contribution        当前用户贡献值
     * @param $data                Github推送对象
     * @return float|mixed         分享给帮助者的贡献值
     * @throws DbException
     * zhangxishuo
     */
    public static function getShareContribution($helper_name, $contribution, $data) {

        $body = self::getBody($data);                                 // 获取Pull Request主体
        $share_contribution = self::getContributionInStr($body);      // 获取主体字符串中的贡献值

        $helper = User::get($helper_name);                            // 获取帮助者
        $share_contribution *= $helper->coefficient;                  // 累计帮助者获得贡献值

        // 三目运算符，如果分享的贡献值少于当前者的30%，则共享该贡献值，否则共享当前贡献值的30%
        return $share_contribution / $contribution > 0.3 ? $contribution * 0.3 : $share_contribution;
    }

    /**
     * 判断Pull Request是否有与人分享字段
     * @param $data               Github推送对象
     * @return bool               true 是 false 否
     * zhangxishuo
     */
    public static function share($data) {
        $body = self::getBody($data);                                 // 获取Pull Request主体
        if (strpos($body, 'share') === false) {                // 如果字符串中没有share关键字
            return false;                                             // 没有与人分享
        } else {
            return true;
        }
    }

    /**
     * 获取分享/帮助者的用户名
     * @param $data               Github推送对象
     * @return bool|string        帮助者的用户名
     * zhangxishuo
     */
    public static function getShareName($data) {
        $body = self::getBody($data);                                 // 获取Pull Request主体
        return self::getHelperNameInStr($body);                       // 获取主体信息中的帮助者姓名
    }

    /**
     * 修改用户的贡献值
     * @param $name                用户名
     * @param $contribution        贡献值
     * @param $source              来源仓库
     * @param $remark              备注
     * @param string $title
     * @param string $url
     * @param bool $isShare
     * @param null $number
     * @return array
     * zhangxishuo
     */
    public static function revise($name, $contribution, $source, $remark, $title = '', $url = '', $isShare = false, $number = null) {
        $result = [];
        $result['operate'] = true;
        $result['message'] = '保存成功';                              // 初始化返回信息
        try {
            self::countContribution($name, $contribution, $source, $remark, $title, $url, $isShare, $number);   // 修改贡献值详情
            User::addContribution($name, $contribution);                       // 修改用户所有贡献值
        } catch (DbException $e) {
            $result['operate'] = false;
            $result['message'] = $e->getMessage();                             // 捕获异常
        }
        return $result;
    }

    /**
     * 修改贡献值详情
     * @param $name                 用户名
     * @param $num                  贡献值
     * @param $source               来源仓库
     * @param $remark               备注
     * @param string $title
     * @param string $url
     * @param bool $isShare
     * @param null $number
     * @throws DbException zhangxishuo
     */
    public static function countContribution($name, $num, $source, $remark, $title = '', $url = "", $isShare = false, $number = null) {
        $contribution = new self();                                // 新建贡献值对象
        $contribution->username = $name;                           // 设置用户名
        $contribution->state    = $num;                            // 设置贡献值状态
        $contribution->source   = $source;                         // 设置来源仓库
        $contribution->remark   = $remark;                         // 设置备注
        $contribution->url      = $url;                            // 地址
        $contribution->title    = $title;                          // 标题
        $contribution->share    = $isShare;                         // 是否为共享得分
        $contribution->number   = $number;                          // 对应github的序号
        if (false === $contribution->save()) {
            throw new DbException('贡献值保存失败');         // 保存失败，抛出异常
        }
    }

    /**
     * 获取字符串中的用户名
     * share&zhangxishuo 2h
     * @param $str                 标准字符串
     * @return bool|string         标准字符串中的用户名
     * zhangxishuo
     */
    public static function getHelperNameInStr($str) {
        $relevantNameStr = self::matchRelevantNameStr($str);        // 匹配字符串中的有效部分
        return self::subNameInStr($relevantNameStr);                // 截取，获得用户名信息
    }

    /**
     * 获取字符串中的数字贡献值信息
     * @param $str                字符串
     * @return float              字符串中的数字信息
     * zhangxishuo
     */
    public static function getContributionInStr($str) {
        $relevantNumStr = self::matchRelevantNumStr($str);          // 匹配字符串中的有效部分
        return self::subNumInStr($relevantNumStr);                  // 截取，获取贡献值信息
    }

    /**
     * 截取字符串中的用户名信息
     * @param $str                有效字符串
     * @return bool|string        有效字符串中的用户名信息
     * zhangxishuo
     */
    public static function subNameInStr($str) {
        return substr($str, 1, strlen($str) - 2);       // 截取
    }

    /**
     * 截取字符串中的贡献值信息
     * @param $str                有效字符串
     * @return float              有效字符串中的贡献值信息
     * zhangxishuo
     */
    public static function subNumInStr($str) {
        return (float)substr($str, 1, strlen($str) - 2);       // 截取
    }

    /**
     * 匹配字符串中的用户名信息
     * @param $str                字符串
     * @return mixed              有效字符串
     * zhangxishuo
     */
    public static function matchRelevantNameStr($str) {
        $regular = '/&[a-z]+ /i';                              // 拼接正则表达式
        preg_match($regular, $str, $array);          // 匹配
        return $array[0];
    }

    /**
     * 匹配字符串中的贡献值信息
     * @param $str                字符串
     * @return mixed              有效字符串
     * zhangxishuo
     */
    public static function matchRelevantNumStr($str) {
        $regular = '/ ([0-9]|.)+h/i';                          // 拼接正则表达式
        preg_match($regular, $str, $array);          // 匹配
        return $array[0];
    }

    /**
     * 拼接贡献值备注详细信息
     */
    /**
     * 拼接当前用户的Pull Request信息
     * @param $source              源仓库
     * @param $contribution        贡献值
     * @return string              返回备注字符串
     * zhangxishuo
     */
    public static function putGetContributionRemark($source, $contribution) {
        return '从' . $source . '获取' . $contribution . '点贡献值';
    }

    /**
     * 拼接帮助者的贡献值获取信息
     * @param $username            帮助者
     * @param $contribution        贡献值
     * @return string              返回备注字符串
     * zhangxishuo
     */
    public static function putHelpContributionRemark($username, $contribution) {
        return '帮助' . $username . '获得' . $contribution . '点贡献值';
    }

    /**
     * 拼接分享给别人的贡献值信息
     * @param $remark              原备注
     * @param $helper              帮助者
     * @param $contribution        分享贡献值
     * @return string              拼接好的备注
     * zhangxishuo
     */
    public static function putShareContributionRemark($remark, $helper, $contribution) {
        return $remark . ', 分享给' . $helper. ' ' . $contribution . '点贡献值';
    }

    /**
     * 获取Github推送的字符串中的某些基础方法
     */

    /**
     * 获取当前Pull Request的操作用户名
     * @param $data                Github对象
     * @return mixed               用户名
     * zhangxishuo
     */
    public static function getUsername($data) {
        return $data->pull_request->user->login;
    }

    /**
     * 获取当前Pull Request的仓库名
     * @param $data                Github对象
     * @return mixed               仓库名
     * zhangxishuo
     */
    public static function getSource($data) {
        return $data->repository->name;
    }

    /**
     * 获取当前Pull Request的标题信息
     * @param $data                Github对象
     * @return mixed               标题
     * zhangxishuo
     */
    public static function getTitle($data) {
        return $data->pull_request->title;
    }

    /**
     * 获取当前Pull Request的主体信息
     * @param $data                Github对象
     * @return mixed               主体
     * zhangxishuo
     */
    public static function getBody($data) {
        return $data->pull_request->body;
    }

    /**
     * 根据用户名查询相关贡献值记录
     * @param $name
     * @param $pageSize
     * @return \think\paginator\Collection
     * @throws DbException
     * zhangxishuo
     */
    public static function searchByUsername($name, $pageSize) {
        /* 查询数据，按时间戳逆序排序并分页 */
        $infos = self::where('username', $name)->order('time desc')->paginate($pageSize);
        return $infos;
    }
}