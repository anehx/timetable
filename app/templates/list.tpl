{extends 'index.tpl'}

{block 'content'}
	<div id="time"></div>
	{if $course}
		<h2>course '{$course->name}'</h2>
		<table class="table table-striped">
			<thead>
				<th></th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
			</thead>
			<tbody>
				{foreach $lessonTimes as $lt}				
				<tr>
					<td>{$lt->startTime|date_format:'%H:%M'} - {$lt->endTime|date_format:'%H:%M'}</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				{/foreach}
			</tbody>
		</table>		
	{/if}
{/block}

{block 'scripts'}
<script src="/js/time.js" type="text/javascript"></script>
{/block}