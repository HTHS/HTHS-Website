<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">HTHS News</h2>
			<h3>News Quick Add</h3>
			<form action="<?=site_url('admin/add_news')?>" method="post">
			<table>
				<tr>
					<td>Title: </td>
					<td><input type="text" name="title" value="" size="35" /></td>
				</tr>
				<tr>
					<td>Contents: </td>
					<td><textarea name="contents" rows="3" cols="52"></textarea></td>
				</tr>
				<tr>
					<td>Begins On: </td>
					<td><input type="text" name="start" id="start" value="<?=date('m/d/Y',time())?>" size="25" /></td>
				</tr>
				<tr>
					<td>Ends On: </td>
					<td><input type="text" name="expires" id="expires" value="" size="25" /> <a href="" id="clearExpires">(Click Here if No End Date)</a></td>
				</tr>
				<tr>
					<td>Urgent? </td>
					<td><input type="checkbox" name="urgent" value="1" /></td>
				</tr>
				<tr>
					<td>Email? </td>
					<td><input type="checkbox" name="email" value="1" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add News" /></td>
				</tr>
			</table>
			</form>
		</div>
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
						<td>Offline </td>
						<td><input type="radio" name="online" value="0" <?=set_radio('online', '0', $settings[0]['setting_value'] == 0)?> /></td>
					</tr>
					<tr>
						<td>Online </td>
						<td><input type="radio" name="online" value="1" <?=set_radio('online', '1', $settings[0]['setting_value'] == 1)?> /></td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#start').datepicker();
	$('#expires').datepicker();
	$('#clearExpires').click(function(event) {
		event.preventDefault();
		$('#expires').val('');
	});
</script>