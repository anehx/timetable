{extends 'index.tpl'}

{block 'content'}
	<form method="post" action="?page=user&amp;action=login">
		<div class="login fully-center">
			<img class="logo" src="/images/logo.png">
			<h1>Please log in!</h1>
			<div class="form-group">
				<label for="username">Username:</label>
				<input class="form-control" name="username" type="text" placeholder="Username" autofocus required />
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input class="form-control" name="password" type="password" placeholder="Password" required />
			</div>
			<button class="btn btn-primary">Login</button>
		</div>
	</form>
{/block}