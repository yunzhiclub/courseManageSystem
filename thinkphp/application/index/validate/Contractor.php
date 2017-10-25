<?php
namespace app\index\validate;
use think\Validate;

class Contractor extends Validate
{
	protected $rule = [
        'designation'  => 'require|length:2,30',
        'phone' => 'require|length:11',
        'mobile' => 'require|length:11',
        'email' => 'email'
    ];
    
    protected $message = [
        'designation'  =>  '用户名介于2到30之间',
        'phone' => '电话长度应为11',
        'mobile' => '手机号码长度应为11',
        'email' =>  '邮箱格式不正确',
    ];
}