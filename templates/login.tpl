{extends 'index.tpl'}

{block 'content'}
	<form method="post" action="login.php">
		<div class="login fully-center">
			<h1>Please log in!</h1>
			<div class="form-group">
				<label for="username">Username:</label>
				<input class="form-control" name="username" type="text" placeholder="Username" autofocus required />
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input class="form-control" name="password" type="password" placeholder="Password" />
			</div>
			<button class="btn btn-primary">Login</button>
			{if $errors}
				<div class="alert alert-danger">
					<ul>
					{foreach $errors as $error}
						<li>{$error}</li>
					{/foreach}
					</ul>
				</div>
			{/if}
		</div>
	</form>
{/block}