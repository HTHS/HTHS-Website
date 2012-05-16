<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle">Schedule a Presentation</h2>
			<?=validation_errors()?>
			<form action="<?=current_url()?>" method="post">
			<p>Please select one of the dates below for your mentorship presentation date.</p>
			<table cellpadding="5" border="1" width="98%">
				<? foreach($dates->result() as $date): ?>
					<tr>
						<td width="20%">
							<? if($date->name != null && $date->name != $user->name): ?>
								<b class="error">Unavailable</b>
							<? elseif($date->name == $user->name): ?>
								<input type="radio" name="date" value="<?=$date->id?>" checked="checked" />
							<? else: ?>
								<input type="radio" name="date" value="<?=$date->id?>" />
							<? endif; ?>
						</td>
						<td><?=date('F j, Y', $date->date)?> <?=$date->time?></td>
					</tr>
				<? endforeach; ?>
				<? if($user->schedule_date == '0'): ?>
					<tr>
						<td><input type="radio" name="date" value="0" checked="checked" /></td>
						<td>Undecided</td>
					</tr>
				<? else: ?>
					<tr>
						<td><input type="radio" name="date" value="0" /></td>
						<td>Undecided</td>
					</tr>
				<? endif; ?>
			</table>
			<br />
			<input type="submit" value="Save!" /> <input type="button" onclick="window.location.href = '<?=site_url('mentorship')?>'" value="Cancel" />
			</form>
		</div>
	</div>
</div>