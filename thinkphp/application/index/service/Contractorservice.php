<?php
namespace app\index\service;

use app\index\model\Contractor;
use app\index\model\Article;

class Contractorservice
{
	public function saveOrUpdateContractor($param)
	{
		$data = $param->post();

		$message = [];
		$message['status'] = 'success';
		$message['message'] = '保存成功！';
		$message['route'] = 'contractor/index';

		$Contractor = new Contractor();

		$tempMessage = $Contractor->saveContractor($data);
		if (!$tempMessage['is_success']) {
			$message['status'] = 'error';
			$message['message'] = $tempMessage['errorMessage'];
			$message['route'] = 'contractor/add';
		}

		return $message;		
	}
	// 接受订制师id，并返回订制师的信息
	public function editContractor($param) {
		// 获取接受信息
		$contractorId = $param->param('contractorId/d');
		// 获取订制师实体
		$Contractor = Contractor::get($contractorId);
		// 获取订制师实体信息
		$message['contractor'] = $Contractor;
		// 返回信息
		return $message;
	}
	public function updateContractor($param) {
		// 获取接受信息
		$contractorId = $param->param('contractorId/d');

		$message = [];

		$Contractor = Contractor::get($contractorId);

		$Contractor->designation = $param->post('designation');
		$Contractor->fax = $param->post('fax');
		$Contractor->mobile = $param->post('mobile');
		$Contractor->phone = $param->post('phone');
		$Contractor->email = $param->post('email');

		if($Contractor->validate(true)->save()){
			$message['status'] = 'success';
			$message['message'] = '编辑成功！';
			$message['route'] = 'index';
		}else{
			$message['status'] = 'success';
			$message['message'] = '数据未编辑！';
			$message['route'] = 'index';
		}
		return $message;
	} 

	public function deleteContractor($param)
	{
		// 初始化返回信息
		$message = [];
		$message['status'] = 'success';
		$message['message'] = '删除成功！';
		$message['route'] = 'index';

		// 接收数据
		$contractorId = $param->param('contractorId/d');

		// 订制师id为空
		if (is_null($contractorId) || $contractorId === 0) {
			$message['status'] = 'error';
			$message['message'] = '未获取到订制师';

		} else {
			// 获取所有此订制师用的文章
			$Article = new Article();
			$list = $Article->where('contractor_id', '=', $contractorId)->select();

			// 有文章用订制师，不能删除
			if (!empty($list)) {
				$message['status'] = 'error';
				$message['message'] = '此订制师已被使用，不能删除！';

			} else {
				// 获取订制师对象
				$Contractor = Contractor::get($contractorId);

				// 订制师为空
				if (is_null($Contractor)) {
					$message['status'] = 'error';
					$message['message'] = '未获取到订制师';
				} else {

					if (!$Contractor->delete()) {
						$message['status'] = 'error';
						$message['message'] = '删除失败！';
					}
				}
			}
		}

		return $message;
	}

    public function searchContractor($contractorName, $pageSize) {
        $contractor = new Contractor();
        if(!empty($contractorName)) {
            $contractor->where('designation', 'like', '%'. $contractorName. '%');
        }
        $contractors = $contractor->order('id desc')->paginate($pageSize, false, [
            'query' => [
                'contractorName' => $contractorName,
            ],
            'var_page' => 'page',
        ]);
        return $contractors;
    }
}