<?php
// 该文件位于app\index\ocntroller目录下
namespace app\index\controller;
use think\Controller;  // 用于与V层进行数据传递
use app\index\model\Term;  // 学期模型
use think\Request;


/**
 * 学期管理，继承think\Controller后，就可以利用V层对数据进行打包了。
 */
class TermController extends Controller
{

	// 显示学期数据
	public function index()
	{
		// 每页显示5条数据
        $pageSize = 5; 

        // 实例化Teacher
        $Term = new Term; 

        // 调用分页
        $terms = $Term->paginate($pageSize);

        // 向V层传数据
        $this->assign('terms', $terms);
        // 取回打包后的数据
        $htmls = $this->fetch();

        // 将数据返回给用户
        return $htmls;
	}


	// 向表中添加数据
    public function add()
    {
        $htmls = $this->fetch();
        return $htmls; 

    }


	// 插入前期相关内容
	public function insert()
	{
		// 接收传入数据
        $postData = Request::instance()->post();   

        // 实例化Teacher空对象
        $Term = new Term();

       
        // 为对象赋值
        $Term->name = $postData['name'];
       
        $Term->start_time = $postData['start_time'];
       
        $Term->end_time = $postData['end_time'];
       // $Term->state = $postData['state'];
        

        // 新增对象至数据表
        $Term->save();
        return $this->success('新增成功', url('index'));
    }


	// 删除废弃的学期内容
	public function delete()
	{
         // 获取pathinfo传入的ID值.
        $id = Request::instance()->param('id/d'); // “/d”表示将数值转化为“整形”

        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Term = Term::get($id);

        // 要删除的对象不存在
        if (is_null($Term)) {
            return $this->error('不存在id为' . $id . '的学期，删除失败');
        }

        // 删除对象
        if (!$Term->delete()) {
            return $this->error('删除失败:' . $Term->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('index'));
	}

	// 编辑学期内容
	public function edit()
	{
       // 获取传入ID
        $id = Request::instance()->param('id/d');

        // 在Teacher表模型中获取当前记录
        $Term = Term::get($id);

        // 将数据传给V层
        $this->assign('Term', $Term);

        // 获取封装好的V层内容
        $htmls = $this->fetch();


        // 将封装好的V层内容返回给用户
        return $htmls;
	}

	public function setstate()
	{
        // $a = Term::getCurrentTerm();
        // var_dump($a);die();
        // 获取所有学期的状态
        
        $terms = Term::all();

        // 通过循环实现状态值都设置为0
 
        foreach ($terms as $term) 
        {
        	if ($term->state != 0)
    		{
    			$term->state = 0;
    		    $term->save();
    	    }
        }
 
       // 把某学期状态设置为1
        $id = Request::instance()->param('id/d');
        
        $Term = Term::get($id);
        $Term->state = 1;

        // 保存
        $Term->save();
        // 实现url跳转('index')
        return $this->success('设置成功', url('index'));
	}

    // 更新修改后的数据
	public function update()
    {
        // 接收数据，获取要更新的关键字信息
        $id = Request::instance()->post('id/d');

        // 获取当前对象
       
        $Term = Term::get($id);
        

        // 写入要更新的数据
        $Term->name = Request::instance()->post('name');

        $Term->start_time = Request::instance()->post('start_time');
        $Term->end_time = Request::instance()->post('end_time');

        // 更新
        $Term->save();
        

        return $this->success('更新成功', url('index'));
    }

}


	