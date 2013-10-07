<div id="content_left">
	<div id="content_left_above">
		<?php if($user->site_visit >= mktime(0,0,0,date('n',time()),date('j',time()),date('Y',time()))): ?>
			<div class="fancybox">
				<b>You have an upcoming site visit on <?=date('F j, Y', $user->site_visit)?>.</b>
			</div>
		<?php endif; ?>
		<?php if($settings['schedule_open'] == 1 && $settings['year'] == $user->year && $settings['semester'] == $user->semester): ?>
			<div class="fancybox">
				<?php if($user->schedule_date != '0'): ?>
					<b class="success">Your presentation date is set! <a href="<?=site_url('mentorship/presentations')?>">Click here to change.</a></b>
				<?php else: ?>
					<b class="error">You have not yet set a presentation date. <a href="<?=site_url('mentorship/presentations')?>">Click here to set one.</a></b>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<div class="fancybox">
			<h2 class="fancytitle black">Add a Log Entry</h2>
			<?=validation_errors()?>
			<form action="<?=current_url()?>" method="post">
			<table>
				<tr>
					<td>Date: </td>
					<td><input type="text" name="date" id="date" size="15" value="<?=set_value('date')?>" /></td>
				</tr>
				<tr>
					<td>Times: </td>
					<td>
						<table>
							<tr>
								<td>In: </td>
								<td><input type="text" name="in" size="6" value="<?=set_value('in')?>" /></td>
								<td>Out: </td>
								<td><input type="text" name="out" size="6" value="<?=set_value('out')?>" /></td>
								<td>(hour:minutes AM/PM)</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>Activities: </td>
					<td><textarea name="activities" rows="5" cols="50"><?=nl2br(set_value('activities'))?></textarea></td>
				</tr>
				<tr>
					<td>Comments: </td>
					<td><textarea name="comments" rows="5" cols="50"><?=nl2br(set_value('comments'))?></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Submit Log" /> <input type="button" value="Change Password" onclick="window.location.href = '<?=site_url('mentorship/change_password')?>'" /> <input type="button" value="Logout" onclick="window.location.href = '<?=site_url('mentorship/logout')?>'" /></td>
				</tr>
				<tr>
					<td colspan="2">To edit or delete an existing log entry, click the date of the log entry you want to modify.</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="content_left_below">
		<div class="fancybox">
			<h2 class="fancytitle">My Log Entries</h2>
			<?php foreach($log->result() as $entry): ?>
				<h3><a href="<?=site_url('mentorship/edit/'.$entry->id)?>"><?=date('F j, Y',$entry->date)?></a></h3><br />
				<p><b>Time In:</b> <?=$entry->in_time?> <b>Time Out:</b> <?=$entry->out_time?></p>
				<p><b>Activities:</b> <?=nl2br($entry->activities)?></p><br />
				<p><b>Comments/Problems:</b> <?=nl2br($entry->comments)?></p>
				<br /><br />
			<?php endforeach; ?>
		</div>
		
		<?php if($pageLinks != ''): ?>
			<div class="fancybox">
			<?=$pageLinks?>
			</div>
		<?php endif; ?>
	</div>
</div>

<script type="text/javascript">
	$('#date').datepicker();
</script>
