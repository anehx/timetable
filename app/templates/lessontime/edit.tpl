{extends 'index.tpl'}

{block 'content'}
	{if $lessonTime}
	<form method="post" action="/?page=lessonTime&amp;action=edit{if $lessonTime->id}&amp;id={$lessonTime->id}{/if}">
		<div class="col-md-6">
			{if $lessonTime->id}
				<h2>Edit lesson time '{$lessonTime->getDisplayName()}'</h2>
			{else}
				<h2>Create a new lesson time</h2>
			{/if}
			<div class="form-group">
				<label class="control-label" for="startTime">Start Time</label>
				<input id="test" class="form-control timepicker" name="startTime" type="text" value="{$lessonTime->startTime|date_format:'%H:%M'}" placeholder="Start Time" required />
			</div>
			<div class="form-group">
				<label class="control-label" for="endTime">End Time</label>
				<input class="form-control timepicker" name="endTime" type="text" value="{$lessonTime->endTime|date_format:'%H:%M'}" placeholder="End Time" required />
			</div>
			<input class="btn btn-primary" type="submit" value="Save" />
		</div>
	</form>
	{/if}
{/block}

{block 'styles'}
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-timepicker.min.css">
{/block}

{block 'scripts'}
	<script type="text/javascript" src="/js/bootstrap-timepicker.min.js"></script>
	<script type="text/javascript" src="/js/validator.js"></script>
	<script type="text/javascript" src="/js/lessontime/edit.js"></script>
{/block}