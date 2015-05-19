{extends 'index.tpl'}

{block 'content'}
	{if $user}
	<form method="post" action="/?page=user&amp;action=edit{if $user->id}&amp;id={$user->id}{/if}">
		<div class="col-md-6">
			{if $user->id}
				<h2>Edit user '{$user->username}'</h2>
				<input type="hidden" name="id" value="{$user->id}">
			{else}
				<h2>Create a new user</h2>
			{/if}
			<div class="form-group">
				<label class="control-label" for="username">Username</label>
				<input class="form-control" name="username" type="text" value="{$user->username}" placeholder="Username" required {if $user->id}disabled{/if} />
			</div>
			<div class="form-group">
				<label class="control-label" for="firstName">First Name</label>
				<input class="form-control" name="firstName" type="text" value="{$user->firstName}" placeholder="First Name" />
			</div>
			<div class="form-group">
				<label class="control-label" for="lastName">Last Name</label>
				<input class="form-control" name="lastName" type="text" value="{$user->lastName}" placeholder="Last Name" />
			</div>
			{if !$user->id}
			<div class="form-group">
				<label class="control-label" for="password">Password</label>
				<input class="form-control" name="password" type="password" placeholder="Password" required />
			</div>
			<div class="form-group">
				<label class="control-label" for="confirmPassword">Confirm Password</label>
				<input class="form-control" name="confirmPassword" type="password" placeholder="Confirm Password" required />
			</div>
			{/if}
			<input class="btn btn-primary" type="submit" value="Save" />
		</div>
	</form>
	{/if}
{/block}

{block 'scripts'}
	<script type="text/javascript" src="/js/validator.js"></script>
	<script type="text/javascript" src="/js/user/edit.js"></script>
{/block}