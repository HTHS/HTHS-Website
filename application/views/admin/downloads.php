<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Forms</h2>
			<?=validation_errors()?>
			<?php if(isset($errors)): ?>
				<div class="error">
					<?=$errors?>
				</div>
				<br />
			<?php endif; ?>
			<p>Click the name of a form below to see the options for that form. To upload a form, use the tool at the bottom of the page.</p>
			<br />
			<?php foreach($types as $type): ?>
				<h3><?=$type->type?></h3>
				<ul>
					<?php foreach($forms[$type->type] as $form): 
						($form->archived == 1) ? $archived = '<input type="button" value="Unarchive Form" onclick="window.location.href = \''.site_url('admin/unarchive/'.$form->id).'\'" />' : $archived = '<input type="button" value="Archive Form" onclick="window.location.href = \''.site_url('admin/archive/'.$form->id).'\'" />'; 
						($form->archived == 1) ? $style = '<del>' : $style = '';
						($form->archived == 1) ? $style2 = '</del>' : $style2 = ''; ?>
						<li><a href="" id="show<?=$form->id?>"><?=$style?><?=$form->name?><?=$style2?></a></li>
						<div id="hidden<?=$form->id?>" class="fancybox" style="display:none;">
							Link: <input type="text" size="50" value="<?=site_url($this->config->item('downloads_directory').'/'.$form->filename)?>" /><br />
							Downloaded: <?=$form->download_count?> times.<br />
							<?=$archived?> <input type="button" onclick="window.location.href = '<?=site_url('admin/delete_form/'.$form->id)?>'" value="Delete Form" /><br />
							<form action="<?=current_url()?>" method="post">
							<input type="hidden" name="filename" value="<?=$form->filename?>" />
							<select name="type">
								<?php foreach($types as $typeLocal): ?>
									<option value="<?=$typeLocal->id?>"><?=$typeLocal->type?></option>
								<?php endforeach; ?>
							</select> <input type="submit" name="submit" value="Change Category" />
							</form>
						</div>
						<script type="text/javascript">
							$('#show'+<?=$form->id?>).click(function(event) {
								event.preventDefault();
								$('#hidden'+<?=$form->id?>).toggle('slow');
							});
						</script>
					<?php endforeach; ?>
				</ul>
				<br />
			<?php endforeach; ?>
			<b>Upload a Form</b>
			<form action="<?=current_url()?>" method="post" enctype="multipart/form-data">
			<table>
				<tr>
					<td>Name :</td>
					<td><input type="text" name="name" size="35" value="<?=set_value('name')?>" /></td>
				</tr>
				<tr>
					<td>File :</td>
					<td><input type="file" name="form" /></td>
				</tr>
				<tr>
					<td>Category :</td>
					<td><select name="type">
						<?php foreach($types as $type): ?>
							<option value="<?=$type->id?>" <?=set_select('type', $type->id)?>><?=$type->type?></option>
						<?php endforeach; ?>
					</select></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Upload Form" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>