<?php
namespace app\index\controller;

use think\Request;
use app\index\model\User;
use app\index\model\Term;

/**
* 张喜硕 出勤统计
* 
*/
class WorkmanageController extends IsloginController
{

    public function index(){

        $termId   = Request::instance()->get('termId');
        $Users    = User::getUsualUsers();

        if(is_null($termId)){

            $Term  = Term::getCurrentTerm();
        } else {

            $Term  = Term::get($termId);
        }

        $this->assign('Users' , $Users);
        $this->assign('Term'  , $Term);

        return $this->fetch();
    }
}