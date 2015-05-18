{extends 'index.tpl'}

{block 'content'}
	<a href="/?page=lessonTime&amp;action=edit" class="btn btn-primary pull-right">Add new lesson time</a>
	{if !empty($lessonTimes)}
		<table class="table table-striped">
			<thead>
				<th>From</th>
				<th>To</th>
				<th></th>
			</thead>
			<tbody>
				{foreach $lessonTimes as $lt}
				<tr>
					<td>{$lt->startTime|date_format:'%H:%M'}</td>
					<td>{$lt->endTime|date_format:'%H:%M'}</td>
					<td class="text-right">
						<a href="/?page=lessonTime&amp;action=edit&amp;id={$lt->id}" title="Edit lesson time"><i class="fa fa-pencil fa-lg"></i></a>
						<a href="/?page=lessonTime&amp;action=delete&amp;id={$lt->id}" title="Delete lesson time"><i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}
{/block}