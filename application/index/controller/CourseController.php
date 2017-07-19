<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
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

        $pageSize   = 5;

        $Course     = new Course();

        // 若传入值不为空则根据传入的CourseName执行查询功能
        if (!empty($CourseName)) {

            $Course->where('name' , 'like' , '%' . $CourseName . '%');
        }

        // 查找，并根据条件分页
        $Courses    = $Course->paginate($pageSize , false , [
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

        $CourseName   = Request::instance()->post('CourseName');
        $Course       = new Course();
        $Course->name = $CourseName;
        
        // 获取传入课程名，验证保存
        if(!$Course->checkName($CourseName)){

            return $this->error('课程格式错误，保存失败');
        }

        if(!$Course->save()){

            return $this->error('保存失败' . $Course->getError());
        }

        return $this->success('保存成功' , url('index'));
    }

    public function delete(){

        $id     = Request::instance()->param('id/d');
        $Course = Course::get($id);

        // 若获取不到对象，弹出错误
        if(is_null($Course)){

            return $this->error('课程不存在' , url('index'));
        }

        $UserCourse = new UserCourse();

        // 若课程已经在UserCourse表中有记录，弹出错误
        if($UserCourse->getIsChecked($id)){

            return $this->error('此课程已经被学生选择，无法删除' , url('index'));
        }

        // 删除失败时，弹出错误
        if(!$Course->delete()){

            return $this->error('删除失败' . $Course->getError());
        }

        return $this->success('删除成功' , url('index'));
    }

    public function inquiry(){

        $id = Request::instance()->param('id/d');

        $Course = Course::get($id);

        // 若URL传入term_id与input框中Termid同时为空时，获取当前学期
        if(is_null(Request::instance()->post('Termid'))&&is_null(Request::instance()->param('term_id/d'))){

            $Term = Term::getCurrentTerm();
        }

        // 若input框中Termid不为空，说明用户执行搜索功能，根据Termid查询相关学期
        else if(!is_null(Request::instance()->post('Termid'))){

            $id   = Request::instance()->post('Termid');
            $Term = Term::get($id);
        }

        // 若URL传入term_id不为空，说明add或update已经执行完成，应跳转到修改课程的学期
        else if(!is_null(Request::instance()->param('term_id/d'))) {

            $id   = Request::instance()->param('term_id/d');
            $Term = Term::get($id);
        }

        // 创建CourseTerm对象，存储课程与学期
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
        $Week   = new Week();
        $Day    = new Day($day);
        $Knob   = new Knob($knob);

        $this->assign('Course' , $Course);
        $this->assign('Term'   , $Term);
        $this->assign('Week'   , $Week);
        $this->assign('Day'    , $Day);
        $this->assign('Knob'   , $Knob);

        return $this->fetch();
    }

    public function save(){
        $Coursetime = new Coursetime();

        $course = Request::instance()->post('course');
        $term   = Request::instance()->post('term');
        $day    = Request::instance()->post('day');
        $knob   = Request::instance()->post('knob');
        $weeks  = Request::instance()->post('week/a');

        $map    = ['name' => $course];
        $Course = Course::get($map);

        $map    = ['name' => $term];
        $Term   = Term::get($map);

        $w      = sizeof($weeks);

        // 循环保存多条数据
        for($temp = 0 ; $temp < $w ; $temp ++){

            $Coursetime = new Coursetime();

            $Coursetime->course_id = $Course->id;
            $Coursetime->term_id   = $Term->id;
            $Coursetime->day       = $day;
            $Coursetime->knob      = $knob;
            $Coursetime->week      = (int)$weeks[$temp];

            if(!$Coursetime->save()){

                return $this->error('保存失败' . $Coursetime->getError());
            }
        }

        return $this->success('保存成功' , url('inquiry' , [
                'id'         =>  $Course->id,
                'term_id'    =>  $Term->id
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
        $Week   = new Week($Knob);

        $this->assign('Course' , $Course);
        $this->assign('Term'   , $Term);
        $this->assign('Day'    , $Day);
        $this->assign('Knob'   , $Knob);
        $this->assign('Week'   , $Week);

        return $this->fetch('add');
    }

    public function update(){

        $course = Request::instance()->post('course');
        $term   = Request::instance()->post('term');
        $day    = Request::instance()->post('day');
        $knob   = Request::instance()->post('knob');
        
        $map    = ['name' => $course];
        $Course = Course::get($map);
        $map    = ['name' => $term];
        $Term   = Term::get($map);

        $map    = array();
        $map    = [
            'course_id' => $Course->id,
            'term_id'   => $Term->id,
            'day'       => $day,
            'knob'      => $knob
        ];

        $Coursetime  = new Coursetime();
        $Coursetimes = $Coursetime->where($map)->select();

        // 原始数据删除失败，弹出错误
        if(!$Coursetime->where($map)->delete()){

            return $this->error('删除原始数据失败' . $Coursetime->getError());
        }

        $weeks  = Request::instance()->post('week/a');
        $w      = sizeof($weeks);

        // 循环保存多条数据
        for($temp = 0 ; $temp < $w ; $temp ++){

            $Coursetime = new Coursetime();

            $Coursetime->course_id = $Course->id;
            $Coursetime->term_id   = $Term->id;
            $Coursetime->day       = $day;
            $Coursetime->knob      = $knob;
            $Coursetime->week      = (int)$weeks[$temp];

            if(!$Coursetime->save()){
                
                return $this->error('保存失败' . $Coursetime->getError());
            }
        }

        return $this->success('保存成功' , url('inquiry' , [
                'id'         =>  $Course->id,
                'term_id'    =>  $Term->id
            ]));
    }
}
