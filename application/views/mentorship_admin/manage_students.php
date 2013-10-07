<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Students</h2>
			<p>Click on a student's name to edit that student or access their logs.</p>
			<form action="<?=current_url()?>" method="get">
			<table>
				<tr>
					<td>Year: <input type="text" name="year" value="<?=$year?>" size="4" /></td>
					<td>Semester: <select name="semester">
						<option value="1" <?=($semester == 1) ? 'selected="selected"' : ''?> >Fall</option>
						<option value="2" <?=($semester == 2) ? 'selected="selected"' : ''?> >Spring</option>
					</select></td>
					<td><input type="submit" value="Filter Results" /></td>
				</tr>
			</table>
			</form>
			<?php if($students->num_rows() == 0): ?>
				<div class="error"><p>No Students Found</p></div>
			<?php endif; ?>
			<ul>
				<?php foreach($students->result() as $user): ?>
					<li><a href="" id="student<?=$user->id?>"><?=$user->name?></a></li>
					<div id="hide<?=$user->id?>" style="display:none;" class="fancybox">
						Public Link: <input type="text" value="<?=site_url('mentorship/view/'.$user->id.'/'.$user->private_key)?>" size="50" /><br />
						<?=($user->site_visit > time()) ? 'Upcoming Site Visit On: '.date('F j, Y', $user->site_visit).'<br />' : ''?>
						<input type="button" value="View Log" onclick="window.location.href = '<?=site_url('teachers/dashboard/mentorship/view/'.$user->id)?>'" /> <input type="button" value="View Timesheets" onclick="window.location.href = '<?=site_url('teachers/dashboard/mentorship/view_times/'.$user->id)?>'" /><br /><input type="button" value="Edit Student" onclick="window.location.href = '<?=site_url('teachers/dashboard/mentorship/edit_student/'.$user->id)?>'" /> <input type="button" value="Reset Password" onclick="window.location.href = '<?=site_url('teachers/dashboard/mentorship/reset_password/'.$user->id)?>'" /> <input type="button" value="Delete Student" onclick="var c = confirm('This will remove the student <?=$user->name?> and all their logs from the system permenantly! Are you absolutely sure you want to proceed?'); if(c) { window.location.href = '<?=site_url('teachers/dashboard/mentorship/delete_student/'.$user->id)?>' }" />
					</div>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript">
	<?php foreach($students->result() as $user): ?>
		$('#student'+<?=$user->id?>).click(function(event) {
			event.preventDefault();
			$('#hide'+<?=$user->id?>).toggle('slow');
		});
	<?php endforeach; ?>
</script>