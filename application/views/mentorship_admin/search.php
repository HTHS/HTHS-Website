<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Search Students</h2>
			<p>Click on a student's name to edit that student or access their logs.</p>
			<form action="<?=current_url()?>" method="get">
			<table>
				<tr>
					<td>Search Query: <input type="text" name="query" value="" size="25" /></td>
					<td>Search Field: <select name="field">
						<option value="0">Name</option>
						<option value="1">Email Address</option>
						<option value="2">Firm</option>
						<option value="3">Mentor</option>
						<option value="4">Tags</option>
					</select></td>
					<td><input type="submit" value="Search" /></td>
				</tr>
			</table>
			</form>
			<? if($results == ''): ?>
				<div class="error"><p>No Students Found</p></div>
			<? else: ?>
			<ul>
				<? foreach($results->result() as $user): ?>
					<li><a href="" id="student<?=$user->id?>"><?=$user->name?></a></li>
					<div id="hide<?=$user->id?>" style="display:none;" class="fancybox">
						Public Link: <input type="text" value="<?=site_url('mentorship/view/'.$user->id.'/'.$user->private_key)?>" size="50" /><br />
						<?=($user->site_visit > time()) ? 'Upcoming Site Visit On: '.date('F j, Y', $user->site_visit).'<br />' : ''?>
						<input type="button" value="View Log" onclick="window.location.href = '<?=site_url('teachers/dashboard/mentorship/view/'.$user->id)?>'" /> <input type="button" value="Edit Student" onclick="window.location.href = '<?=site_url('teachers/dashboard/mentorship/edit_student/'.$user->id)?>'" /> <input type="button" value="Delete Student" onclick="var c = confirm('This will remove the student <?=$user->name?> and all their logs from the system permenantly! Are you absolutely sure you want to proceed?'); if(c) { window.location.href = '<?=site_url('teachers/dashboard/mentorship/delete_student/'.$user->id)?>' }" />
					</div>
				<? endforeach; ?>
			</ul>
			<? endif; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	<? if($results != ''):
		foreach($results->result() as $user): ?>
			$('#student'+<?=$user->id?>).click(function(event) {
				event.preventDefault();
				$('#hide'+<?=$user->id?>).toggle('slow');
			});
	<? 		endforeach;
		endif; ?>
</script>