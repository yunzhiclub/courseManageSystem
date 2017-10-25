<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:96:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\article\firstadd.html";i:1507529985;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1506064901;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title>文章编辑</title>
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
    <div class="row">
        <h2><span class="glyphicon glyphicon-edit"></span>&nbsp;文章编辑</h2>
        <br>
        <?php $action = request()->action() === 'firstadd' ? 'savefirstadd' : 'updatefirstadd'; ?>
        <form method="post" action="<?php echo url ($action,['articleId'=>$articleId]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="TitleInput">标题</label>
                <input type="text" class="form-control" id="TitleInput" placeholder="标题" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="form-group">
                <label>摘要</label>
                <!-- 加载编辑器的容器 -->
                <script id="container" name="summery" type="text/plain">
                    <?php echo $summery; ?>
                </script>
                <!-- 配置文件 -->
                <script type="text/javascript" src="<?php echo __ROOT__; ?>/style/js/paragraphController/ueditor.config.js"></script>
                <script type="text/javascript" src="<?php echo __ROOT__; ?>/style/js/paragraphController/ueditor.all.js"></script>
                <!-- 实例化编辑器 -->
                <script type="text/javascript">
                var ue = UE.getEditor('container', {
                    toolbars: [
                        ['fullscreen', 'source', 'undo', 'redo', 'bold', 'indent', 'fontsize', 'paragraph', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'touppercase', 'tolowercase', 'justifyleft', 'justifyright', 'justifycenter', 'justifyjustify']
                    ],
                    autoHeightEnabled: true,
                    autoFloatEnabled: true
                });
                </script>
            </div>
            <div class="form-group">
                <label for="exampleInputFile">封面</label>
                <input type="file" class="image-file" name="image" onchange="checkImg()">
                <?php if($cover == ''): else: ?>
                <img src="<?php echo __ROOT__; ?>/upload/<?php echo $cover; ?>" style="height: 100px; width: 180px; " alt=""> <?php endif; ?>
            </div>
           
            
            <br>
            <div class="form-group">
                <span class="span6">
                    <strong>定制师选择</strong>
                </span>
                <span class="span6">
                    <select name="contractorId" id="contractor">
                        <?php if(is_array($contractors) || $contractors instanceof \think\Collection): $i = 0; $__LIST__ = $contractors;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_Contractor): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $_Contractor->getData('id'); ?>" <?php if($_Contractor->id == $contractorId): ?>selected="true"<?php else: endif; ?>><?php echo $_Contractor->getData('designation'); ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
            </div>
            <?php if($articleId == ''): ?>
             <div class="form-group">
                <label for="torvelRoutes">路线图</label>
                <input type="file" id="torvelRoutes" name="routes" class="image-file">

                <?php if($route == '1'): else: ?> 
                <img src="<?php echo __ROOT__; ?>/upload/<?php echo $route; ?>" style="height: 100px; width: 180px; " alt="">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="judgeRoute">是否添加路线图</label>
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="1" checked>是
                <input type="radio" name="optionsRadios" id="optionsRadios1" value="0">否
            </div>
            <div class="form-group">
                <label>是否添加九大服务</label>
                <input type="radio" name="especialMassageService"  value="九大服务" checked>是
                <input type="radio" name="especialMassageService"  value="" >否
            </div>
            <div class="form-group">
                <label>是否添加六大品质</label>
                <input type="radio" name="especialMassageQuality"  value="六大品质" checked>是
                <input type="radio" name="especialMassageQuality"  value="" >否
            </div>
            <div class="form-group">
                <label>是否添加报价说明</label>
                <input type="radio" name="especialMassageQuotes"  value="报价说明" checked>是
                <input type="radio" name="especialMassageQuotes"  value="" >否
            </div>
            <div class="form-group">
                <label>是否添加费用包含</label>
                <input type="radio" name="especialMassageCost"  value="费用包括" checked>是
                <input type="radio" name="especialMassageCost"  value="" >否
            </div>
            <div class="form-group">
                <label>是否添加费用不包含</label>
                <input type="radio" name="especialMassageNoCost"  value="费用不包括" checked>是
                <input type="radio" name="especialMassageNoCost"  value="" >否
            </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-arrow-right"></span>&nbsp;下一步</button>
            <br>
            <br>
        </form>
    </div>
</div>
<script type="text/javascript">
                var _URL = window.URL || window.webkitURL;
                $('.image-file').bind('change', function() {
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

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Copyright &copy; 洛克旅行 All Rights Reserved</p>
            <p class="text-center">Powered By:梦云智</p>
        </div>
    </div>
</body>

</html>