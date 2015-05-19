{extends 'index.tpl'}

{block 'content'}
	{if !empty($courses)}
	<div class="row">
		{foreach $courses as $course}
		<div class="col col-xs-12 col-sm-4">
			<div class="col-inner col-inner-edit">
				<a href="/?page=lesson&amp;action=list&amp;courseID={$course->id}" title="course">{$course->name}</a>
			</div>
		</div>
		{/foreach}
	</div>
	{/if}
{/block}