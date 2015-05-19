{extends 'index.tpl'}

{block 'content'}
	{if $lesson}
	<form method="post" action="/?page=lesson&amp;action=edit{if $course}&amp;courseID={$course->id}{/if}{if $lesson->id}&amp;id={$lesson->id}{/if}">
		<div class="col-md-6">
			{if $lesson->id}
				<h2>Edit lesson '{$lesson->name}'</h2>
			{else}
				<h2>Create a new lesson</h2>
			{/if}
			<div class="form-group">
				<label class="control-label" for="name">Name</label>
				<input class="form-control" name="name" type="text" value="{$lesson->name}" placeholder="Name" required />
			</div>
			<div class="form-group">
				<label class="control-label" for="weekday">Weekday</label>
				<select class="form-control" name="weekday" type="text" required>
					<option value="0">-- Select Weekday --</option>
					{foreach $weekdays as $k => $v}
					<option value="{$k}" {if $lesson->weekday === $k}selected{/if}>{$v}</option>
					{/foreach}
				</select>
			</div>
			<div class="form-group">
				<label class="control-label" for="lessonTimeID">Lesson Time</label>
				<select class="form-control" name="lessonTimeID" type="text" required>
					<option value="0">-- Select Lesson Time --</option>
					{foreach $lessonTimes as $lt}
					<option value="{$lt->id}" {if $lesson->lessonTimeID === $lt->id}selected{/if}>{$lt->getDisplayName()}</option>
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
	<script type="text/javascript" src="/js/lesson/edit.js"></script>
{/block}