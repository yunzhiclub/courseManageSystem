<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:94:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\material\index.html";i:1506433697;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1506064901;}*/ ?>
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
    
    <div class="row">
        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <form class="form-inline">

                        <input class="form-control" type="text" name="materialName" placeholder="素材名称..." value="<?php echo input('get.materialName'); ?>">

                        <button type="submit" class="btn btn-default">
                            <i class="glyphicon glyphicon-search"></i>
                            &nbsp;查询
                        </button>
                    </form>
                </div>
                <div class="col-md-4 text-right">
                    <a type="button" class="btn btn-primary" href="<?php echo url('add'); ?>"><i class="glyphicon glyphicon-plus"></i>&nbsp;&nbsp;添加素材</a>
                </div>
            </div>
        </div>
        <div class="container">
            <hr>
        </div>

        <ul class="container list-unstyled" style="min-height: 570px;">
            <?php if(is_array($materials) || $materials instanceof \think\Collection): $i = 0; $__LIST__ = $materials;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$material): $mod = ($i % 2 );++$i;?>
            <li style="list-style-type: none;">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><?php echo $material->designation; ?></h4>
                        <div class="row">
                            <!--轮播图-->
                            <div id="carousel-example-generic-<?php echo $i; ?>" class="col-md-3 carousel slide" data-ride="carousel" style="height:150px;width:300px;">
                                <ol class="carousel-indicators">
                                    <?php if(is_array($material->getMaterialImages()) || $material->getMaterialImages() instanceof \think\Collection): $key = 0; $__LIST__ = $material->getMaterialImages();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($key % 2 );++$key;?>
                                    <li data-target="#carousel-example-generic-<?php echo $i; ?>" data-slide-to="<?php echo $key; ?>" class="<?php if($key == '1'): ?>active<?php endif; ?>"></li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </ol>

                                <div class="carousel-inner" role="listbox">
                                    <?php if(is_array($material->getMaterialImages()) || $material->getMaterialImages() instanceof \think\Collection): $key = 0; $__LIST__ = $material->getMaterialImages();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($key % 2 );++$key;?>
                                    <div class="item <?php if($key == '1'): ?>active<?php endif; ?>">
                                        <img src="<?php echo __ROOT__; ?>/upload/<?php echo $image; ?>" alt="" style="width: 268px;height: 148px;">
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </div>

                                <a class="left carousel-control" href="#carousel-example-generic-<?php echo $i; ?>" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#carousel-example-generic-<?php echo $i; ?>" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="col-md-6 col-md-offset-1" style="word-wrap: break-word;">
                                <?php echo $filter->limitWordNumber($material->content); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="height: 40px; margin-top: 10px;">
                                <a class="btn btn-info btn-sm" href="<?php echo url('material/edit' ,['materialId'=>$material->id] ); ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;编辑</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo url('material/delete' ,['materialId'=>$material->id] ); ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>

        <div class="container text-right" style="height: 79px;">
            <?php echo $materials->render(); ?>
        </div>
    </div>

    <div class="container">
        <hr>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Copyright &copy; 洛克旅行 All Rights Reserved</p>
            <p class="text-center">Powered By:梦云智</p>
        </div>
    </div>
</body>

</html>