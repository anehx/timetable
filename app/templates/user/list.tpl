{extends 'index.tpl'}

{block 'content'}
	<div class="row">
		<a href="/?page=user&amp;action=edit" class="btn btn-primary pull-right">Add new user</a>
	</div>
	<div class="row">
		<table class="table table-striped">
			<thead>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Superuser?</th>
				<th></th>
			</thead>
			<tbody>
			{if !empty($users)}
				{foreach $users as $user}
				<tr>
					<td>{$user->username}</td>
					<td>{$user->first_name}</td>
					<td>{$user->last_name}</td>
					<td>{if $user->is_superuser}Yes{else}No{/if}</td>
					<td class="text-right">
						<a href="/?page=user&amp;action=edit&amp;id={$user->id}" title="Edit user"><i class="fa fa-pencil fa-lg"></i></a>
						<a href="/?page=user&amp;action=delete&amp;id={$user->id}" title="Delete user"><i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				{/foreach}
			{/if}
			</tbody>
		</table>
	</div>
{/block}