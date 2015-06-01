{extends 'index.tpl'}

{block 'content'}
	<div id="time" class="center-text"></div>
	{if $course}
		<h1 class="center-text">{$course->name}</h1>
		<table class="table table-striped">
			<thead>
				<th></th>
				{foreach $weekdays as $d}
					<th>{$d}</th>
				{/foreach}
			</thead>
			<tbody>
				{foreach $lessonTimes as $lt}				
					<tr>
						<td>{$lt->getDisplayName()}</td>
						{foreach $weekdays as $k => $v}
							<td>{foreach $lessons as $lesson}{if $k === $lesson->weekday && $lesson->lessonTimeID === $lt->id}{$lesson->name}{/if}{/foreach}</td>
						{/foreach}
					</tr>
				{/foreach}
			</tbody>
		</table>		
	{/if}
{/block}

{block 'scripts'}
<script src="/js/time.js" type="text/javascript"></script>
{/block}