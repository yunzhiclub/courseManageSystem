<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/9/25
 * Time: 21:08
 */

namespace app\index\validate;
use think\Validate;

class Detail extends Validate {
    protected $rule = [
        'adult_unit_price' => 'require',
        'child_unit_price' => 'require',
        'total_price' => 'require',
        'remark' => 'require',
    ];

    protected $message = [
        'adult_unit_price' => '成人单价不能为空',
        'child_unit_price' => '儿童单价不能为空',
        'total_price' => '总价不能为空',
        'remark' => '备注不能为空',
    ];
}