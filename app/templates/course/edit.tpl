{extends 'index.tpl'}

{block 'content'}
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
					<option value="0">-- Select User --</option>
					{foreach $users as $user}
					<option value="{$user->id}" {if $user->id === $course->userID}selected{/if}>{$user->getDisplayName()}</option>
					{/foreach}
				</select>
			</div>
			<input class="btn btn-primary" type="submit" value="Save" />
		</div>
	</form>
	{/if}
{/block}

{block 'scripts'}
<script type="text/javascript" src="/js/validator.js"></script>
<script type="text/javascript" src="/js/course/edit.js"></script>
{/block}