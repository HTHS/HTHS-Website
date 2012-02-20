<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Add Page</h2>
			<?=validation_errors()?>
			<form action="<?=current_url()?>" method="post">
			<table>
				<tr>
					<td>Title: </td>
					<td><input type="text" name="title" value="<?=set_value('title')?>" size="35" /></td>
				</tr><tr>
					<td>URL: </td>
					<td><input type="text" name="url" value="<?=set_value('url')?>" size="35" /></td>
				</tr>
				<tr>
					<td colspan="2"><textarea name="contents" rows="8" cols="60"><?=set_value('contents')?></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add Page" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	CKEDITOR.replace('contents');
</script>