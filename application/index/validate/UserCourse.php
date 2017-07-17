<?php
namespace app\index\validate;
use think\Validate;

class UserCourse extends Validate
{
    protected $rule = [
        
        'course_id' => 'require'
    ];
}