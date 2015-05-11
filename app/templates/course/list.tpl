{extends 'index.tpl'}

{block 'content'}
	<div class="row">
		<a href="/?page=course&amp;action=edit" class="btn btn-primary pull-right">Add new course</a>
	</div>
	{if !empty($courses)}
	<div class="row">
		<table class="table table-striped">
			<thead>
				<th>Name</th>
				<th>User</th>
				<th></th>
			</thead>
			<tbody>
				{foreach $courses as $course}
				<tr>
					<td>{$course->name}</td>
					<td>{$course->getUser()->getDisplayName()}</td>
					<td class="text-right">
						<a href="/?page=course&amp;action=edit&amp;id={$course->id}" title="Edit course"><i class="fa fa-pencil fa-lg"></i></a>
						<a href="/?page=course&amp;action=delete&amp;id={$course->id}" title="Delete course"><i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
	{/if}
{/block}