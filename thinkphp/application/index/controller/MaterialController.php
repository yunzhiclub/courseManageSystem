<?php
namespace app\index\controller;

use app\index\model\Material;
use think\Request;
use app\index\controller\IndexController;
use app\index\service\Materialservice;
use app\index\filter\Filter;

/**
 * 
 * @authors zhuchenshu
 * @date    2017-09-07 08:52:09
 * @version $Id$
 */

class MaterialController extends IndexController {
	protected $materialService = null;

    //构造函数实例化ArticleService
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        //实例化服务层
        $this->materialService = new Materialservice();
    }
    // 素材管理界面
    public function index() {
    	//取出配置信息
        $pageSize = config('paginate.var_page');
        $materialName = Request::instance()->get('materialName');

        $materials = $this->materialService->searchMaterial($materialName, $pageSize);

        $this->assign('filter', new Filter);
        $this->assign('materials', $materials);
    	return $this->fetch();
    }
    // 添加界面
    public function add() {
        $Material = new Material;

        $Material->id = 0;
        $Material->designation = '';
        $Material->content = '';
        $Material->image = '';
        $Material->area = '';
        $Material->country = '';

        $this->assign('material', $Material);
        $this->assign('images', '');
    	return $this->fetch('edit');
    }

    public function save() {
    	//接受参数
        $param = Request::instance();

        //调用service中的保存方法
        $message =  $this->materialService->materialAdd($param);
    	// 返回保存的数据
    	//返回相应的界面
        if ($message['status'] === 'success') {
            //跳转成功的界面
            $this->success($message['message'], url($message['route']));

        } else {
            //跳转失败的界面
            $this->error($message['message']);
        }
    }
    
    /**
     * 素材删除
     */
    public function delete()
    {
        // 接受参数
        $param = Request::instance();

        // 调用Service层的删除方法
        $message = $this->materialService->deleteMaterial($param);

        // 返回相应的结果
        if ($message['status'] === 'success') {
            // 跳转成功界面
            $this->success($message['message'], url($message['route']));

        } else {
            // 跳转失败界面
            $this->error($message['message'], url($message['route']));
        }
    }

    public function edit() {
        // 接受参数
        $param = Request::instance();
        // 调用service中的编辑方法
        $message =  $this->materialService->materialEdit($param);
        // 传递素材信息到v层
        $this->assign('material', $message['material']);
        $this->assign('images', $message['images']);
        return $this->fetch();
    }

    public function update() {
        $param = Request::instance();
        $message = $this->materialService->materialUpdate($param);

        if ($message['status'] === 'success') {
            $this->success($message['message'], url('material/index'));
        } else {
            $this->error($message['message']);
        }
    }

    public function deleteImage() {
        $param = Request::instance();
        $message = $this->materialService->deleteImage($param);

        //返回相关的消息
        return $message;
    }
}