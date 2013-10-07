<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Upload Image</h2>
			<form action="<?=current_url()?>" enctype="multipart/form-data" method="post">
			<?=$this->upload->display_errors('<div class="error"><p>','</p></div>')?>
			<table>
				<tr>
					<td><p>Select a file to be uploaded, then press Upload to copy it to the site.</p></td>
				<tr>
					<td><div class="fancybox"><input type="file" name="image" /></div></td>
				</tr>
				<tr>
					<td><input type="submit" name="submit" value="Upload" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<div id="content_left_below">
		<div class="fancybox">
			<h2 class="fancytitle">Image Manager</h2>
			<table border="1" cellpadding="5" width="98%">
				<tr>
					<td><b>Filename</b></td>
					<td><b>Size</b></td>
					<td><b>Uploaded</b></td>
					<td><b>Link</b></td>
					<td><b>Delete</td></b>
				</tr>
				<?php foreach($images as $image): ?>
					<tr>
						<td><?=$image['name']?></td>
						<td><?=(int)($image['size'] / 1000)?> KB</td>
						<td><?=date('m/d/Y',$image['time'])?></td>
						<td><input type="text" size="35" value="<?=site_url('images/upload/'.$image['name'])?>" /></td>
						<td><a href="<?=site_url('admin/delete_image/'.$image['name'])?>" onclick="return verify();">Delete</a></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	function verify()
	{
		var c = confirm("Are you sure you want to delete this image?");
		if(c)
			return true;
		else
			return false;
	}
</script>