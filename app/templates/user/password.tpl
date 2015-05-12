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
	<form method="post" action="/?page=user&amp;action=password&amp;id={$user->id}">
		<div class="col-md-6">
			<h2>Change password of '{$user->username}'</h2>
			{if !$smarty.session.isSuperuser}
			<div class="form-group">
				<label class="control-label" for="oldPassword">Old Password</label>
				<input class="form-control" name="oldPassword" type="password" placeholder="Old Password" required />
			</div>
			{/if}
			<div class="form-group">
				<label class="control-label" for="password">New Password</label>
				<input class="form-control" name="password" type="password" placeholder="New Password" required />
			</div>
			<div class="form-group">
				<label class="control-label" for="confirmPassword">Confirm Password</label>
				<input class="form-control" name="confirmPassword" type="password" placeholder="Confirm Password" required />
			</div>
			<input class="btn btn-primary" type="submit" value="Save" />
		</div>
	</form>
	{/if}
{/block}