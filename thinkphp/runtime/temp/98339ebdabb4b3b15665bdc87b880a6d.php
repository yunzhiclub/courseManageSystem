<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:91:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\login\index.html";i:1506064901;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__; ?>/style/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
</head>

<body class="container">
    <div class="row">
        <div style="margin-top: 10%;" align="center">
            <h3>
                欢迎使用本系统
            </h3>
        </div>
    </div>
    <div class="row">
        <div class="signup-form" style="border:2px; border-color: #ACEBAE;border-style: solid; margin-top: 5%; padding: 3%; margin-left: 31%; margin-right: 31%;" align="center">
            <div class="row">
                <form class="form-horizontal" action="<?php echo url('login'); ?>" method="post">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="username" placeholder="用户名...">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="password" class="form-control" name="password" placeholder="密码...">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-info" style="width: 100%;">登录</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div align="center" style="margin-top: 1%;">
            <p>Copyright @ Power by mengyunzhi</p>
        </div>
    </div>
</body>

</html>