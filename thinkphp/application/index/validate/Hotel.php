<?php

namespace app\index\validate;
use think\Validate;

/**
 * Created by PhpStorm.
 * User: zhangxishuo
 * Date: 2017/9/25
 * Time: 19:10
 */
class Hotel extends Validate {
    protected $rule = [
        'designation' => 'require',
        'country'     => 'require',
        'city'        => 'require',
    ];

    protected $message = [
        'designation' => '酒店名称不能为空',
        'country'     => '所在国家不能为空',
        'city'        => '所在城市不能为空'
    ];
}