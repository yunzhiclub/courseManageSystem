<?php
namespace app\index\model;

use think\Model;
use app\index\model\Article;
use app\index\service\Articleservice;

/**
 * @author 朴世超
 */
class Contractor extends Model
{
	/**
	 * 保存订制师
	 * @param  	$Data      接收的表单信息
	 * @param  	$articleId 接收的文章id
	 * @return  boolen	   保存成功返回true，否则返回false
	 */
	public function saveContractor($data)
	{
		$this->designation = $data['designation'];
		$this->phone = $data['phone'];
		$this->fax = $data['fax'];
		$this->mobile = $data['mobile'];
		$this->email = $data['email'];

		$boolean = $this->validate(true)->save();
		$errorMessage = $this->getError();
        $data['errorMessage'] = $errorMessage;
        $data['is_success'] = $boolean;
		return $data;
	}
}