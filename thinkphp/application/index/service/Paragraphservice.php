<?php
namespace app\index\service;

use app\index\model\Paragraph;
use app\index\model\Common;

class Paragraphservice
{
	public function addOrEditParagraph($param)
	{
		// 获取参数
		$articleId = $param->param('articleId/d');
		$paragraphId = $param->param('id/d');
		$data = $param->post();

		// 初始化返回信息
		$message = [];
		$message['status'] = 'success';
		$message['message'] = '保存成功！';
		$message['route'] = 'article/secondadd';
		$message['articleId'] = $articleId;
		
		$file = request()->file('image');

		// 实例化一个空段落
		$Paragraph = new Paragraph();

		if (!is_null($paragraphId) && $paragraphId !== 0) {
			// 编辑段落
			$Paragraph = Paragraph::get($paragraphId);
			
			// 调用m层更新方法
			if ($Paragraph->updateParagraph($data, $paragraphId)) {
				// 更新成功
				$message['param']['id'] = $Paragraph->id;

			} else {
				// 更新失败
				$message['status'] = 'error';
				$message['message'] = '段落信息未修改！';
				$message['route'] = 'article/secondadd';
			}

		} else {
			// 新增段落是没有上传图片
			if (is_null($file)) {
				$message['status'] = 'error';
				$message['message'] = '提示：此段落没有图片！';
				$message['route'] = 'article/secondadd';
			}

			if ($Paragraph->saveParagraph($data, $articleId)) {
				// 保存成功
				$message['param']['id'] = $Paragraph->id;
			} else {
				// 保存失败
				$message['status'] = 'error';
				$message['message'] = '保存失败！';
				$message['route'] = 'article/secondadd';
			}
		}

		return $message;
	}

	public function deleteParagraph($param)
	{
		// 获取参数
		$paragraphId = $param->param('id/d');
		$articleId = $param->param('articleId/d');

		// 初始化返回信息
		$message = [];
		$message['message'] = '删除成功！';
		$message['status'] = 'success';
		$message['route'] = 'article/secondadd';
		$message['articleId'] = $articleId;

		// 获取段落id为空
		if (is_null($paragraphId) || $paragraphId === 0) {
			$message['status'] = 'error';
			$message['message'] = '未获取到id';

		} else {
			// 获取段落
			$Paragraph = Paragraph::get($paragraphId);

			// 获取段落为空
			if (is_null($Paragraph)) {
				$message['status'] = 'error';
				$message['message'] = '未获取到对象信息！';

			} else {
				// 删除失败
                Common::deleteImage('upload/'.$Paragraph->image);
				if (!$Paragraph->delete()) {
					$message['status'] = 'error';
					$message['message'] = '删除失败！';
				}
			}
		}
		
		return $message;
	}
}