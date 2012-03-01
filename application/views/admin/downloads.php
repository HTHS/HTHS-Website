<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Forms</h2>
			<?=validation_errors()?>
			<? if(isset($errors)): ?>
				<div class="error">
					<?=$errors?>
				</div>
				<br />
			<? endif; ?>
			<p>Click the name of a form below to see the options for that form. To upload a form, use the tool at the bottom of the page.</p>
			<br />
			<? foreach($types as $type): ?>
				<h3><?=$type->type?></h3>
				<ul>
					<? foreach($forms[$type->type] as $form): 
						($form->archived == 1) ? $archived = '<input type="button" value="Unarchive Form" onclick="window.location.href = \''.site_url('admin/unarchive/'.$form->id).'\'" />' : $archived = '<input type="button" value="Archive Form" onclick="window.location.href = \''.site_url('admin/archive/'.$form->id).'\'" />'; 
						($form->archived == 1) ? $style = '<del>' : $style = '';
						($form->archived == 1) ? $style2 = '</del>' : $style2 = ''; ?>
						<li><a href="" id="show<?=$form->id?>"><?=$style?><?=$form->filename?><?=$style2?></a></li>
						<div id="hidden<?=$form->id?>" style="display:none;">
							Link: <input type="text" size="50" value="<?=site_url($this->config->item('downloads_directory').'/'.$form->filename)?>" /><br />
							<?=$archived?> <input type="button" onclick="window.location.href = '<?=site_url('admin/delete_form/'.$form->id)?>'" value="Delete Form" />
						</div>
						<script type="text/javascript">
							$('#show'+<?=$form->id?>).click(function(event) {
								event.preventDefault();
								$('#hidden'+<?=$form->id?>).show('slow');
							});
						</script>
					<? endforeach; ?>
				</ul>
				<br />
			<? endforeach; ?>
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
						<? foreach($types as $type): ?>
							<option value="<?=$type->id?>" <?=set_select('type', $type->id)?>><?=$type->type?></option>
						<? endforeach; ?>
					</select></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Upload Form" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>