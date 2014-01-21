<div id="content_left">
	<div id="content_left_above">
	</div>
	<div id="content_left_below">
		<div id="content_left_left">
			<div class="fancybox">
				<h2 class="fancytitle">Administrators</h2>
				<form action="<?=site_url('admin/add_admin')?>" method="post">
				<h3>Add Administrator</h3>
				<table>
					<tr>
						<td>Username: </td>
						<td><input type="text" name="username" size="15" /></td>
					</tr>
					<tr>
						<td>Email Address :</td>
						<td><input type="text" name="email" size="15" /></td>
					</tr>
					<tr colspan="2">
						<td><input type="submit" value="Add Admin" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
		<div id="content_left_right">
			<div class="fancybox">
				<h2 class="fancytitle red">Settings</h2>
				<form action="<?=site_url('admin/settings')?>" method="post">
				<h3>Site Status</h3>
				<table>
					<tr>
						<td>Online</td>
						<td><input type="radio" name="online" value="1" <?=set_radio('online', '1', $settings['online'] == 1)?> /></td>
					</tr>
					<tr>
						<td>Offline</td>
						<td><input type="radio" name="online" value="0" <?=set_radio('online', '0', $settings['online'] == 0)?> /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Save Settings" /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
</div>
