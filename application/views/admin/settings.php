<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Site Settings</h2>
			<form action="<?=current_url()?>" method="post">
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
					<td>Message </td>
					<td><textarea name="message" rows="6" cols="55"><?=$settings['offline_message']?></textarea>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Save Settings" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
