{extends 'index.tpl'}

{block 'content'}
	{if $errors}
		<div class="alert alert-danger"><ul>
		{foreach $errors as $error}
			<li>{$error}</li>
		{/foreach}
		</ul></div>
	{/if}
	{if $user}
	<form method="post" action="edit.php">
		<div class="col-md-6">
			{if $user->id}
				<h2>Edit user '{$user->username}'</h2>
				<input type="hidden" name="user_id" value="{$user->id}">
			{else}
				<h2>Create a new user</h2>
			{/if}
			<div class="form-group">
				<label for="username">Username</label>
				<input class="form-control" name="username" type="text" value="{$user->username}" placeholder="Username" {if $user->id}disabled{/if} />
			</div>
			<div class="form-group">
				<label for="first_name">First Name</label>
				<input class="form-control" name="first_name" type="text" value="{$user->first_name}" placeholder="First Name" />
			</div>
			<div class="form-group">
				<label for="last_name">Last Name</label>
				<input class="form-control" name="last_name" type="text" value="{$user->last_name}" placeholder="Last Name" />
			</div>
			<div class="form-group">
				<label for="password">New Password</label>
				<input class="form-control" name="password" type="password" placeholder="Password" />
			</div>
			<div class="form-group">
				<label for="password_confirm">Confirm Password</label>
				<input class="form-control" name="password_confirm" type="password" placeholder="Confirm Password" />
			</div>
			<input class="btn btn-primary" type="submit" value="Save" />
		</div>
	</form>
	{/if}
{/block}