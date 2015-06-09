<nav class="navbar navbar-default">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">
				<img class="logo" src="/images/logo.png">
				<p>timetable.</p>
			</a>
		</div>

		<div class="collapse navbar-collapse" id="navbar">
			<ul class="nav navbar-nav">
				<li {if !isset($smarty.get.page)}class="active"{/if}><a href="/">Overview</a></li>
				{if isset($smarty.session.isSuperuser) && !$smarty.session.isSuperuser}
				<li {if isset($smarty.get.page) && $smarty.get.page == 'lesson'}class="active"{/if}><a href="/?page=lesson">Lessons</a></li>
				{/if}
				{if isset($smarty.session.isSuperuser) && $smarty.session.isSuperuser}
				<li {if isset($smarty.get.page) && $smarty.get.page == 'user'}class="active"{/if}><a href="/?page=user">Users</a></li>
				{/if}
				{if isset($smarty.session.isSuperuser) && $smarty.session.isSuperuser}
				<li {if isset($smarty.get.page) && $smarty.get.page == 'course'}class="active"{/if}><a href="/?page=course">Courses</a></li>
				{/if}
				{if isset($smarty.session.isSuperuser) && $smarty.session.isSuperuser}
				<li {if isset($smarty.get.page) && $smarty.get.page == 'lessonTime'}class="active"{/if}><a href="/?page=lessonTime">Lesson Times</a></li>
				{/if}
			</ul>

			<ul class="nav navbar-nav navbar-right">
				{if !isset($smarty.session.username)}
					<li {if isset($smarty.get.page) && $smarty.get.page == 'user' && isset($smarty.get.action) && $smarty.get.action == 'login'}class="active"{/if}><a href="?page=user&amp;action=login">Login</a></li>
				{else}
					<li class="hidden-xs"><p class="navbar-text login-name">Logged in as</p></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{$smarty.session.displayName} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/?page=user&amp;action=password&amp;id={$smarty.session.userID}"><i class="fa fa-key fa-lg"></i> Change password</a></li>
							<li class="divider"></li>
							<li><a href="/?page=user&amp;action=logout"><i class="fa fa-power-off fa-lg"></i> Logout</a></li>
						</ul>
					</li>
				{/if}
			</ul>
		</div>
	</div>
</nav>