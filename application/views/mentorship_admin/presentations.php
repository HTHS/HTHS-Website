<div id="content_left">
	<div id="content_left_above">
	<div class="fancybox">
			<h2 class="fancytitle">Presentation Schedule</h2>
			<?php foreach($sch as $date => $day): ?>
				<h3><?=date('F j, Y', $date)?></h3>
				<br />
				<?php foreach($day as $key => $entry): ?>
					<b>Time: <?=$entry->time?></b><br />
					Student: <?=$entry->name?><br />
					Mentor: <?=$entry->mentor?><br />
					Firm: <?=$entry->firm?>
					<br /><br />
				<?php endforeach; ?>
			<?php endforeach; ?>
		</div>

		<div class="fancybox">
				<h2 class="fancytitle black">Students Not Signed Up</h2>
					<ul>
						<?php foreach($missing->result() as $student): ?>
							<li><?=$student->name?></li>
						<?php endforeach; ?>
					</ul>
		</div>
	</div>
	<div id="content_left_below">
		<div class="fancybox">
			<h2 class="fancytitle">Dates</h2>
				<form action="<?=current_url()?>" method="post">
				<input type="hidden" name="deleted" id="deleted" value="" />
				<?php foreach($sl as $date => $day): ?>
					<h3><?=date('F j, Y', $date)?></h3>
					<ul>
						<?php foreach($day as $key => $entry): ?>
							<div id="old<?=$entry->id?>">
								<input type="hidden" name="id::<?=$key?>" value="<?=$entry->id?>" />
								<li>Date: <input type="text" id="date<?=$key?>" name="date::<?=$key?>" size="20" value="<?=unix_to_friendly($entry->date)?>" /> Time: <input type="text" name="time::<?=$key?>" size="20" value="<?=$entry->time?>" /> <a onclick="del('<?=$entry->id?>');">Delete</a></li>
							</div>
							<script type="text/javascript">
								$('#date'+<?=$key?>).datepicker();
							</script>
						<?php endforeach; ?>
					</ul>
				<?php endforeach; ?>
				<h3>New Times</h3>
				<ul id="new_times">
				</ul>
				<input type="button" onclick="addTime();" value="Add" />
				<input type="submit" value="Save" />
				</form>
		</div>
	</div>
</div>

<script type="text/javascript">
counter = 0;
function addTime() {
	var time = '<div id="new'+counter+'"><input type="hidden" name="id::n'+counter+'" value="null" /> <li>Date: <input type="text" id="ndate'+counter+'" name="date::n'+counter+'" size="20" value="" /> Time: <input type="text" name="time::n'+counter+'" size="20" value="" /> <a onclick="rm(\''+counter+'\');">Remove</a></li></div>';
	$('#new_times').append(time);
	$('#ndate'+counter).datepicker();
	counter++;
}
function rm(id) {
	$('#new'+id).detach();
}
function del(id) {
	$('#old'+id).detach();
	$('#deleted').val($('#deleted').val()+id+',');
}
</script>