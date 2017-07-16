<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use app\index\model\Day;
use app\index\model\Week;
use app\index\model\Knob;
use app\index\model\Term;
use app\index\model\Course;
use app\index\model\Coursetime;
use app\index\model\CourseTerm;


/**
* 课程管理 张喜硕
*/
class CourseController extends Controller
{
    
    public function index(){

        $CourseName = Request::instance()->get('CourseName');

        $pageSize   = 5;

        $Course     = new Course();

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

        if(is_null(Request::instance()->post('Courseid'))){
            $id = Request::instance()->param('id/d');
        } else {
            $id = Request::instance()->post('Courseid/d');
        }

        $Course = Course::get($id);

        if(is_null(Request::instance()->post('Termid'))){
            $map = array();

            $map['state'] = 1;

            $Term = Term::get($map);
        } else {
            $id = Request::instance()->post('Termid/d');

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

        $map = array();
        $map['id'] = $course;
        $Course = Course::get($map);
        $this->assign('Course',$Course);

        $map['id'] = $term;
        $Term = Term::get($map);
        $this->assign('Term',$Term);

        $Week = new Week();
        $this->assign('Week',$Week);

        $Day = new Day($day);
        $this->assign('Day',$Day);

        $Knob = new Knob($knob);
        $this->assign('Knob',$Knob);

        return $this->fetch();
    }

    public function save(){
        $Coursetime = new Coursetime();

        $course = Request::instance()->post('course');
        $term   = Request::instance()->post('term');
        $day    = Request::instance()->post('day');
        $knob   = Request::instance()->post('knob');
        $weeks  = Request::instance()->post('week/a');

        $map = array();
        $map['name'] = $course;
        $Course = Course::get($map);

        $map['name'] = $term;
        $Term = Term::get($map);

        $w = sizeof($weeks);

        for($temp = 0 ; $temp < $w ; $temp ++){
            $Coursetime = new Coursetime();
            $Coursetime->course_id = $Course->id;
            $Coursetime->term_id   = $Term->id;
            $Coursetime->day       = $day;
            $Coursetime->knob      = $knob;
            $Coursetime->week      = (int)$weeks[$temp];
            if(!$Coursetime->save()){
                return $this->error('Error' . $Coursetime->getError());
            }
        }

        return $this->success('Success' , url('inquiry'));
    }

    public function edit(){

        $course = Request::instance()->param('course');
        $term   = Request::instance()->param('term');
        $day    = Request::instance()->param('day');
        $knob   = Request::instance()->param('knob');

        $map = array();
        $map['id'] = $course;
        $Course = Course::get($map);
        $this->assign('Course',$Course);

        $map['id'] = $term;
        $Term = Term::get($map);
        $this->assign('Term',$Term);

        $Day = new Day($day);
        $this->assign('Day',$Day);

        $Knob = new Knob($knob);
        $this->assign('Knob',$Knob);

        $Week = new Week();
        $this->assign('Week',$Week);

        $map['course_id'] = $course;
        $map['term_id'] = $term;
        $map['day'] = $day;
        $map['knob'] = $knob;

        $Coursetime = new Coursetime();
        $Coursetimes = $Coursetime->where($map)->select();

        var_dump($Coursetimes);

        return $this->fetch();
    }
}