<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:92:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\article\main.html";i:1507503736;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <title>洛克旅行</title>
    <!-- For-Mobile-Apps-and-Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <!-- Custom Theme files -->
    <link href="<?php echo __ROOT__; ?>/style/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo __ROOT__; ?>/style/css/style.css" type="text/css" rel="stylesheet" media="all">
    <link href="<?php echo __ROOT__; ?>/style/css/Timelinestyle.css" type="text/css" rel="stylesheet" media="all">
    <!-- Slider Show css-->
    <link rel="stylesheet" href="<?php echo __ROOT__; ?>/style/css/ken-burns.css" type="text/css" media="all" />
    <!-- //Custom Theme files -->
    <script src="<?php echo __ROOT__; ?>/style/js/jquery-2.1.1.min.js"></script>
    <!-- nice scroll-js -->
    <script src="<?php echo __ROOT__; ?>/style/js/jquery.nicescroll.min.js"></script>
    <script>
    $(document).ready(function() {

        var nice = $("html").niceScroll(); // The document page (body)

        $("#div1").html($("#div1").html() + ' ' + nice.version);

        $("#boxscroll").niceScroll({ cursorborder: "", cursorcolor: "#00F", boxzoom: true }); // First scrollable DIV
    });
    </script>
    <script src="<?php echo __ROOT__; ?>/style/js/bootstrap.js"></script>
    <!-- nice scroll-js -->
    <script src="<?php echo __ROOT__; ?>/style/js/custom.js"></script>
</head>

<body class="bg" style="overflow-x: hidden;position: absolute">
    <div class="agile-main">
        <div class="content-wrap">
            <!-- 紫色顶部 -->
            <div class="header">
                <div class="menu-icon">
                    <button class="menu-button"></button>
                </div>
                <div class="logo">
                    <h2><a>洛克</a></h2>
                    <!-- 可以换成洛克酒店的logo -->
                </div>
                <div class="login">
                    <span class="sign-in popup-top-anim glyphicon glyphicon-user menu-button"></span>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="welcome">
                    <h3 class="w3ls-title" style="color: #81be32;"><?php echo $article->title; ?></h3>
                    <br>
                    <div>
                        <img src="<?php echo __ROOT__; ?>/upload/<?php echo $article->cover; ?>" height="150" width="97%">
                    </div>
                    <p class="w3title-text" style="text-align: left;">&nbsp;&nbsp;<?php echo $article->summery; ?></p>
                    <br>
                </div>

            <div class="content">
              <h3 class="w3ls-title" style="color: #8b008b;">线路概述</h3>
                <section id="cd-timeline" class="cd-container">
                    <?php if(is_array($attractions) || $attractions instanceof \think\Collection): $key = 0; $__LIST__ = $attractions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$attraction): $mod = ($key % 2 );++$key;?>
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-movie">
                            <img src="<?php echo __ROOT__; ?>/style/images/cd-icon-location.svg" alt="Location">
                        </div>
                        <div class="cd-timeline-content">
                            <h4><?php echo $attraction->trip; ?></h4>
                            <?php if(is_array($attraction->getMaterials()) || $attraction->getMaterials() instanceof \think\Collection): $i = 0; $__LIST__ = $attraction->getMaterials();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$material): $mod = ($i % 2 );++$i;?>
                            <p style="display: inline;">
                                <?php echo $filter->limitPreviewWordNumber($material->designation, 5); ?>
                            </p>&nbsp;&nbsp;
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                     <?php endforeach; endif; else: echo "" ;endif; ?>
                </section>
                <?php if(is_array($paragraphUps) || $paragraphUps instanceof \think\Collection): $i = 0; $__LIST__ = $paragraphUps;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pragraph): $mod = ($i % 2 );++$i;?>
                <div class="about">
                    <h3 style="text-align: center;" class="w3ls-title"><?php echo $pragraph->title; ?></h3> <?php echo $pragraph->content; ?>
                    <div class="properties-img" <?php if($pragraph->image == ''): ?>style="display: none"<?php endif; ?>>
                        <img src="<?php echo __ROOT__; ?>/upload/<?php echo $pragraph->image; ?>" alt="" <?php if($pragraph->image == ''): ?>style="display: none"<?php endif; ?>>
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <!-- 旅游行程 -->
                <br><br>
                <div class="w3agile properties">
                    <h3 class="w3ls-title" style="color: #8b008b;">旅游线路</h3>
                    <?php if(is_array($attractions) || $attractions instanceof \think\Collection): $mainKey = 0; $__LIST__ = $attractions;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$attraction): $mod = ($mainKey % 2 );++$mainKey;?>
                    <div class="properties-bottom">
                        <div class="properties-img">
                            <img src="<?php echo __ROOT__; ?>/upload/<?php echo $attraction->getOneImage(); ?>" alt="">
                            <div class="w3ls-buy">
                                <a href="single.html">Day<?php echo $mainKey; ?></a>
                            </div>
                            <div class="view-caption">
                                <h4><span class="glyphicon glyphicon-map-marker"></span><?php echo $attraction->trip; ?> </h4>
                            </div>
                        </div>
                        <div class="w3ls-text">
                            <p><b class="pfont">日期 :</b> <?php echo $attraction->date; ?> </p>
                            <p><b class="pfont">用餐 :</b> <?php echo $attraction->getMeals(); ?> </p>
                            <p><b class="pfont">用车 :</b> <?php echo $attraction->getCar(); ?> </p>
                            <p><b class="pfont">酒店 :</b> <?php echo $attraction->getHotelDesignation(); ?> </p>
                            <p><b class="pfont">导游 :</b> <?php echo $attraction->guide; ?> </p>
                            <p><b class="pfont">景点 :</b></p>
                                <!--弹窗-->
                                <?php if(is_array($attraction->getMaterials()) || $attraction->getMaterials() instanceof \think\Collection): $i = 0; $__LIST__ = $attraction->getMaterials();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$material): $mod = ($i % 2 );++$i;?>
                                <!-- Button trigger modal -->
                                <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal-<?php echo $mainKey; ?>-<?php echo $i; ?>">
                                <?php echo $filter->limitPreviewWordNumber($material->designation, 5); ?>
                                </a>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                <!--弹窗-->
                                <?php if(is_array($attraction->getMaterials()) || $attraction->getMaterials() instanceof \think\Collection): $i = 0; $__LIST__ = $attraction->getMaterials();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$material): $mod = ($i % 2 );++$i;?>
                                    <div class="modal fade" id="myModal-<?php echo $mainKey; ?>-<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="position: relative">
                                        <div role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel"><?php echo $material->designation; ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <!--轮播图-->
                                                    <div id="carousel-example-generic-<?php echo $mainKey; ?>-<?php echo $i; ?>" class="carousel slide" data-ride="carousel">
                                                        <ol class="carousel-indicators">
                                                            <?php if(is_array($material->getMaterialImages()) || $material->getMaterialImages() instanceof \think\Collection): $minorKey = 0; $__LIST__ = $material->getMaterialImages();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($minorKey % 2 );++$minorKey;?>
                                                            <li data-target="#carousel-example-generic-<?php echo $mainKey; ?>-<?php echo $i; ?>" data-slide-to="<?php echo $mainKey; ?>-<?php echo $i; ?>-<?php echo $minorKey; ?>" class="<?php if($minorKey == '1'): ?>active<?php endif; ?>"></li>
                                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </ol>
                                                        <div class="carousel-inner" role="listbox">
                                                            <?php if(is_array($material->getMaterialImages()) || $material->getMaterialImages() instanceof \think\Collection): $leastKey = 0; $__LIST__ = $material->getMaterialImages();if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$image): $mod = ($leastKey % 2 );++$leastKey;?>
                                                            <div class="item <?php if($leastKey == '1'): ?>active<?php endif; ?>">
                                                            <img src="<?php echo __ROOT__; ?>/upload/<?php echo $image; ?>" alt="" style="width:100%;height: 45vw">
                                                            </div>
                                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                                        </div>
                                                        <a class="left carousel-control" href="#carousel-example-generic-<?php echo $mainKey; ?>-<?php echo $i; ?>" data-slide="prev">
                                                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="right carousel-control" href="#carousel-example-generic-<?php echo $mainKey; ?>-<?php echo $i; ?>" data-slide="next">
                                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                    <!--轮播图-->
                                                    <p><?php echo $filter->limitWordNumber($material->content ); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            <p><b class="pfont">描述 :</b> <?php echo $attraction->description; ?> </p>
                        </div>
                    </div>
                    
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="clearfix"></div>
                </div>
                <?php if(is_array($paragraphDowns) || $paragraphDowns instanceof \think\Collection): $i = 0; $__LIST__ = $paragraphDowns;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_pragraph): $mod = ($i % 2 );++$i;?>
                <div class="about">
                    <h3 style="text-align: center;" class="w3ls-title"><?php echo $_pragraph->title; ?></h3> <?php echo $_pragraph->content; ?>
                    <div class="properties-img" <?php if($_pragraph->image == ''): ?>style="display: none"<?php endif; ?>>
                         <img src="<?php echo __ROOT__; ?>/upload/<?php echo $_pragraph->image; ?>">
                    </div>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                <!-- //旅游行程 -->

                <div class="contact">
                    <!-- 定制师信息 -->
                    <?php if($contractor == ''): else: ?>
                    <div class="contact-form" >
                        <br>
                        <p class="pcontact1">定制师信息</p>
                        <table class="table table-bordered">
                            <tr>
                                <th>名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;字</th>
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
                                <td><a href="mailto:<?php echo $contractor->email; ?>"><?php echo $contractor->email; ?></a></td>
                            </tr>
                            <br>
                        </table>
                    </div>
                    <?php endif; ?>
                    <br>
                    <!-- 定制师信息 -->

                    <!-- 方案报价 -->
                    <?php if(is_array($plans) || $plans instanceof \think\Collection): $i = 0; $__LIST__ = $plans;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$plan): $mod = ($i % 2 );++$i;?>
                    <div class="contact-form">
                        <p class="pcontact2">方案报价</p>
                        <p><b>出行人数 :</b> <?php echo $plan->adult_num; ?>成人 <?php echo $plan->child_num; ?>儿童 </p>
                        <p><b>币种 :</b> <?php echo $plan->currency; ?> </p>
                        <p><b>总费用 :</b> <?php echo $filter->moneyFilter($plan->total_cost ); ?> </p>
                        <p><b>最晚付款时间 :</b> <?php echo $plan->last_pay_time; ?> </p>
                        <p><b>收费分类 :</b></p>
                        <table class="table table-bordered" style="text-align: right;">
                            <tr>
                                <th>类型</th>
                                <th>机票</th>
                                <th>签证</th>
                                <th>旅游</th>
                                <th>保险</th>
                            </tr>
                            <tr>
                                <th>成人单价</th>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('plane', $plan)->adult_unit_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('visa', $plan)->adult_unit_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('tourism', $plan)->adult_unit_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('insurance', $plan)->adult_unit_price ); ?></td>
                            </tr>
                            <tr>
                                <th>儿童单价</th>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('plane', $plan)->child_unit_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('visa', $plan)->child_unit_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('tourism', $plan)->child_unit_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('insurance', $plan)->child_unit_price ); ?></td>
                            </tr>
                            <tr>
                                <th>总价</th>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('plane', $plan)->total_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('visa', $plan)->total_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('tourism', $plan)->total_price ); ?></td>
                                <td><?php echo $filter->moneyFilter($plan->getDetail('insurance', $plan)->total_price ); ?></td>
                            </tr>
                            <tr>
                                <th>备注</th>
                                <td><?php echo $plan->getDetail('plane', $plan)->remark; ?></td>
                                <td><?php echo $plan->getDetail('visa', $plan)->remark; ?></td>
                                <td><?php echo $plan->getDetail('tourism', $plan)->remark; ?></td>
                                <td><?php echo $plan->getDetail('insurance', $plan)->remark; ?></td>
                            </tr>
                        </table>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    <br>
                    <!-- 方案报价 -->
                    
                    <!--酒店信息-->
                    <div class="contact-form">
                    <br>
                        <p class="pcontact2">酒店信息</p> <?php if(is_array($hotels) || $hotels instanceof \think\Collection): $key = 0; $__LIST__ = $hotels;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotel): $mod = ($key % 2 );++$key;?>
                        <p class="title"><b><i class="glyphicon glyphicon-glass"></i> <?php echo $hotel->designation; ?> :</b></p>
                        <p><b>酒店城市：</b><?php echo $hotel->city; ?></p>
                        <p><b>星级：</b><?php echo $hotel->star_level; ?></p>
                        <p><b>备注：</b><?php echo $hotel->remark; ?></p>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                        <p>本报价按照欧元兑换人民币汇率7.98核算</p>
                        <br>
                    </div>
                    <!--酒店信息-->

                    <!-- footer -->
                    <div class="w3agile footer">
                        <div class="footer-text">
                            <p>&copy; 2016 洛克旅行 . All Rights Reserved | Design by 梦云智</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>