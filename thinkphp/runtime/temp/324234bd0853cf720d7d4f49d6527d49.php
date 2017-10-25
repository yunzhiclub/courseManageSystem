<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:92:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\material\add.html";i:1504852565;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1504860531;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title>素材管理</title>
    <link rel="stylesheet" type="text/css" href="/beautifulArtical/thinkphp/public/style/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/beautifulArtical/thinkphp/public/style/js/plugin/layui-v1.0.7/css/layui.css">
    <link rel="stylesheet" href="/beautifulArtical/thinkphp/public/style/css/date.css">
    <link rel="stylesheet" type="text/css" href="/beautifulArtical/thinkphp/public/style/css/overhidden.css">
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
    
	<div class="col-md-8 col-md-offset-1" style="margin-top: 60px;min-height: 732px;">
		<h2><span class="glyphicon glyphicon-edit"></span>&nbsp;素材管理</h2>
		<br>
		<form method="post" action="<?php echo url ('addOperate'); ?>" enctype="multipart/form-data">
			<div class="form-group">
				<label for="TitleInput">名称</label>
				<input type="text" class="form-control" id="TitleInput" placeholder="名称" name="designation">
			</div>
			<div class="form-group">
				<label for="SummaryInput">描述</label>
				<textarea type="text" rows="5" cols="30" class="form-control" id="SummaryInput" placeholder="描述" name="content"></textarea>
			</div>
			<div class="form-group">
			<label for="exampleInputFile">图片</label>
			<input type="file" id="exampleInputFile" name="image">
			</div>
			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span>&nbsp;完成</button>
			<br><br>
		</form>
	</div>
	
    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Copyright &copy; XXX科技有限公司 All Rights Reserved</p>
            <p class="text-center">Powered By:梦云智</p>
        </div>
    </div>
</body>

</html>