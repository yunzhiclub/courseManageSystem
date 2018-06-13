<?php

namespace app\index\controller;

use think\Request;
use app\index\model\Day;
use app\index\model\Week;
use app\index\model\Knob;
use app\index\model\Term;
use app\index\model\Course;
use app\index\model\UserCourse;
use app\index\model\Coursetime;
use app\index\model\CourseTerm;


/**
* 课程管理 张喜硕
* @index      课程管理主页
* @addCourse  添加课程名称
* @saveCourse 保存课程名称
* @delete     删除课程
* @inquiry    查询课程时间
* @add        添加课程时间
* @save       保存课程时间
* @edit       编辑课程时间
* @update     更新课程时间
*/
class CourseController extends IsloginController
{

    public function index(){

        $CourseName = Request::instance()->get('CourseName');
        $getSize    = Request::instance()->get('pageSize');

        if(is_null($getSize)){

            $pageSize   = 5;
        } else {

            $pageSize   = $getSize;
        }

        $Course   = new Course();
        $Courses  = $Course->search($pageSize , $CourseName);

        $this->assign('Courses',$Courses);
        return $this->fetch();
    }

    public function addCourse(){

        $Course       = new Course();
        $Course->name = '';

        $this->assign('Course' , $Course);

        return $this->fetch();
    }

    public function saveCourse(){

        $CourseName   = Request::instance()->post('CourseName');
        $Course       = new Course();
        $Course->name = $CourseName;

        if(!$Course->checkName($CourseName)){

            return $this->error('保存失败');
        }

        if(!$Course->save()){

            return $this->error('保存失败' . $Course->getError());
        }

        return $this->success('保存成功' , url('index'));
    }

    public function editCourse(){

        $id     = Request::instance()->param('id');
        $Course = Course::get($id);

        $this->assign('Course' , $Course);

        return $this->fetch('addcourse');
    }

    public function updateCourse(){

        $id = Request::instance()->param('id');
        $Course = Course::get($id);

        if(!$Course->delete()){
            return $this->error('原课程删除失败，更新失败');
        }

        $CourseName   = Request::instance()->post('CourseName');
        $Course       = new Course();
        $Course->name = $CourseName;
        $Course->id   = $id;

        if(!$Course->checkName($CourseName)){

            return $this->error('更新失败');
        }

        if(!$Course->save()){

            return $this->error('课程保存失败，更新失败' . $Course->getError());
        }

        return $this->success('更新成功' , url('index'));
    }

    public function delete(){

        $id         = Request::instance()->param('id/d');
        $Course     = Course::get($id);
        $UserCourse = new UserCourse();

        if(is_null($Course)){

            return $this->error('课程不存在' , url('index'));
        }

        if($UserCourse->getIsChecked($id)){

            return $this->error('此课程已经被学生选择，无法删除' , url('index'));
        }

        if(!$Course->delete()){

            return $this->error('删除失败' . $Course->getError());
        }

        return $this->success('删除成功' , url('index'));
    }

    public function inquiry(){

        $id     = Request::instance()->param('id/d');
        $Course = Course::get($id);

        if(is_null(Request::instance()->post('Termid'))&&is_null(Request::instance()->param('term_id/d'))) {

            $Term = Term::getCurrentTerm();

        } else if (!is_null(Request::instance()->post('Termid'))) {

            $id   = Request::instance()->post('Termid');
            $Term = Term::get($id);

        } else if (!is_null(Request::instance()->param('term_id/d'))) {

            $id   = Request::instance()->param('term_id/d');
            $Term = Term::get($id);
        }

        $CourseTerm = new CourseTerm($Course->id,$Term->id);

        $this->assign('Course',$Course);
        $this->assign('Term',$Term);
        $this->assign('CourseTerm',$CourseTerm);

        return $this->fetch();
    }

    public function add(){

        $course = Request::instance()->param('course');
        $term   = Request::instance()->param('term');
        $day    = Request::instance()->param('day');
        $knob   = Request::instance()->param('knob');
        
        $map    = ['id' => $course];
        $Course = Course::get($map);
        $map    = ['id' => $term];
        $Term   = Term::get($map);
        $Day    = new Day($day);
        $Knob   = new Knob($knob);

        $CourseTerm = new CourseTerm();

        $this->assign('Course'     , $Course);
        $this->assign('Term'       , $Term);
        $this->assign('Day'        , $Day);
        $this->assign('Knob'       , $Knob);
        $this->assign('CourseTerm' , $CourseTerm);

        return $this->fetch();
    }

    public function save(){

        $course = Request::instance()->param('courseId');
        $term   = Request::instance()->param('termId');
        $day    = Request::instance()->post('day');
        $knob   = Request::instance()->post('knob');
        $weeks  = Request::instance()->post('week/a');

        $Course = Course::get($course);

        if(!Course::saveCourseTime($course,$term,$day,$knob,$weeks)){

            return $this->error('保存失败');
        }

        return $this->success('保存成功' , url('inquiry' , [
                'id'         =>  $course,
                'term_id'    =>  $term
            ]));
    }

    public function edit(){

        $course = Request::instance()->param('course');
        $term   = Request::instance()->param('term');
        $day    = Request::instance()->param('day');
        $knob   = Request::instance()->param('knob');
        
        $map    = ['id' => $course];
        $Course = Course::get($map);
        $map    = ['id' => $term];
        $Term   = Term::get($map);
        $Day    = new Day($day);
        $Knob   = new Knob($knob , $course , $term , $day);

        $CourseTerm = new CourseTerm();

        $this->assign('Course'     , $Course);
        $this->assign('Term'       , $Term);
        $this->assign('Day'        , $Day);
        $this->assign('Knob'       , $Knob);
        $this->assign('CourseTerm' , $CourseTerm);

        return $this->fetch('add');
    }

    public function update(){

        $course = Request::instance()->param('courseId');
        $term   = Request::instance()->param('termId');
        $day    = Request::instance()->post('day');
        $knob   = Request::instance()->post('knob');

        $map    = array();
        $map    = [
            'course_id' => $course,
            'term_id'   => $term,
            'day'       => $day,
            'knob'      => $knob
        ];

        $Coursetime  = new Coursetime();

        if(!$Coursetime->where($map)->delete()){

            return $this->error('删除原始数据失败' . $Coursetime->getError());
        }

        $weeks  = Request::instance()->post('week/a');

        if(!Course::saveCourseTime($course,$term,$day,$knob,$weeks)){

            return $this->error('保存失败');
        }

        return $this->success('保存成功' , url('inquiry' , [
                'id'         =>  $course,
                'term_id'    =>  $term
            ]));
    }
}
