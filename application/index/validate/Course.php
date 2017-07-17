<?php

namespace app\index\validate;

use think\Validate;

/**
* 
*/
class Course extends Validate
{
    
    protected $rule = [
        'CourseName' => 'require|length:1,20'
    ];
}