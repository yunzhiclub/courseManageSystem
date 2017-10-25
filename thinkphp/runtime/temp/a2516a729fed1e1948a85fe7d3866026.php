<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:94:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\contractor\add.html";i:1504852565;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1504860531;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title>新增订制师 </title>
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
    
    <div class="col-md-8 col-md-offset-1" style="margin-top: 60px;min-height: 730px;">
        <div class="row">
            <h2>
        <span class="glyphicon glyphicon-edit"></span>&nbsp;
        新增订制师</h2>
            <br>
            <form action="<?php echo url('save'); ?>" method="post">
                <div class="form-group">
                    <label>姓名</label>
                    <input type="text" class="form-control" name="designation" placeholder="姓名...">
                </div>
                <div class="form-group">
                    <label>电话</label>
                    <input type="text" class="form-control" name="phone" placeholder="电话...">
                </div>
                <div class="form-group">
                    <label>传真</label>
                    <input type="text" class="form-control" name="fax" placeholder="传真...">
                </div>
                <div class="form-group">
                    <label>手机</label>
                    <input type="text" class="form-control" name="mobile" placeholder="手机...">
                </div>
                <div class="form-group">
                    <label>电子邮箱</label>
                    <input type="email" class="form-control" name="email" placeholder="邮箱...">
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-ok"></i>&nbsp;保存</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Copyright &copy; XXX科技有限公司 All Rights Reserved</p>
            <p class="text-center">Powered By:梦云智</p>
        </div>
    </div>
</body>

</html>