<?php
namespace app\index\controller;

use app\index\model\Eletivecourse;
use app\index\model\Course;
use app\index\model\User;
use app\index\model\Term;
use app\index\model\UserCourse;
use think\Request;
use app\index\model\Week;
use app\index\controller\IsloginController;
/**
* 选课管理 
* @author 朱晨澍
* @index  选课主界面
* @save   保存选课信息
*/
class EletivecourseController extends IsloginController
{
    //选课 澍
	public function index()
	{
        $save_name = Request::instance()->param('name');
		$name = Request::instance()->post('name');
        if(!is_null($save_name)){
            $map = array();
            $map['name'] = $save_name;
            $User = User::get($map);
            $this->assign('name', $save_name);
        }
		else if($name==''){
			$User = new User;
			$User->username = "";
			$User->name = "";
		}else
		{ 	$this->assign('name', $name);
			$map = array();
			$map['name'] = $name;
			$User = User::get($map);
		}
		if(is_null($User)){
			return $this->error('输入信息不存在',url('index'));
		}
		$courses = Course::all();
		$map = array();
        $map['power'] = 0;
        $users = User::all($map);
		$this->assign('courses', $courses);
		$this->assign('User', $User);
		$this->assign('users', $users);
		return $this->fetch();
	}

	//保存选课信息 澍
	public function save()
	{
        // 获取当前用户名
		$username = Request::instance()->post('name');
        // 获取当前课程信息
		$courseIds = Request::instance()->post('course_id/a');
        // 检查当前用户名是否存在
		if (is_null($User = User::get($username))) {
			return $this->error('不存在name' . $username . '的记录',url('index'));
		}
        // 删除原有信息
        $map = ['username'=>$username];
        if(!is_null($User->UserCourses())){
        	if (false === $User->UserCourses()->where($map)->delete()) {
            return $this->error('删除班级课程关联信息发生错误' . $User->UserCourses()->getError());
        		}	
        }
        $User = User::get($username);
        //  增加新增数据，执行添加操作。
		if (!is_null($courseIds)) {
			$datas = array();
			foreach ($courseIds as $courseId) {
				$data = array();
				$data['course_id'] = $courseId;
                $data['username'] = $username;     
                array_push($datas, $data);
            }
            // 利用saveAll()方法，来将二维数据存入数据库。
            if (!empty($datas)) {
            	$UserCourse = new UserCourse;
            	if (!$UserCourse->validate(true)->saveAll($datas)) {
            		return $this->error('课程-班级信息保存错误：' . $UserCourse->getError());
            	}
            }
            return $this->success('更新成功', url('index?name=' . $User->name));
        }else{
        	return $this->success('更新成功', url('index?name=' . $User->name));
        }
    }
}
