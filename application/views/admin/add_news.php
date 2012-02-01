<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Add News</h2>
			<?=validation_errors()?>
			<form action="<?=current_url()?>" method="post">
			<table>
				<tr>
					<td>Title: </td>
					<td><input type="text" name="title" value="<?=set_value('title')?>" size="35" /></td>
				</tr>
				<tr>
					<td>Contents: </td>
					<td>
						<input type="hidden" id="contentshidden" name="contents" value="<?=set_value('contents')?>" />
						<a href="" id="openEditor">Open Editor</a>
						<div id="contentsPopup">
							<textarea id="contents" rows="10" cols="80"><?=set_value('contents')?></textarea>
						</div>
					</td>
				</tr>
				<tr>
					<td>Begins On: </td>
					<td><input type="text" name="start" id="start" value="<?=set_value('start', date('m/d/Y',time()))?>" size="25" /></td>
				</tr>
				<tr>
					<td>Ends On: </td>
					<td><input type="text" name="expires" id="expires" value="<?=set_value('expires', 0)?>" size="25" /> <a href="" id="clearExpires">(Click Here if No End Date)</a></td>
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
</div>

<script type="text/javascript">
	$('#start').datepicker();
	$('#expires').datepicker();
	$('#contentsPopup').dialog({ 
		autoOpen: false, 
		title: "Newspost Editor", 
		width: 800,
		close: function() { $('#contentshidden').val(CKEDITOR.instances.contents.getData()); }
	});
	CKEDITOR.replace('contents');
	$('#openEditor').click(function(event) {
		event.preventDefault();
		$('#contentsPopup').dialog('open');
	});
	$('#clearExpires').click(function(event) {
		event.preventDefault();
		$('#expires').val('');
	});
</script>