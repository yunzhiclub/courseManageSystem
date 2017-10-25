<?php
namespace app\index\service;

use app\index\model\AttractionMaterial;
use app\index\model\Material;
use app\index\model\Attraction;
use app\index\model\Common;

/**
 * 
 * @authors liming zhuchenshu
 * @date    2017-09-07 09:09:54
 * @version $Id$
 */

class Materialservice  {
    public function getAll() {
        $material = new Material();
        return $material->select();
    }

    /**
     * @param $param
     * @return array
     * 多张图片同时上传的过程
     */
    public function materialAdd($param) {
    	//初始化返回信息
        $message = [];
        $message['status'] = 'success';
        $message['route'] = 'index';
        $message['message'] = '景点素材添加成功';

        //获取到参数
        $content = $param->post('content');
        $designation = $param->post('designation');
        $area = $param->post('area');
        $country = $param->post('country'); 
        $action = request()->action() === 'save' ? 'add' : 'edit';
        // 新建素材实体
        $Material = new Material();
        //接收到多张图片
        $files = request()->file('images');
        //新建一个保存上传文件路径的数组
        $imagePaths = [];
        if(!empty($files)) {
            //开始保存图片的路径数据
            foreach ($files as $key => $value) {
                $imagePath = Common::uploadImage($value);
                array_push($imagePaths, $imagePath);
            }

            //将图片数组保存到实体中
            $Material->images = json_encode($imagePaths);
        } else {
            $Material->images = '';
        }
        $Material->content = $content;
        $Material->designation = $designation;
        $Material->area = $area;
        $Material->country = $country;

        if(!$Material->validate(true)->save()){
            $message['status'] = 'error';
            $message['message'] = '景点素材添加失败：'.$Material->getError();
        }
        return $message;
    }
    public function materialUpdate($param)  {
        $message = [];
        $message['status'] = 'success';
        $message['message'] = '景点素材编辑成功';

        $materialId = $param->param('materialId/d');

        if (is_null($materialId) || $materialId === 0) {
            $message['status'] = 'error';
            $message['message'] = '未获取到素材';
            return $message;
        }

        $Material = Material::get($materialId);
        if (is_null($Material)) {
            $message['status'] = 'error';
            $message['message'] = '未获取到素材';
            return $message;
        }

        $content = $param->post('content');
        $designation = $param->post('designation');
        $area = $param->post('area');
        $country = $param->post('country');
        $files = request()->file('images');

        $imagePaths = $Material->getMaterialImages();
        if (!empty($files)) {
            foreach ($files as $key => $value) {
                $imagePath = Common::uploadImage($value);
                array_push($imagePaths, $imagePath);
            }
            $Material->images = json_encode($imagePaths);
        }

        if($Material->content == $content && $Material->designation == $designation && $Material->area == $area && $Material->country == $country && empty($files)) {
            $message['message'] = '景点素材编辑成功';
            return $message;
        }

        $Material->content = $content;
        $Material->designation = $designation;
        $Material->area = $area;
        $Material->country = $country;

        if(!$Material->validate(true)->save() ) {
            $message['status'] = 'error';
            $message['message'] = '素材信息更新失败：'.$Material->getError();
        }

        return $message;
    }
    public function materialEdit($param) {
        // 初始化信息
        $message = [];
        $message['status'] = 'success';
        $message['route'] = 'index';
        $message['message'] = '景点素材添加成功';

        // 接受传来的素材id
        $materialId = $param->param('materialId/d');

        // 未获取到素材id
        if (is_null($materialId) || $materialId === 0) {
            $message['status'] = 'error';
            $message['message'] = '未获取到素材';

        } else {
            // 获取素材对象
            $Material = Material::get($materialId);
            $images = json_decode($Material->images);
            $message['images'] = $images;
            // 素材对象为空
            if (is_null($Material)) {
                $message['status'] = 'error';
                $message['message'] = '未获取到素材';

            } else {
                // 编辑素材
                $message['material'] = $Material;
            }
        }
        return $message;
    } 

    public function deleteMaterial($param)
    {
        // 初始化返回信息
        $message = [];
        $message['status'] = 'success';
        $message['message'] = '删除成功！';
        $message['route'] = 'index';

        // 接收数据
        $materialId = $param->param('materialId/d');

        // 素材id为空
        if (is_null($materialId) || $materialId === 0) {
            $message['status'] = 'error';
            $message['message'] = '未获取到素材';
        } else {
            $AttractionMaterial = new AttractionMaterial();
            $list = $AttractionMaterial->where('material_id', '=', $materialId)->select();
            if (!empty($list)) {
                $message['status'] = 'error';
                $message['message'] = '该素材已被使用，不能删除！';
            } else {
                // 获取素材对象
                $Material = Material::get($materialId);

                // 素材对象为空
                if (is_null($Material)) {
                    $message['status'] = 'error';
                    $message['message'] = '未获取到素材';

                } else {
                    $images = json_decode($Material->images);
                    // 删除素材失败
                    if (!$Material->delete()) {
                        $message['status'] = 'error';
                        $message['message'] = '删除失败';

                    } else {
                        // 删除照片
                        if (!empty($images)) {
                            foreach ($images as $key => $value) {
                                Common::deleteImage('upload/'.$value);
                            }
                        }
                    }
                }
            }
            
        }
        return $message;
    }

    public function searchMaterial($materialName, $pageSize) {
        $material = new Material();
        if(!empty($materialName)) {
            $material->where('designation', 'like', '%'. $materialName. '%');
        }
        $materials = $material->order('id desc')->paginate($pageSize, false, [
            'query' => [
                'materialName' => $materialName,
            ],
            'var_page' => 'page',
        ]);
        return $materials;
    }

    public function deleteImage($param) {
        //定义返回信息
        $message['status'] = 'success';

        $materialId = $param->param('materialId/d');
        $key = $param->param('imageKey/d');

        //从数据库取出数据
        $material = Material::get($materialId);
        $images = $material->getMaterialImages();

        $imagePath = $images[$key - 1];
        //删除图片
        Common::deleteImage($imagePath);

        //获取图片中的数组元素
        $arrayLength = count($images);

        if ($key === $arrayLength) {
            //说明只有一个元素
            unset($images[$key - 1]);
        } else {
            //从数组中移除这个元素
            $i = $key - 1;
            for (; $i < $arrayLength - 1; $i++) {
                $images[$i] = $images[$i + 1];
            }

            unset($images[$i]);
        }

        $material->images = json_encode($images);

        //从数据库更新数据
        if (!$material->validate(true)->save()) {
            $message['status'] = 'error';
        }

        return $message;
    }
}