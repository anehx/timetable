{extends 'index.tpl'}

{block 'content'}
	{if $errors}
		<div class="alert alert-danger"><ul>
		{foreach $errors as $error}
			<li>{$error}</li>
		{/foreach}
		</ul></div>
	{/if}
	{if $course}
	<form method="post" action="/?page=course&amp;action=edit{if $course->id}&amp;id={$course->id}{/if}">
		<div class="col-md-6">
			{if $course->id}
				<h2>Edit course '{$course->name}'</h2>
			{else}
				<h2>Create a new course</h2>
			{/if}
			<div class="form-group">
				<label class="control-label" for="name">Name</label>
				<input class="form-control" name="name" type="text" value="{$course->name}" placeholder="Name" required />
			</div>
			<div class="form-group">
				<label class="control-label" for="userID">User</label>
				<select class="form-control" name="userID" type="text" required>
					{foreach $users as $user}
					<option value="{$user->id}">{$user->getDisplayName()}</option>
					{/foreach}
				</select>
			</div>
			<input class="btn btn-primary" type="submit" value="Save" />
		</div>
	</form>
	{/if}
{/block}