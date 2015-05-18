{extends 'index.tpl'}

{block 'content'}
	{if !empty($courses)}
	<div class="row">
		{foreach $courses as $course}
		<div class="col col-xs-12 col-sm-4">
			<div class="col-inner">
				<a href="" title="course">{$course->name}</a>
			</div>
		</div>
		{/foreach}
	</div>
	{/if}
{/block}
