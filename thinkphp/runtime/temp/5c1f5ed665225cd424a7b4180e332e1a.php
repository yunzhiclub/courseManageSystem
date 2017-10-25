<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:95:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\paragraph\index.html";i:1506064901;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1506064901;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title>段落编辑</title>
    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__; ?>/style/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <script src="<?php echo __ROOT__; ?>/style/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo __ROOT__; ?>/style/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="<?php echo __ROOT__; ?>/node_modules/share/dist/js/jquery.share.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__; ?>/style/css/overhidden.css">
    <link rel="stylesheet" href="<?php echo __ROOT__; ?>/node_modules/share/dist/css/share.min.css">
    <link href="<?php echo __ROOT__; ?>/style/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo __ROOT__; ?>/style/css/style.css" type="text/css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="<?php echo __ROOT__; ?>/style/css/ken-burns.css" type="text/css" media="all" />
    <!-- 多图片上传引用的外部文件 -->
    <script src="jquery.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__; ?>/style/diyUpload/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__; ?>/style/diyUpload/css/diyUpload.css">
    <script type="text/javascript" src="<?php echo __ROOT__; ?>/style/diyUpload/js/webuploader.html5only.min.js"></script>
    <script type="text/javascript" src="<?php echo __ROOT__; ?>/style/diyUpload/js/diyUpload.js"></script>
    <style>
        #box{  width:300px; min-height:150px; background:#FF9}
    </style>
    <link href="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />

    <script src="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/js/plugins/piexif.min.js" type="text/javascript"></script>
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
        This must be loaded before fileinput.min.js -->
    <script src="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- purify.min.js is only needed if you wish to purify HTML content in your preview for
        HTML files. This must be loaded before fileinput.min.js -->
    <script src="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/js/plugins/purify.min.js" type="text/javascript"></script>
    <!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js
       3.3.x versions without popper.min.js. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
        dialog. bootstrap 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- the main fileinput plugin file -->
    <script src="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/js/fileinput.min.js"></script>
    <script src="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/js/locales/zh.js"></script>
    <!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
    <script src="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/js/fa.js"></script>
    <!-- optionally if you need translation for your language then include  locale file as mentioned below -->
    <script src="<?php echo __ROOT__; ?>/bower_components/bootstrap-fileinput/js/(lang).js"></script>
</head>

<body class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="container">
            <nav class="navbar navbar-default" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?php echo url('article/index'); ?>">首页</a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li <?php if(request()->controller() == 'Material'): ?> class="active" <?php endif; ?>><a href="<?php echo url('Material/index'); ?>">素材管理</a></li>
                            <li <?php if(request()->controller() == 'Hotel'): ?> class="active" <?php endif; ?>><a href="<?php echo url('Hotel/index'); ?>">酒店管理</a></li>
                            <li <?php if(request()->controller() == 'Contractor'): ?> class="active" <?php endif; ?>><a href="<?php echo url('Contractor/index'); ?>">定制师管理</a></li>
                            <li <?php if(request()->controller() == 'User'): ?> class="active" <?php endif; ?>><a href="<?php echo url('User/index'); ?>">个人中心</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo url('login/logout'); ?>"><i class="glyphicon glyphicon-log-out"></i>&nbsp;登出</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    
<div class="col-md-8 col-md-offset-1" style="margin-top: 60px;min-height: 736px;">
    <div class="row">
        <h2><span class="glyphicon glyphicon-edit"></span>&nbsp; <?php if($judge == '1'): ?> 编辑段落 <?php else: ?>添加段落<?php endif; ?></h2>
        <br> <?php $action = request()->action() === 'index' ? 'add' : 'update'; ?>
        <form method="post" action="<?php echo url($action, ['id' => $Paragraph->getData('id'), 'articleId' => $articleId]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">标题</label>
                <input type="text" class="form-control" placeholder="标题" name="title" id="title" value="<?php echo $Paragraph->getData('title'); ?>">
            </div>
            <div class="form-group">
                <label>段落</label>
                <!-- 加载编辑器的容器 -->
                <script id="container" name="content" type="text/plain">
                    <?php echo $Paragraph->getData('content'); ?>
                </script>
                <!-- 配置文件 -->
                <script type="text/javascript" src="<?php echo __ROOT__; ?>/style/js/paragraphController/ueditor.config.js"></script>
                <script type="text/javascript" src="<?php echo __ROOT__; ?>/style/js/paragraphController/ueditor.all.js"></script>
                <!-- 实例化编辑器 -->
                <script type="text/javascript">
                var ue = UE.getEditor('container', {
                    toolbars: [
                        ['fullscreen', 'source', 'undo', 'redo', 'bold', 'indent', 'fontfamily', 'fontsize', 'paragraph', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'touppercase', 'tolowercase', 'justifyleft', 'justifyright', 'justifycenter', 'justifyjustify']
                    ],
                    autoHeightEnabled: true,
                    autoFloatEnabled: true
                });
                </script>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">图片</label>
                <input type="file" id="image-file" name="image" value="<?php echo $Paragraph->getData('image'); ?>" onchange="checkImg()">
                <script type="text/javascript">
                var _URL = window.URL || window.webkitURL;
                $('#image-file').bind('change', function() {
                    if ((file = this.files[0])) {
                        img = new Image();
                        img.onload = function() {
                            var width = this.width;
                            var height = this.height;
                            var ErrMsgErrMsg = "";//错误信息
                            if (width > 2048 || height > 2048) {
                                ErrMsgErrMsg = "图片过大,请选择其他图片！";
                                alert(ErrMsgErrMsg);
                                return false;
                            }   // 判断图片大小是否符合
                        };
                        img.src = _URL.createObjectURL(file);     
                    }
                });
                </script> 
                <?php if($Paragraph->image == ''): else: ?>
                <img src="<?php echo __ROOT__; ?>/upload/<?php echo $Paragraph->image; ?>" style="height: 100px; width: 180px; " alt="无图"> <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="">是否位于景点前</label>
                <div class="radio">
                    <label>
                        <input type="radio" name="is_before_attraction" value="1" checked> 是
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="is_before_attraction" value="0" <?php if($Paragraph->getData('is_before_attraction') == '0'): ?> checked="checked" <?php endif; ?>> 否
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span>&nbsp;完成</button>
        </form>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Copyright &copy; 洛克旅行 All Rights Reserved</p>
            <p class="text-center">Powered By:梦云智</p>
        </div>
    </div>
</body>

</html>