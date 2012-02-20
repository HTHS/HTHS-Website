<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Change Teacher Password</h2>
			<?=validation_errors()?>
			<p>Please enter your password and desired new password below:</p>
			<br />
			<form name="login" action="<?=current_url()?>" method="post">
				<table>
					<tr>
						<td>Current Password:</td>
						<td><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td>New Password:</td>
						<td><input type="password" name="new_password" /></td>
					</tr>
					<tr>
						<td>Confirm New Password:</td>
						<td><input type="password" name="confirm" /></td>
					<tr>
						<td colspan="2"><input type="submit" value="Change Password" /> <input type="button" value="Cancel" onclick="window.location.href = '<?=site_url('teacher_dashboard')?>'" /></td>
					</tr>
				</table>
	        </form>
		</div>
	</div>
</div>
