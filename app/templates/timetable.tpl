{extends 'index.tpl'}

{block 'content'}
	{include 'time.tpl'}
	{if $course}
		<table class="table table-striped hidden-xs" id="timetable">
			<thead>
				<th>Course {$course->name}</th>
				{foreach $weekdays as $d}
					<th>{$d}</th>
				{/foreach}
			</thead>
			<tbody>
				{foreach $lessonTimes as $lt}
					<tr
					 data-time-from="{$lt->startTime|date_format:'%H:%M'}"
					 data-time-to="{$lt->endTime|date_format:'%H:%M'}"
					>
						<td>{$lt->getDisplayName()}</td>
						{foreach $weekdays as $k => $v}
							<td data-weekday="{$k}">{foreach $lessons as $lesson}{if $k === $lesson->weekday && $lesson->lessonTimeID === $lt->id}{$lesson->name}{/if}{/foreach}</td>
						{/foreach}
					</tr>
				{/foreach}
			</tbody>
		</table>
		<div class="visible-xs">
		{foreach $weekdays as $k => $v}
			<table class="table table-striped" id="timetable-wd-{$k}">
				<thead>
					<th class="col-xs-4">Course {$course->name}</th>
					<th>{$v}</th>
				</thead>
				<tbody>
					{foreach $lessonTimes as $lt}
						<tr
						 data-time-from="{$lt->startTime|date_format:'%H:%M'}"
						 data-time-to="{$lt->endTime|date_format:'%H:%M'}"
						>
							<td>{$lt->getDisplayName()}</td>
							<td class="lesson">{foreach $lessons as $lesson}{if $k === $lesson->weekday && $lesson->lessonTimeID === $lt->id}{$lesson->name}{/if}{/foreach}</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		{/foreach}
		</div>
	{/if}
{/block}

{block 'scripts'}
	<script type="text/javascript" src="/js/time.js"></script>
{/block}