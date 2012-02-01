<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Administrator Login</h2>
			<?=validation_errors()?>
			<p>Please enter your administrator username and password below:</p>
			<br />
			<form name="login" action="<?=current_url()?>" method="post">
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" value="<?=set_value('username')?>" /></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" /></td>
					<tr>
						<td colspan="2"><input type="submit" value="Login" /></td>
					</tr>
				</table>
	        </form>
		</div>
	</div>
</div>
