<?php
namespace app\index\model;

use think\Model;
use think\Reuquest;
use app\index\model\Common;
/**
 * 
 * @authors zhuchenshu
 * @date    2017-08-30 16:25:40
 * @version $Id$
 */

class Paragraph extends Model 
{
    /**
     * @param $className 类名
     * @param $keyWords  关键字
     * @param $articleId 文章ID
     */
    public static function getWeight($keyWords, $articleId)
    {
        
        $Paragraph = new Paragraph();

        $weight = $Paragraph->where('article_id', $articleId)->max($keyWords);
        $weight++;
        return $weight;
    }

    public function saveParagraph($data, $articleId)
    {
		$this->title = $data['title'];
        if (empty($data['content'])) {
            $this->content = "";
        } else {
            $this->content = $data['content'];
        }
        $this->is_before_attraction = (boolean)$data['is_before_attraction'];
		$this->article_id = $articleId;
		$this->weight = $this->getWeight("weight", $this->article_id);
		
		// 传入图片
    	$file = request()->file('image');
    	
        if (!is_null($file)) {
            // 返回图片路径
            $image = Common::uploadImage($file);
            // 保存图片路径
            $this->image = $image;
        }
    	
    	if ($this->save()) {
            return true;
        }

        return false;
    }

    /**
     * 更新段落信息
     * @param  $data         接收的表单信息
     * @return boolean       更新成功返回true，否则返回false
     */
    public function updateParagraph($data, $id)
    {    
        // 传入图片
        $file = request()->file('image');

        // 判断是否是重写 
        $Paragraph = $this->ifedit($id,$file);
        $this->id = $id;
        $this->title = $data['title'];
        if(empty($data['content'])){
            $this->content = '';
        }else{
            $this->content = $data['content'];
        }
        $this->is_before_attraction = (boolean)$data['is_before_attraction'];

        // 获取文件 
        if(!is_null($file)){
            // 保存文件，返回路径
            $image = Common::uploadImage($file);
            $this->image = $image;  
        }

        if ($this->save()) {
            return true;
        }
        return false;
    }

    public function ifedit($id, $file)
    {
        if(is_null($id)){
            $Paragraph = new Paragraph;
            return $Paragraph;
        }else{
            $Paragraph = Paragraph::get($id);
            // 判断图片是否更改
            if(is_null($file)){
                return $Paragraph;
            }
            // 删除之前保存的图片
            Common::deleteImage('upload/'.$Paragraph->image);
            return $Paragraph;
        }
    }
}