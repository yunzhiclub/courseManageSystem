<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 2017/9/25
 * Time: 16:51
 */
namespace app\index\validate;
use think\Validate;

class Material extends Validate {
    protected $rule = [
        'designation' => 'require',
        'area' => 'require',
        'country' => 'require',
        'content' => 'require',
        'images' => 'require',
    ];

    protected $message = [
        'designation' => '名称不能为空',
        'area' => '地区不能为空',
        'country' => '国家不能为空',
        'content' => '描述不能为空',
        'images' => '图片未上传',
    ];
}