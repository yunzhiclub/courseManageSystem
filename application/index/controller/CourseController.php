<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\index\model\Course;

/**
* 课程管理 张喜硕
*/
class CourseController extends Controller
{
    
    public function index(){

        $CourseName = Request::instance()->get('CourseName');

        $pageSize = 5;

        $Course = new Course;

        //查询name字段与$CourseName相似的对象
        if (!empty($CourseName)) {
            $Course->where('name' , 'like' , '%' . $CourseName . '%');
        }

        $Courses = $Course->paginate($pageSize , false , [
            'query' => [
                'name' => $CourseName,
                ],
            ]);

        $this->assign('Courses',$Courses);

        return $this->fetch();
    }

    public function addCourse(){
        
        return $this->fetch();
    }

    public function saveCourse(){

        $CourseName = Request::instance()->post('CourseName');

        $Course = new Course;

        $Course->name = $CourseName;

        if(!$Course->save()){
            return $this->error('Error' . $Course->getError());
        }

        return $this->success('Success' , url('index'));
    }

    public function delete(){

        $id = Request::instance()->param('id/d');

        $Course = Course::get($id);

        if(!$Course->delete()){
            return $this->error('Error' . $Course->getError());
        }

        return $this->success('Success' , url('index'));
    }

    public function inquiry(){
        $Course = new Course;

        $this->assign('Course',$Course);

        return $this->fetch();
    }
}