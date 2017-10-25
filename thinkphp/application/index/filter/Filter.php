<?php
/**
 * Created by PhpStorm.
 * User: liming
 * Date: 17-9-21
 * Time: 下午3:03
 */

namespace app\index\filter;


class Filter
{
    // 格式化金额函数
    public function moneyFilter($money) {
        // 强制转化成Int类型，非数字转化成0
        $money = (float)$money;
        if(!$money){
            $money = 0;
        }
        // 格式化的结果为安千位分隔，保存小数点后两位
        $cost= number_format($money,2);
        return $cost;
    }

    // 格式化当前的字符串数字
    public function limitWordNumber($str) {
        $str = strip_tags($str);
        $str = str_replace(' ', '', $str);
        if (mb_strlen($str) < 130) {
            return $str;
        } else {
            return mb_substr($str, 0, 130) . '...';
        }
    }
    public function limitPreviewWordNumber($str,$number) {
        $str = strip_tags($str);
        if (mb_strlen($str) < $number) {
            return $str;
        } else {
            return mb_substr($str, 0, $number) . '...';
        }
    }
}