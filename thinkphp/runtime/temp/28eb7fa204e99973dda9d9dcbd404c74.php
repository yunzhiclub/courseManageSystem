<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:90:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\detail\add.html";i:1505311434;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1505293116;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title> 添加方案报价 </title>
    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__; ?>/style/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <script src="<?php echo __ROOT__; ?>/style/js/jquery-2.1.1.min.js"></script>
    <script src="<?php echo __ROOT__; ?>/style/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="<?php echo __ROOT__; ?>/node_modules/share/dist/js/jquery.share.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="<?php echo __ROOT__; ?>/style/css/overhidden.css">
    <link rel="stylesheet" href="<?php echo __ROOT__; ?>/node_modules/share/dist/css/share.min.css">
    <link href="<?php echo __ROOT__; ?>/style/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo __ROOT__; ?>/style/css/style.css" type="text/css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="<?php echo __ROOT__; ?>/style/css/ken-burns.css" type="text/css" media="all" />
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
    
<script type="text/javascript" src="<?php echo __ROOT__; ?>/style/js/Calculation.js"></script>
<div class="row-fluid">
    <div class="col-md-8 col-md-offset-1" style="margin-top: 60px;min-height: 730px;">
        <div class="row">
            <h2><span class="glyphicon glyphicon-edit"></span>&nbsp;新增方案报价</h2>
            <br>
            <div class="row">
                <div>
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#firstform" data-toggle="tab">第一步</a>
                        </li>
                        <li>
                            <a href="#secondform" data-toggle="tab">第二步</a>
                        </li>
                        <li>
                            <a href="#thirdform" data-toggle="tab">第三步</a>
                        </li>
                    </ul>
                    <form action="<?php echo url('save', ['articleId' => $articleId]); ?>" method="post">
                        <div id="myTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="firstform">
                                <br>
                                <h3>添加方案报价</h3>
                                <div class="control-group">
                                    <label for="travelDate">出行日期</label>
                                    <div class="controls">
                                        <input type="date" class="form-control" name="travelDate" placeholder="出行日期" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="peopleNum">出行人数</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="peopleNum" placeholder="出行人数" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="currency">币种</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="currency" placeholder="币种" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="totalCost">总费用</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="totalCost" placeholder="总费用" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="lastPayTime">最晚付款时间</label>
                                    <div class="controls">
                                        <input type="date" class="form-control" name="lastPayTime" placeholder="最晚付款时间" />
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="tab-pane fade" id="secondform">
                                <br>
                                <h3>添加地接类型</h3>
                                <div class="control-group">
                                    <label for="number">数量</label>
                                    <div class="controls">
                                        <input type="number" class="form-control number " name="dijie_number" placeholder="数量" onkeyup="jisuan();" id="numberdijie" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="frequency">频次</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" name="dijie_frequency" placeholder="频次" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="unitPrice">单价</label>
                                    <div class="controls">
                                        <input  class="form-control unit" name="dijie_unitPrice" placeholder="单价" onkeyup="jisuan();" id="unitdijie" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="totalPrice">总价</label>
                                    <div class="controls">
                                        <input  class="form-control total" name="dijie_totalPrice" placeholder="总价" id="totaldijie" readonly />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="remark">备注</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="dijie_remark" placeholder="备注" />
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="tab-pane fade" id="thirdform">
                                <br>
                                <h3>添加住宿类型</h3>
                                <div class="control-group">
                                    <label for="number">数量</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" name="zhusu_number" placeholder="数量" id="numberzhusu"  onkeyup="jisuan();"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="frequency">频次</label>
                                    <div class="controls">
                                        <input type="number" class="form-control" name="zhusu_frequency" placeholder="频次" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="unitPrice">单价</label>
                                    <div class="controls">
                                        <input type="text"  class="form-control" name="zhusu_unitPrice" placeholder="单价" id="unitzhusu" onkeyup="jisuan();"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="totalPrice">总价</label>
                                    <div class="controls">
                                        <input  class="form-control" name="zhusu_totalPrice" placeholder="总价" id="totalzhusu" readonly />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="remark">备注</label>
                                    <div class="controls">
                                        <input type="text" class="form-control" name="zhusu_remark" placeholder="备注" />
                                    </div>
                                </div>
                                <br>
                                <div class="control-group">
                                    <button type="submit" class="btn btn-primary" href="#"><span class="glyphicon glyphicon-ok"></span>&nbsp;提交</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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