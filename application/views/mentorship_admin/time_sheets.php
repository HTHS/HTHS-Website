<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle"><?=$user->name?>'s Timesheets</h2>
			<table border="1" width="98%">
			<tr>
				<td width="50%"><b>Date</b></td>
				<td width="25%"><b>Time In</b></td>
				<td width="25%"><b>Time Out</b></td>
			</tr>
			<? foreach($log->result() as $entry): ?>
				<tr>
					<td><?=date('F j, Y',$entry->date)?></td>
					<td><?=$entry->in_time?></td>
					<td><?=$entry->out_time?></td>
				</tr>
			<? endforeach; ?>
			</table>
		</div>
	</div>
</div>