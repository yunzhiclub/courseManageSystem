<?php

namespace app\index\model;

use app\index\model\Paragraph;
use think\File;

class Common
{
    /**
     * Created by PhpStorm.
     * User: zhangxishuo
     * Date: 2017/8/30
     * Time: 16:54
     * @uploadImage 上传文件
     * @param 需要上传的文件
     * @return 文件存储后的路径
     */
    public static function uploadImage($file)
    {
        $info = $file->validate(['size'=>2048000])->move(PUBLIC_PATH);

        if ($info) {
            return $info->getSaveName();
        } else {
            return $file->getError();
        }
    }


    // 删除指定文件夹下的图片
    public static function deleteImage($imagePath)
    {
        if($imagePath !== 'upload/') {
            //拼接一个完整的文件路径
            $imagePath = PUBLIC_PATH . "/" . $imagePath;
            if(file_exists($imagePath)){
                unlink($imagePath);
            }
        }
    }

    public static function deleteManyImages($imagePaths) {
        $imagePaths = json_decode($imagePaths);
        foreach ($imagePaths as $imagePath) {
            $imagePath = PUBLIC_PATH . '/' .$imagePath;
            self::deleteImage($imagePath);
        }
    }
}