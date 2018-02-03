<?php

namespace app\index\controller;

use think\Controller;
use app\index\model\Contribution;

/**
 * 贡献值系统控制器
 * zhangxishuo
 */

class ContributionController extends Controller {

    public function index() {
        $json = file_get_contents('php://input');          // 获取传来的json数据
        Contribution::count($json);                        // 调用count方法计数
    }
}
