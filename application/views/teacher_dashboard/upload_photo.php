<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<div class="fancytitle">Upload Photo</div>
			<form action="<?=current_url()?>" enctype="multipart/form-data" method="post">
			<?=$this->upload->display_errors('<div class="error"><p>','</p></div>')?>
			<table>
				<?php if(file_exists('images/teachers/' . $teacher->username.'.png')): ?>
					<tr>
						<td>Current Photo: </td>
						<td><div class="fancybox"><img src="<?=site_url('images/teachers/'.$teacher->username.'.png')?>" class="teacher_image" /></div></td>
					</tr>
				<?php endif; ?>
				<tr>
					<td>New Photo: </td>
					<td><div class="fancybox"><input type="file" name="photo" /></div></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Upload" />
						<input type="submit" name="submit" value="Delete Photo" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>