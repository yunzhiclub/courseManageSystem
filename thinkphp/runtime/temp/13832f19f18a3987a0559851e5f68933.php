<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:97:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\article\secondadd.html";i:1506433697;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1506064901;}*/ ?>
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
    
<script type="text/javascript" src="<?php echo __ROOT__; ?>/style/js/Calculation.js"></script>
<div class="col-md-8 col-md-offset-1" style="margin-top: 60px;min-height: 730px;">
    <h2><span class="glyphicon glyphicon-edit"></span>&nbsp;文章编辑</h2>
    <br>
    <form method="post" action="<?php echo url ('addsecond',['articleId'=>$articleId]); ?>" enctype="multipart/form-data">
        <div class="form-group">
            <label for="TitleInput">标题</label>
            <input type="text" class="form-control" id="TitleInput" placeholder="标题" name="title" value="<?php echo $title; ?>" readonly>
        </div>
        <div class="form-group">
            <label>摘要</label>
            <textarea class="form-control" rows="3" readonly><?php echo $filter->limitWordNumber($summery ); ?></textarea>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">封面</label>
            <img src="<?php echo __ROOT__; ?>/upload/<?php echo $cover; ?>" style="height: 100px; width: 180px; " alt="无图">
            <br>
            <br>
            <a class="btn btn-default" href="<?php echo url('editfirstadd?articleId=' . $articleId); ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;更改文章及定制师</a>
        </div>
        <div class="form-group">
            <label for="TextInput">正文</label>
            <span class="col-md-offset-1">
				<a class="btn btn-primary btn-sm" href="<?php echo url('Paragraph/index', ['articleId'=>$articleId,'id'=>'']); ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;段落</a>&nbsp;&nbsp;
            <a class="btn btn-primary btn-sm" href="<?php echo url('Attraction/add?articleId='.$articleId); ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;景点</a>&nbsp;&nbsp;
        </div>
        <ul style="list-style-type: none;">
            <?php if(is_array($paragraphUp) || $paragraphUp instanceof \think\Collection): $i = 0; $__LIST__ = $paragraphUp;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$paragraph): $mod = ($i % 2 );++$i;?>
            <li>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><?php echo $paragraph->title; ?></h4>
                        <div class="row">
                            <div class="col-md-3" style="height: 100px;">
                                <img src="<?php echo __ROOT__; ?>/upload/<?php echo $paragraph->image; ?>" style="height: 100px; width: 180px;" alt="">
                            </div>
                            <div class="col-md-6 col-md-offset-1" style="word-wrap: break-word;">
                                <?php echo $filter->limitWordNumber($paragraph->content, 245); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="height: 40px; margin-top: 10px;">
                                <a class="btn btn-info btn-sm" href="<?php echo url('Paragraph/edit',['articleId'=>$articleId,'id'=>$paragraph->id]); ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;编辑</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo url('Paragraph/delete', ['articleId'=>$articleId,'id'=>$paragraph->id]); ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; if(is_array($attraction) || $attraction instanceof \think\Collection): $keys = 0; $__LIST__ = $attraction;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_attraction): $mod = ($keys % 2 );++$keys;?>
            <li>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Day<?php echo $keys; ?></h4>
                        <br>
                        <div class="row">
                            <div class="col-md-10">
                                总行程：<?php echo $_attraction->trip; ?><br>
                                日期：<?php echo $_attraction->date; ?><br>
                                导游：<?php echo $_attraction->guide; ?><br>
                                用餐：<?php echo $_attraction->getMeals(); ?><br>
                                用车：<?php echo $_attraction->getCar(); ?><br>

                                素材：<?php if(is_array($_attraction->getCheckedMaterial()) || $_attraction->getCheckedMaterial() instanceof \think\Collection): $i = 0; $__LIST__ = $_attraction->getCheckedMaterial();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$material): $mod = ($i % 2 );++$i;?><button type="button" class="btn btn-default btn-xs"><?php echo $material->designation; ?></button>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <br>
                                酒店：<?php echo $_attraction->getHotelDesignation(); ?><br>
                                描述：<?php echo $filter->limitWordNumber($_attraction->description ); ?><br>
                            </div>
                            <div class="col-md-2">
                                <br>
                                <br>
                                <?php if($keys == '1'): else: ?><a class="btn btn-default" href="<?php echo url('upAttraction',['articleId'=>$articleId,'attractionId'=>$_attraction->id,'number'=>$keys]); ?>"><span class="glyphicon glyphicon-arrow-up" ></span></a><?php endif; ?>
                                <br>
                                <?php if($keys == $length): else: ?><a class="btn btn-default" href="<?php echo url('downAttraction',['articleId'=>$articleId,'attractionId'=>$_attraction->id,'number'=>$keys]); ?>"><span class="glyphicon glyphicon-arrow-down"></span></a><?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="height: 40px; margin-top: 10px;">
                                <a class="btn btn-info btn-sm" href="<?php echo url('attraction/edit' ,['articleId'=>$articleId,'attractionId'=>$_attraction->id] ); ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;编辑</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo url('attraction/delete' ,['articleId'=>$articleId,'attractionId'=>$_attraction->id] ); ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; if(is_array($paragraphDown) || $paragraphDown instanceof \think\Collection): $i = 0; $__LIST__ = $paragraphDown;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$paragraph): $mod = ($i % 2 );++$i;?>
            <li>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4><?php echo $paragraph->title; ?></h4>
                        <div class="row">
                            <div class="col-md-3" style="height: 100px;">
                                <img src="<?php echo __ROOT__; ?>/upload/<?php echo $paragraph->image; ?>" style="height: 100px; width: 180px;" alt="">
                            </div>
                            <div class="col-md-6 col-md-offset-1" style="word-wrap: break-word;">
                                <?php echo $filter->limitWordNumber($paragraph->content ); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="height: 40px; margin-top: 10px;">
                                <a class="btn btn-info btn-sm" href="<?php echo url('Paragraph/edit',['articleId'=>$articleId,'id'=>$paragraph->id]); ?>"><span class="glyphicon glyphicon-pencil"></span>&nbsp;编辑</a>
                                <a class="btn btn-danger btn-sm" href="<?php echo url('Paragraph/delete', ['articleId'=>$articleId,'id'=>$paragraph->id]); ?>"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</a>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <!-- 定制师 -->
            <li>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover table-bordered">
                                    <?php if($judgeContractor == '0'): else: ?>
                                    <tr>
                                        <th>定制师</th>
                                        <td><?php echo $contractor->designation; ?></td>
                                    </tr>
                                    <tr>
                                        <th>电话号码</th>
                                        <td><?php echo $contractor->phone; ?></td>
                                    </tr>
                                    <tr>
                                        <th>传真号码</th>
                                        <td><?php echo $contractor->fax; ?></td>
                                    </tr>
                                    <tr>
                                        <th>手机号码</th>
                                        <td><?php echo $contractor->mobile; ?></td>
                                    </tr>
                                    <tr>
                                        <th>电子邮件</th>
                                        <td><?php echo $contractor->email; ?></td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div>
                    <table class="table table-hover table-responsive table-bordered" style="word-break:break-all;">
                        <?php if($judgeHotel == '0'): else: ?>
                        <h3>酒店信息</h3>
                        <tr class="warning">
                            <th width="20%">名称</th>
                            <th width="20%">城市</th>
                            <th width="20%">星级</th>
                            <th width="40%">备注</th>
                        </tr>
                        <?php endif; if(is_array($hotel) || $hotel instanceof \think\Collection): $i = 0; $__LIST__ = $hotel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotel): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <th><?php echo $hotel->designation; ?></th>
                            <th><?php echo $hotel->city; ?></th>
                            <th><?php echo $hotel->star_level; ?></th>
                            <th><?php echo $hotel->remark; ?></th>
                        </tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                </div>
            </li>
        </ul>
        <script type="text/javascript" src="<?php echo __ROOT__; ?>/style/js/Calculation.js"></script>
        <div class="row-fluid">
            <div style="margin-top: 60px;">
                <div class="row">
                    <div class="col-md-12">
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade in active" id="firstform">
                                    <br>
                                    <div class="control-group row">
                                        <label class="control-label">出行人数</label>
                                        <hr>
                                        <div class="form-group col-md-3">
                                            <label>成人数</label>
                                            <input type="number" class="form-control" id="adultNum" name="adultNum" placeholder="成人..." value="<?php echo $plan->adult_num; ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>儿童数</label>
                                            <input type="number" class="form-control" id="childNum" name="childNum" placeholder="儿童..." value="<?php echo $plan->child_num; ?>" onkeyup="jisuan();">
                                        </div>
                                    </div>
                                    <div class="control-group row">
                                        <label>机票</label>
                                        <hr>
                                        <div class="form-group col-md-3">
                                            <label>成人单价</label>
                                            <input type="text" class="form-control" id="planeAdultUnitPrice" name="planeAdultUnitPrice" placeholder="成人单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('plane', $plan)->adult_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>儿童单价</label>
                                            <input type="text" class="form-control" id="planeChildUnitPrice" name="planeChildUnitPrice" placeholder="儿童单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('plane', $plan)->child_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>总价</label>
                                            <input type="text" class="form-control" id="planeTotalPrice" name="planeTotalPrice" placeholder="总价..." value="<?php echo $filter->moneyFilter($plan->getDetail('plane', $plan)->total_price ); ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>备注</label>
                                            <input type="text" class="form-control" id="planeRemark" name="planeRemark" placeholder="备注..." value="<?php echo $plan->getDetail('plane', $plan)->remark; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group row">
                                        <label>签证</label>
                                        <hr>
                                        <div class="form-group col-md-3">
                                            <label>成人单价</label>
                                            <input type="text" class="form-control" id="visaAdultUnitPrice" name="visaAdultUnitPrice" placeholder="成人单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('visa', $plan)->adult_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>儿童单价</label>
                                            <input type="text" class="form-control" id="visaChildUnitPrice" name="visaChildUnitPrice" placeholder="儿童单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('visa', $plan)->child_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>总价</label>
                                            <input type="text" class="form-control" id="visaTotalPrice" name="visaTotalPrice" placeholder="总价..." value="<?php echo $filter->moneyFilter($plan->getDetail('visa', $plan)->total_price ); ?>" >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>备注</label>
                                            <input type="text" class="form-control" id="visaRemark" name="visaRemark" placeholder="备注..." value="<?php echo $plan->getDetail('visa', $plan)->remark; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group row">
                                        <label>旅游</label>
                                        <hr>
                                        <div class="form-group col-md-3">
                                            <label>成人单价</label>
                                            <input type="text" class="form-control" id="tourismAdultUnitPrice" name="tourismAdultUnitPrice" placeholder="成人单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('tourism', $plan)->adult_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>儿童单价</label>
                                            <input type="text" class="form-control" id="tourismChildUnitPrice" name="tourismChildUnitPrice" placeholder="儿童单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('tourism', $plan)->child_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>总价</label>
                                            <input type="text" class="form-control" id="tourismTotalPrice" name="tourismTotalPrice" placeholder="总价..." value="<?php echo $filter->moneyFilter($plan->getDetail('tourism', $plan)->total_price ); ?>" >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>备注</label>
                                            <input type="text" class="form-control" id="tourismRemark" name="tourismRemark" placeholder="备注..." value="<?php echo $plan->getDetail('tourism', $plan)->remark; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group row">
                                        <label>保险</label>
                                        <hr>
                                        <div class="form-group col-md-3">
                                            <label>成人单价</label>
                                            <input type="text" class="form-control" id="insuranceAdultUnitPrice" name="insuranceAdultUnitPrice" placeholder="成人单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('insurance', $plan)->adult_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>儿童单价</label>
                                            <input type="text" class="form-control" id="insuranceChildUnitPrice" name="insuranceChildUnitPrice" placeholder="儿童单价..." value="<?php echo $filter->moneyFilter($plan->getDetail('insurance', $plan)->child_unit_price ); ?>" onkeyup="jisuan();">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>总价</label>
                                            <input type="text" class="form-control" id="insuranceTotalPrice" name="insuranceTotalPrice" placeholder="总价..." value="<?php echo $filter->moneyFilter($plan->getDetail('insurance', $plan)->total_price ); ?>" >
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>备注</label>
                                            <input type="text" class="form-control" id="insuranceRemark" name="insuranceRemark" placeholder="备注..." value="<?php echo $plan->getDetail('insurance', $plan)->remark; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group row">
                                        <label for="currency">币种</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" name="currency" placeholder="币种..." value="<?php echo $plan->currency; ?>"/>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="control-group row">
                                        <label for="totalCost">总费用</label>
                                        <div class="controls">
                                            <input type="text" class="form-control" id="totalCost" name="totalCost" placeholder="总费用..." value="<?php echo $filter->moneyFilter($plan->total_cost ); ?>" />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="control-group row">
                                        <label for="lastPayTime">最晚付款时间</label>
                                        <div class="controls">
                                            <input type="date" class="form-control" name="lastPayTime" value="<?php echo $plan->last_pay_time; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span>&nbsp;完成</button>
        <br>
        <br>
    </form>
</div>

    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Copyright &copy; 洛克旅行 All Rights Reserved</p>
            <p class="text-center">Powered By:梦云智</p>
        </div>
    </div>
</body>

</html>