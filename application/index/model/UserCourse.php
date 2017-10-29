<?php
namespace app\index\model;

use think\Model;

/**
* 用户课程中间表 朱晨澍
*/
class UserCourse extends Model
{
    //张喜硕 用于判断$id对应的课程是否已经在UserCourse表中被选中
    public function getIsChecked($id){

        $UserCourses = $this->all();
        $Length      = sizeof($UserCourses);

        for ($temp = 0 ; $temp < $Length ; $temp ++) {
            if ($UserCourses[$temp]->course_id == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * 判断用户是否绑定课程
     * @param   $username   用户名
     * @return  bool    false：未绑定  true：已绑定
     * @author  poshichao 
     */
    public function userIsChecked($username)
    {
        // 获取user-course的全部信息
        $UserCourses = $this->all();
        $Length = sizeof($UserCourses);

        // 判断是否出现用户名
        for ($temp = 0 ; $temp < $Length ; $temp ++) {
            if ($UserCourses[$temp]->username == $username) {
                return true;
            }
        }

        return false;

    }
}