{extends 'index.tpl'}

{block 'content'}
	{include 'time.tpl'}
	{if $course}
		<table class="table table-striped hidden-xs">
			<thead>
				<th>Course {$course->name}</th>
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
		{foreach $weekdays as $k => $v}
			<table class="table table-striped visible-xs">
				<thead>
					<th>Course {$course->name}</th>
					<th>{$v}</th>
				</thead>
				<tbody>
					{foreach $lessonTimes as $lt}				
						<tr>
							<td>{$lt->getDisplayName()}</td>
							<td>{foreach $lessons as $lesson}{if $k === $lesson->weekday && $lesson->lessonTimeID === $lt->id}{$lesson->name}{/if}{/foreach}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>	
		{/foreach}		
	{/if}
{/block}

{block 'scripts'}
	<script type="text/javascript" src="/js/time.js"></script>
{/block}