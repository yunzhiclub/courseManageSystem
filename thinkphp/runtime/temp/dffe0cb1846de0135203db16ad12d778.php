<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:91:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\article\add.html";i:1504091850;s:85:"D:\xampp\htdocs\beautifulArtical\thinkphp\public/../application/index\view\index.html";i:1504079909;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title>文章编辑</title>
    <link rel="stylesheet" type="text/css" href="/beautifulArtical/thinkphp/public/style/css/bootstrap-3.3.7-dist/css/bootstrap.min.css">
</head>
<body>
	
	<div class="col-md-8 col-md-offset-1" style="margin-top: 60px;">
		<h2><span class="glyphicon glyphicon-edit"></span>&nbsp;文章编辑</h2>
		<br>
		<form method="post" action="<?php echo url ('add');; ?>">
			<div class="form-group">
				<label for="TitleInput">标题</label>
				<input type="text" class="form-control" id="TitleInput" placeholder="标题" name="title" >
			</div>
			<div class="form-group">
				<label for="SummaryInput">摘要</label>
				<input type="text" class="form-control" id="SummaryInput" placeholder="摘要" name="summary">
			</div>
			<div class="form-group">
				<label for="exampleInputFile">封面</label>
				<input type="file" id="exampleInputFile" name="example">
			</div>
			<div class="form-group">
				<label for="TextInput">正文</label>
				<span class="col-md-offset-1">
					<a class="btn btn-primary btn-sm" href="<?php echo url('Paragraph/index'); ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;段落</a>&nbsp;&nbsp;
					<a class="btn btn-primary btn-sm" href="<?php echo url('Attraction/add', ['id' => $Article->id]); ?>"><span class="glyphicon glyphicon-plus"></span>&nbsp;景点</a>&nbsp;&nbsp;
					<a class="btn btn-primary btn-sm" href="#"><span class="glyphicon glyphicon-plus"></span>&nbsp;方案报价</a>&nbsp;&nbsp;
					<a class="btn btn-primary btn-sm" href="#"><span class="glyphicon glyphicon-plus"></span>&nbsp;订制师</a>
				</span>
			</div>
			<ul id="foo" class="block__list block__list_words" style="list-style-type: none;">
				
				<li>
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>文章标题</h4>
						<div>
							<div class="col-md-3" style="height: 100px; border: 1px solid black;">
								<img src="#" alt="照片" >
							</div>
							<div class="col-md-9" style="height: 100px; border: 1px solid black;">
								<p>文章</p>
							</div>
							<div class="col-md-12" style="height: 40px;">
								<button class="btn btn-info btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;编辑</button>
								<button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</button>
							</div>
						</div>
						</div>
					</div>
				</li>
				<li>
					<div class="panel panel-default">
						<div class="panel-body">
							<h4>文章标题</h4>
						<div>
							<div class="col-md-3" style="height: 100px; border: 1px solid black;">
								<img src="#" alt="照片" >
							</div>
							<div class="col-md-9" style="height: 100px; border: 1px solid black;">
								<p>文章</p>
							</div>
							<div class="col-md-12" style="height: 40px;">
								<button class="btn btn-info btn-sm"><span class="glyphicon glyphicon-pencil"></span>&nbsp;编辑</button>
								<button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>&nbsp;删除</button>
							</div>
						</div>
						</div>
					</div>
				</li>
			</ul>
			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok"></span>&nbsp;完成</button>
			<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-play"></span>&nbsp;预览</button>
			<br><br>
		</form>
	</div>
	
</body>
<script src="/beautifulArtical/thinkphp/public/style/js/articleController/Sortable.js"></script>
<script src="/beautifulArtical/thinkphp/public/style/js/articleController/Configuration.js"></script>

</html>