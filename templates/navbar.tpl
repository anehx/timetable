<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">timetable.</a>
		</div>

		<div class="collapse navbar-collapse" id="navbar">
			<ul class="nav navbar-nav">
				{if isset($smarty.session.is_superuser) && $smarty.session.is_superuser}<li><a href="/user/">Users</a></li>{/if}
			</ul>

			<ul class="nav navbar-nav navbar-right">
				{if !isset($smarty.session.username)}<li><a href="/login.php">Login</a></li>
				{else}
				<li><p class="navbar-text">Logged in as {$smarty.session.username}</p></li>
				<li><a href="/logout.php"><span class="glyphicon glyphicon-off"></span></a></li>{/if}
			</ul>
		</div>
	</div>
</nav>