{extends 'index.tpl'}

{block 'content'}
	<a href="/?page=user&amp;action=edit" class="btn btn-primary pull-right">Add new user</a>
	{if !empty($users)}
		<table class="table table-striped">
			<thead>
				<th>Username</th>
				<th class="hidden-xs">First Name</th>
				<th class="hidden-xs">Last Name</th>
				<th class="hidden-xs">Superuser?</th>
				<th></th>
			</thead>
			<tbody>
				{foreach $users as $user}
				<tr>
					<td>{$user->username}</td>
					<td class="hidden-xs">{$user->firstName}</td>
					<td class="hidden-xs">{$user->lastName}</td>
					<td class="hidden-xs">{if $user->isSuperuser}Yes{else}No{/if}</td>
					<td class="text-right">
						<a href="/?page=user&amp;action=password&amp;id={$user->id}" title="Change password"><i class="fa fa-key fa-lg"></i></a>
						<a href="/?page=user&amp;action=edit&amp;id={$user->id}" title="Edit user"><i class="fa fa-pencil fa-lg"></i></a>
						<a href="/?page=user&amp;action=delete&amp;id={$user->id}" title="Delete user"><i class="fa fa-trash fa-lg"></i></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}
{/block}