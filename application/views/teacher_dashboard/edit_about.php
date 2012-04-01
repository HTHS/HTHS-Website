<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<div class="fancytitle">About Me</div>
			<form action="<?=current_url()?>" method="post">
			<table>
				<tr>
					<td colspan="2"><textarea name="description" rows="8" cols="58"><?=$about->description?></textarea></td>
				</tr>
				<tr>
					<td>Blog Link: </td>
					<td><input type="text" name="blog" value="<?=$about->blog?>" size="50" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Update" /></td>
				</tr>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	CKEDITOR.replace('description');
</script>