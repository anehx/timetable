{extends 'index.tpl'}

{block 'content'}
	{if !empty($courses)}
		{foreach $courses as $course}
			<div class="col col-xs-12 col-sm-4">
				<a href="/?action=overview&amp;id={$course->id}" title="lessons">
					<div class="col-inner">
						<h2>{$course->name}</h2>
						<i>{if $course->userID}{$course->getUser()->getDisplayName()}{else}{/if}</i>
					</div>
				</a>
			</div>
		{/foreach}
	{/if}
{/block}
