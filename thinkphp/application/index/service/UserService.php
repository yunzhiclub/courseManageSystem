<?php

namespace app\index\service;
use app\index\model\User;

/**
 * Created by PhpStorm.
 * User: zhangxishuo
 * Date: 2017/9/6
 * Time: 11:27
 */

class UserService {
    public function updateUser($param) {

        $message = [];
        $message['message'] = '修改成功';
        $message['status'] = 'success';

        $id = $param->param('userId');
        $user = User::get($id);

        $username = $param->post('username');
        $password = $param->post('password');

        if($user->username == $username && $user->password == $password) {
            $message['message'] = '信息未更改';
            $message['status'] = 'success';
            return $message;
        }

        $user->username = $username;
        $user->password = $password;

        if(!$user->save()) {
            $message['message'] = '修改失败';
            $message['status'] = 'success';
        }

        return $message;
    }
}