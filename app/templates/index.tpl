<!DOCTYPE html>
<html>
	<head>
		<title>timetable{if $title} - {$title}{/if}</title>
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="/css/main.css">
		<link href='http://fonts.googleapis.com/css?family=Raleway:100,200' rel='stylesheet' type='text/css'>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		{block 'styles'}{/block}
		<link rel="icon" href="/images/logo.png">
	</head>
	<body>
		{include 'navbar.tpl'}
		<div class="container">
			{if $messages}
				<div id="messages"><ul>
				{foreach $messages as $m}
					<div class="alert alert-{$m['type']} message">{$m['text']}</div>
				{/foreach}
				</div>
			{/if}
			{block 'content'}{/block}
		</div>
		{include 'footer.tpl'}
		<script src="/js/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/notify.js"></script>
		<script src="/js/main.js"></script>
		{block 'scripts'}{/block}
	</body>
</html>