<?php

namespace app\index\controller;
use think\Controller;
use think\Request;
use app\index\model\Course;
use app\index\model\Term;
use app\index\model\Coursetime;

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

        if(is_null(Request::instance()->post('Courseid'))){
            $id = Request::instance()->param('id/d');
        }

        else {
            $id = Request::instance()->post('Courseid/d');
        }

        $Course = Course::get($id);

        $this->assign('Course',$Course);

        if(is_null(Request::instance()->post('Termid'))){
            $map = array();

            $map['state'] = 1;

            $Term = Term::get($map);
        }

        else {
            $id = Request::instance()->post('Termid/d');

            $Term = Term::get($id);
        }

        $this->assign('Term',$Term);

        $this->settable($Course,$Term);

        return $this->fetch();
    }

    private function settable(&$Course,&$Term){
        for($row = 1 ; $row <= 5 ; $row ++){

            echo '<tr>';

            for($column = 0 ; $column < 8 ; $column ++){

                if ($column == 0) {
                    echo '<td>' . '第' . $row . '节' . '</td>';
                }

                else {
                    $map = array();
                    $map['day'] = $column;
                    $map['knob'] = $row;

                    $map['course_id'] = $Course->id;
                    $map['term_id'] = $Term->id;

                    $Coursetime = new Coursetime;
                    $Coursetimes = $Coursetime->where($map)->select();

                    $length = sizeof($Coursetimes);

                    echo '<td>';

                        if($length == 0){
                            echo '<a class="btn btn-success" href="add">';
                        }

                        else {
                            echo '<a class="btn btn-default">';

                            for($temp = 0 ; $temp < $length ; $temp ++){
                                echo $Coursetimes[$temp]->week;
                                echo ' ';
                            }

                            echo '</a>';
                        }

                    echo '</td>';
                }
            }

        echo '</tr>';
        }
    }

    public function add(){

        var_dump(Request::instance()->post('courseid'));

        return $this->fetch();
    }
}