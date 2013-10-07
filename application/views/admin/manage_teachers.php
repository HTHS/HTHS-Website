<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Teachers</h2>
			<?php if(isset($_GET['error'])): ?>
				<div class="error">
					<p>An error occured, the teacher was not edited.</p>
				</div>
				<br />
			<?php endif; ?>
			<p>Click an teacher's name to edit or remove that teacher.</p>
			<ul>
				<?php foreach($teachers->result() as $teacher): ?>
					<li><a href="" id="teacher<?=$teacher->id?>"><?=$teacher->prefix.' '.$teacher->first_name.' '.$teacher->last_name.' '.$teacher->suffix?></a></li>
					<div id="teacherHide<?=$teacher->id?>" style="display:none;" class="fancybox">
					<form action="<?=site_url('admin/edit_teacher/'.$teacher->id)?>" method="post">
						<table>
							<tr>
								<td>First Name: </td>
								<td><input type="text" name="first" size="35" value="<?=$teacher->first_name?>" /></td>
							</tr>
							<tr>
								<td>Last Name: </td>
								<td><input type="text" name="last" size="35" value="<?=$teacher->last_name?>" /></td>
							</tr>
							<tr>
								<td>Prefix: </td>
								<td><input type="text" name="prefix" size="10" value="<?=$teacher->prefix?>" /> Suffix: <input type="text" name="suffix" size="10" value="<?=$teacher->suffix?>" /></td>
							</tr>
							<tr>
								<td>Login Name: </td>
								<td><?=$teacher->username?><input type="hidden" name="old_username" value="<?=$teacher->username?>" /></td>
							</tr>
							<tr>
								<td>Email Address: </td>
								<td><input type="text" name="email" size="35" value="<?=$teacher->email?>" /></td>
							</tr>
							<tr>
								<td>Subject: </td>
								<td><input type="text" name="subject" size="35" value="<?=$teacher->subject?>" /></td>
							</tr>
							<tr>
								<td>Voicemail: </td>
								<td><input type="text" name="voicemail" size="10" value="<?=$teacher->voicemail?>" /></td>
							</tr>
							<tr>
								<td>Mentorship Admin? </td>
								<td><input type="checkbox" name="mentorship" value="1" <?=set_checkbox('mentorship', '1', $teacher->mentorship_admin == 1)?> /></td>
							</tr>
							<tr>
								<td colspan="2"><input type="submit" value="Save Changes" /> <input type="button" value="Reset Password" onclick="window.location.href = '<?=site_url('admin/reset_teacher_password/'.$teacher->id)?>'" /> <input type="button" value="Delete Teacher" onclick="window.location.href = '<?=site_url('admin/delete_teacher/'.$teacher->id)?>'" /> <input type="button" value="Cancel" id="cancel<?=$teacher->id?>" /></td>
							</tr>
						</table>
					</form>
					</div>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript">
	<?php foreach($teachers->result() as $teacher): ?>
		$('#teacher'+<?=$teacher->id?>).click(function(event) {
			event.preventDefault();
			$('#teacherHide'+<?=$teacher->id?>).toggle('slow');
		});
		$('#cancel'+<?=$teacher->id?>).click(function() {
			$('#teacherHide'+<?=$teacher->id?>).hide('slow');
		});
	<?php endforeach; ?>
</script>