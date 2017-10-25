<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/9/25
 * Time: 20:51
 */
namespace app\index\validate;
use think\Validate;

class Plan extends Validate {
    protected $rule = [
        'adult_num' => 'require',
        'child_num' => 'require',
        'currency' => 'require',
        'total_cost' => 'require',
        'last_pay_time' => 'require',
    ];

    protected $message = [
        'adult_num' => '成人数不能为空',
        'child_num' => '儿童数不能为空',
        'currency' => '币种不能为空',
        'total_cost' => '总费用不能为空',
        'last_pay_time' => '最晚付款时间不能为空',
    ];
}