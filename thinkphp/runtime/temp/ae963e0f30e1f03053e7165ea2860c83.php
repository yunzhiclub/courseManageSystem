<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:94:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\attraction\add.html";i:1507503736;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1506064901;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title> 景点管理 </title>
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
    
<div class="col-md-8 col-md-offset-1" style="margin-top: 60px;min-height: 760px;">
    <div class="row">
        <h2><span class="glyphicon glyphicon-edit"></span>&nbsp;
            <?php if($attraction->id == '0'): ?>
            添加景点
            <?php else: ?>
            编辑景点
            <?php endif; ?>
        </h2>
        <br> <?php $action = request()->action() === 'add' ? 'save' : 'update'; ?>
        <form method="post" action="<?php echo url($action, ['articleId' => $articleId, 'attractionId' => $attraction->id]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>当日总行程</label>
                <input type="text" class="form-control" name="trip" placeholder="行程" value="<?php echo $attraction->trip; ?>" required>
            </div>
            <div class="form-group">
                <label>当日日期</label>
                <input type="date" class="form-control" name="date" placeholder="日期" value="<?php echo $attraction->date; ?>" required>
            </div>
            <div class="form-group">
                <label>导游</label>
                <input type="text" class="form-control" name="guide" placeholder="导游" value="<?php echo $attraction->guide; ?>" required>
            </div>
            <div class="form-group">
                <label>描述</label>
                <textarea class="form-control" name="description" rows="3" placeholder="描述" required><?php echo $attraction->description; ?></textarea>
            </div>
            <div class="form-group">
                <label>用餐</label>
                <div>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="meal[]" value="breakfast" <?php if($attraction->defaultCheck(request()->action()) == 'true'): ?>checked<?php endif; if($attraction->getMealIsChecked('breakfast') == 'true'): ?>checked<?php endif; ?>> 早餐
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="meal[]" value="lunch" <?php if($attraction->getMealIsChecked('lunch') == 'true'): ?>checked<?php endif; ?>> 午餐
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="meal[]" value="supper" <?php if($attraction->getMealIsChecked('supper') == 'true'): ?>checked<?php endif; ?>> 晚餐
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="meal[]" value="selfcare" <?php if($attraction->getMealIsChecked('selfcare') == 'true'): ?>checked<?php endif; ?>> 自理
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>用车</label>
                <div>
                    <label class="radio-inline">
                        <input type="radio" name="car" value="sevenToNineBusinessCar" <?php if($attraction->car == 'sevenToNineBusinessCar'): ?>checked<?php endif; ?>> 7-9座商务车
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="car" value="train" <?php if($attraction->car == 'train'): ?>checked<?php endif; ?>> 火车
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="car" value="car" <?php if($attraction->car == 'car'): ?>checked<?php endif; ?>> 汽车
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="car" value="plane" <?php if($attraction->car == 'plane'): ?>checked<?php endif; ?>> 飞机
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label>素材</label>
                <div>
                    <?php if(is_array($material->getAllCountries()) || $material->getAllCountries() instanceof \think\Collection): $i = 0; $__LIST__ = $material->getAllCountries();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$country): $mod = ($i % 2 );++$i;?>
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <label><?php echo $country; ?></label>
                            <table class="table table-bordered">
                                <?php if(is_array($material->getAreasByCountry($country)) || $material->getAreasByCountry($country) instanceof \think\Collection): $i = 0; $__LIST__ = $material->getAreasByCountry($country);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <th class="col-md-3"><?php echo $area; ?></th>
                                    <td>
                                        <?php if(is_array($material->getMaterialByCountryAndCity($country, $area)) || $material->getMaterialByCountryAndCity($country, $area) instanceof \think\Collection): $i = 0; $__LIST__ = $material->getMaterialByCountryAndCity($country, $area);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$material): $mod = ($i % 2 );++$i;?>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="materialId[]" value="<?php echo $material->id; ?>" <?php if($material->getIsChecked($attraction->id) == 'true  '): ?>checked<?php endif; ?>> <?php echo $material->designation; ?>
                                        </label>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </table>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>  
            </div>
            <div class="form-group">
                <label>酒店</label>
                <div>
                    <?php if(is_array($hotel->getAllCountries()) || $hotel->getAllCountries() instanceof \think\Collection): $i = 0; $__LIST__ = $hotel->getAllCountries();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$country): $mod = ($i % 2 );++$i;?>
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <label><?php echo $country; ?></label>
                            <table class="table table-bordered">
                                <?php if(is_array($hotel->getCitiesByCountry($country)) || $hotel->getCitiesByCountry($country) instanceof \think\Collection): $i = 0; $__LIST__ = $hotel->getCitiesByCountry($country);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$city): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <th class="col-md-3"><?php echo $city; ?></th>
                                    <td class="col-md-9">
                                        <table>
                                            <?php if(is_array($hotel->getStarsByCountryAndCity($country, $city)) || $hotel->getStarsByCountryAndCity($country, $city) instanceof \think\Collection): $i = 0; $__LIST__ = $hotel->getStarsByCountryAndCity($country, $city);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$star): $mod = ($i % 2 );++$i;?>
                                            <tr>
                                                <th><?php echo $star; ?></th>
                                                <td>
                                                    <?php if(is_array($hotel->getHotelsByCountryAndCityAndStar($country, $city, $star)) || $hotel->getHotelsByCountryAndCityAndStar($country, $city, $star) instanceof \think\Collection): $i = 0; $__LIST__ = $hotel->getHotelsByCountryAndCityAndStar($country, $city, $star);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotel): $mod = ($i % 2 );++$i;?>
                                                    <label>
                                                        <input type="radio" name="hotelId" value="<?php echo $hotel->id; ?>" <?php if($attraction->hotel_id == $hotel->id): ?>checked<?php endif; ?>> <?php echo $hotel->designation; ?>
                                                    </label>
                                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </table>
                                    </td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </table>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
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