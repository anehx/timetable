{extends 'index.tpl'}

{block 'content'}
	<a href="/?page=lesson&amp;action=edit&amp;courseID={$courseID}" class="btn btn-primary pull-right">Add new lesson</a>
	{if !empty($lessons)}
		<table class="table table-striped">
			<thead>
				<th>Name</th>
				<th>Weekday</th>
				<th>From</th>
				<th>To</th>
				<th></th>
			</thead>
			<tbody>
				{foreach $lessons as $lesson}
				<tr>
					<td>{$lesson->name}</td>
					<td>{$lesson->getWeekday()}</td>
					<td>{$lesson->getLessonTime()->startTime|date_format:'%H:%M'}</td>
					<td>{$lesson->getLessonTime()->endTime|date_format:'%H:%M'}</td>
					<td class="text-right">
						<a href="/?page=lesson&amp;action=edit&amp;id={$lesson->id}" title="Edit lesson"><i class="fa fa-pencil fa-lg"></i></a>
						<a href="/?page=lesson&amp;action=delete&amp;id={$lesson->id}" title="Delete lesson"><i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}
{/block}