<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Add Teacher</h2>
			<form action="<?=current_url()?>" method="post">
				<?=validation_errors()?>
				<p>Please enter the desired user information for the teacher to be added. A password will be emailed once the account is added.</p>
				<br />
				<table>
					<tr>
						<td>First name: </td>
						<td><input type="text" name="first" size="35" value="<?=set_value('name')?>" /></td>
					</tr>
					<tr>
						<td>Last name: </td>
						<td><input type="text" name="last" size="35" value="<?=set_value('name')?>" /></td>
					</tr>
					<tr>
						<td>Email Address: </td>
						<td><input type="text" name="email" size="35" value="<?=set_value('email')?>" /></td>
					</tr>
					<tr>
						<td>Subject: </td>
						<td><input type="text" name="subject" size="35" value="<?=set_value('subject')?>" /></td>
					</tr>
					<tr>
						<td>Voicemail: </td>
						<td><input type="text" name="voicemail" size="10" value="<?=set_value('voicemail')?>" /></td>
					</tr>
					<tr>
						<td>Mentorship Admin? </td>
						<td><input type="checkbox" name="mentorship" value="1" <?=set_checkbox('mentorship', '1')?> /></td>
					</tr>
					<tr colspan="2">
						<td><input type="submit" value="Add Teacher" /></td>
					</tr>
				</table>
				</form>
		</div>
	</div>
</div>