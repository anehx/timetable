<!DOCTYPE html>
<html>
	<head>
		<title>timetable</title>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/css/main.css">
		<link href='http://fonts.googleapis.com/css?family=Raleway:100,200' rel='stylesheet' type='text/css'>
		{block 'styles'}{/block}
	</head>
	<body>
		{include 'navbar.tpl'}
		<div class="container">
			{block 'content'}{/block}
		</div>
		<script src="/js/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		{block 'scripts'}{/block}
	</body>
</html>