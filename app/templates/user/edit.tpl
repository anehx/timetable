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
	<form method="post" action="/?page=user&amp;action=edit">
		<div class="col-md-6">
			{if $user->id}
				<h2>Edit user '{$user->username}'</h2>
				<input type="hidden" name="id" value="{$user->id}">
			{else}
				<h2>Create a new user</h2>
			{/if}
			<div class="form-group">
				<label for="username">Username</label>
				<input class="form-control" name="username" type="text" value="{$user->username}" placeholder="Username" required {if $user->id}disabled{/if} />
			</div>
			<div class="form-group">
				<label for="firstName">First Name</label>
				<input class="form-control" name="firstName" type="text" value="{$user->firstName}" placeholder="First Name" />
			</div>
			<div class="form-group">
				<label for="lastName">Last Name</label>
				<input class="form-control" name="lastName" type="text" value="{$user->lastName}" placeholder="Last Name" />
			</div>
			<div class="form-group">
				<label for="new_password">{if $user->id}New {/if}Password</label>
				<input class="form-control" name="password" type="password" placeholder="{if $user->id}New {/if}Password" {if !$user->id}required{/if} />
			</div>
			<div class="form-group">
				<label for="confirmPassword">Confirm Password</label>
				<input class="form-control" name="confirmPassword" type="password" placeholder="Confirm Password" {if !$user->id}required{/if} />
			</div>
			<input class="btn btn-primary" type="submit" value="Save" />
		</div>
	</form>
	{/if}
{/block}