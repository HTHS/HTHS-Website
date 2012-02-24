<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage News</h2>
			<? foreach($news as $row): ?>
				<h3><a href="" id="show<?=$row->id?>"><?=$row->title?></a> <? if($row->urgent == 1): ?>(Urgent)<? endif; ?></h3>
				<div style="display:none;" id="contentsDiv<?=$row->id?>">
					<form action="<?=site_url('admin/edit_news/'.$row->id)?>" method="post">
					<input type="hidden" name="id" value="<?=$row->id?>" />
					<table>
						<tr>
							<td>Title: </td>
							<td><input type="text" name="title" value="<?=$row->title?>" size="35" /></td>
						</tr>
						<tr>
							<td>Contents: </td>
							<td>
								<input type="hidden" id="contentshidden<?=$row->id?>" name="contents" value="<?=form_prep($row->contents)?>" />
								<a href="" id="openEditor<?=$row->id?>">Open Editor</a>
								<div id="contentsPopup<?=$row->id?>">
									<textarea id="contents<?=$row->id?>" rows="10" cols="80"><?=$row->contents?></textarea>
								</div>
							</td>
						</tr>
						<tr>
							<td>Begins On: </td>
							<td><input type="text" name="start" id="start<?=$row->id?>" value="<?=unix_to_friendly($row->start)?>" size="25" /></td>
						</tr>
						<tr>
							<td>Ends On: </td>
							<td><input type="text" name="expires" id="expires<?=$row->id?>" value="<?=unix_to_friendly($row->expires)?>" size="25" /> <a href="" id="clearExpires<?=$row->id?>">(Click Here if No End Date)</a></td>
						</tr>
						<tr>
							<td>Urgent? </td>
							<td><input type="checkbox" name="urgent" value="1" <?=set_checkbox('urgent', '1', $row->urgent)?> /></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="Save Changes" /> <input type="button" value="Delete News" onclick="window.location.href = '<?=site_url('admin/delete_news/'.$row->id)?>'" /> <input type="button" id="cancel<?=$row->id?>" value="Cancel" /></td>
						</tr>
					</table>
					</form>
				</div>
				<br />
				<br />
			<? endforeach; ?>
		</div>
	</div>
</div>

<script type="text/javascript">
	<? foreach($news as $row): ?>
		$('#show'+<?=$row->id?>).click(function(event) {
			event.preventDefault();
			$('#contentsDiv'+<?=$row->id?>).show('slow');
		});
		CKEDITOR.replace('contents'+<?=$row->id?>);
		$('#contentsPopup'+<?=$row->id?>).dialog({ 
			autoOpen: false, 
			title: "Newspost Editor", 
			width: 800,
			close: function() { $('#contentshidden'+<?=$row->id?>).val(CKEDITOR.instances.contents<?=$row->id?>.getData()); }
		});
		$('#openEditor'+<?=$row->id?>).click(function(event) {
			event.preventDefault();
			$('#contentsPopup'+<?=$row->id?>).dialog('open');
		});
		$('#cancel'+<?=$row->id?>).click(function() {
			$('#contentsDiv'+<?=$row->id?>).hide('slow');
		});
		$('#clearExpires'+<?=$row->id?>).click(function(event) {
			event.preventDefault();
			$('#expires'+<?=$row->id?>).val('');
		});
		$('#start'+<?=$row->id?>).datepicker();
		$('#expires'+<?=$row->id?>).datepicker();
	<? endforeach; ?>
</script>