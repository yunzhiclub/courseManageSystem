<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:93:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\material\edit.html";i:1506433773;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1506064901;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title>素材管理</title>
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
    

<div class="col-md-8 col-md-offset-1" style="margin-top: 60px;min-height: 730px;">
    <h2><span class="glyphicon glyphicon-edit"></span>&nbsp;素材编辑</h2>
    <br>
    <?php $action = request()->action() === 'add' ? 'save' : 'update'; ?>
    <form method="post" action="<?php echo url ($action,['materialId'=>$material->id]); ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="TitleInput">名称</label>
            <input type="text" class="form-control" id="TitleInput" placeholder="名称" name="designation" value="<?php echo $material->designation; ?>">
        </div>
        <div class="form-group">
            <label for="TitleInput">地区</label>
            <input type="text" class="form-control" id="TitleInput" placeholder="地区" name="area" value="<?php echo $material->area; ?>">
        </div>
        <div class="form-group">
            <label for="TitleInput">国家</label>
            <input type="text" class="form-control" id="TitleInput" placeholder="国家" name="country" value="<?php echo $material->country; ?>">
        </div>
        <div class="form-group">
            <label>描述</label>
            <!-- 加载编辑器的容器 -->
            <script id="container" name="content" type="text/plain">
                <?php echo $material->content; ?>
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
            <label for="input-b3">上传图片</label>
            <input id="input-b3" name="images[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true" >
        </div>
        <?php if($action == 'update'): ?>
        <div class="form-group">
            <p>在更改时请将更改后的图片包括原图一同上传(上传后会将原图删除)</p>
            <?php if(is_array($images) || $images instanceof \think\Collection): $key = 0; $__LIST__ = $images;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($key % 2 );++$key;?>
                <img src="<?php echo __ROOT__; ?>/upload/<?php echo $image; ?>" style="height: 100px; width: 200px;" >
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <?php endif; ?>

    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span>&nbsp;完成</button>
    <br>
    <br>
</form>
    <script>
        $("#input-b3").fileinput({
            language: 'zh', //设置语言
            uploadUrl: "./list.json", //上传的地址(访问接口地址)
            allowedFileExtensions: ['jpg', 'gif', 'png'],//接收的文件后缀
            dropZoneEnabled: false,//是否显示拖拽区域
            maxFileSize: 2048,//单位为kb，如果为0表示不限制文件大小
            maxFileCount: 10, //表示允许同时上传的最大文件个数
            enctype: 'multipart/form-data',
            validateInitialCount:true,
            previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
            msgFilesTooMany: "选择上传的文件数量({n}) 超过允许的最大数值{m}！",
            layoutTemplates:{
                actionDelete:'',
                actionUpload:'',
                actionZoom:''
            }
        });
    </script>
</div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Copyright &copy; 洛克旅行 All Rights Reserved</p>
            <p class="text-center">Powered By:梦云智</p>
        </div>
    </div>
</body>

</html>