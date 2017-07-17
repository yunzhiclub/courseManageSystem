<?php
namespace app\index\model;
use think\Model;
/**
* 周杰
*/
class User extends Model
{
    static public function log($username, $password)
    {
        $map = array('username'  => $username);
        $User = self::get($map);
        // $User要么是一个对象，要么是null。
        if (!is_null($User)) {
            // 验证密码是否正确
            if ($User->getData('password') !== $password) {
                // 用户名密码错误，跳转到登录界面。
                return 2;
            } else {
                // 用户名密码正确，将UserId存session。
                session('username', $User->getData('username'));
                if ($User->getData('power') == 0)
                    return 0;
                else if ($User->getData('power') == 1)
                    return 1;
                else
                    return 2;
            }
            
        } else {
            return 0;
        }
    }
}