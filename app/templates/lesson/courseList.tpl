{extends 'index.tpl'}

{block 'content'}
	{if !empty($courses)}
	<div class="row">
		{foreach $courses as $course}
		<div class="col col-xs-12 col-sm-4">
			<a href="/?page=lesson&amp;action=list&amp;courseID={$course->id}" title="course">
				<div class="col-inner col-inner-edit">
					<h2>{$course->name}</h2>
					<i>{if $course->userID}{$course->getUser()->getDisplayName()}{else}{/if}</i>
				</div>
			</a>
		</div>
		{/foreach}
	</div>
	{/if}
{/block}