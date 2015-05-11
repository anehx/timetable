<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/"><img id="logo" src="/images/logo.png">timetable.</a>
		</div>

		<div class="collapse navbar-collapse" id="navbar">
			<ul class="nav navbar-nav">
				<li><a href="/">Overview</a></li>
				{if isset($smarty.session.is_superuser) && $smarty.session.is_superuser}<li><a href="/?page=user">Users</a></li>{/if}
				{if isset($smarty.session.is_superuser) && $smarty.session.is_superuser}<li><a href="/?page=course">Courses</a></li>{/if}
			</ul>

			<ul class="nav navbar-nav navbar-right">
				{if !isset($smarty.session.username)}<li><a href="?page=user&amp;action=login">Login</a></li>
				{else}
				<li><p class="navbar-text">Logged in as {$smarty.session.username}</p></li>
				<li><a href="?page=user&amp;action=logout"><i class="fa fa-power-off fa-lg"></i></a></li>{/if}
			</ul>
		</div>
	</div>
</nav>