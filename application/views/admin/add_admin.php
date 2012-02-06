<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Add Administrator</h2>
			<form action="<?=current_url()?>" method="post">
				<?=validation_errors()?>
				<p>Please enter the desired username and email address for the administrator to be added. A password will be emailed once the account is added.</p>
				<br />
				<table>
					<tr>
						<td>Username: </td>
						<td><input type="text" name="username" size="35" value="<?=set_value('username')?>" /></td>
					</tr>
					<tr>
						<td>Email Address :</td>
						<td><input type="text" name="email" size="35" value="<?=set_value('email')?>" /></td>
					</tr>
					<tr colspan="2">
						<td><input type="submit" value="Add Admin" /></td>
					</tr>
				</table>
				</form>
		</div>
	</div>
</div>