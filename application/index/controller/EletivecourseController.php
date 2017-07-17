<?php
namespace app\index\controller;

use app\index\model\Eletivecourse;
use app\index\model\Course;
use app\index\model\User;
use app\index\model\UserCourse;
use think\Controller;
use think\Request;

/**
* 选课管理 朱晨澍
*/
class EletivecourseController extends Controller
{
	public function index()
	{
		return $this->fetch();
	}

    //选课 澍
	public function eletive()
	{
		$name = Request::instance()->post();
		$User = User::get($name);
		if(is_null($User)){
			return $this->error('输入信息不存在');
		}
		$courses = Course::all();
		// var_dump($courses);
		$this->assign('courses', $courses);
		$this->assign('User', $User);
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
			return $this->error('不存在name为' . $id . '的记录');
		}
        // 删除原有信息
        $map = ['username'=>$username];
        if (false === $User->UserCourses()->where($map)->delete()) {
            return $this->error('删除班级课程关联信息发生错误' . $User->UserCourses()->getError());
        }

        // // 增加新增数据，执行添加操作。
         // 利用klass_id这个数组，拼接为包括klass_id和course_id的二维数组。
		if (!is_null($courseIds)) {
			$datas = array();
			foreach ($courseIds as $courseId) {
				$data = array();
				$data['course_id'] = $courseId;
                $data['username'] = $username;     // 此时，由于前面已经执行过数据插入操作，所以可以直接获取到Course对象中的ID值。
                array_push($datas, $data);
            }
            // 利用saveAll()方法，来将二维数据存入数据库。
            if (!empty($datas)) {
            	$UserCourse = new UserCourse;
            	if (!$UserCourse->validate(true)->saveAll($datas)) {
            		return $this->error('课程-班级信息保存错误：' . $UserCourse->getError());
            	}
            }
            return $this->success('更新成功', url('index'));
        }
    }
}
