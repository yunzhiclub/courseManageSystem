<?php
namespace app\index\validate;
use think\Validate;

/**
 * 用户管理验证
 * @author poshichao 
 */
class User extends Validate
{
	protected $rule = [
		'username' => 'require|length:4,25',
		'name' => 'require|length:2,25',
		'phone' => 'phone',
	];
}