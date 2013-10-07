<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Download Categories</h2>
			<?=validation_errors()?>
			<p>Below you can add and remove download categories from the system. Click the name of a category to remove it or rename it, or add a new one at the bottom of the page. You can only remove categories which have no downloads associated with them.</p>
			<br />
			<p><b>Categories Not in Use</b></p>
			<ul>
				<?php foreach($unusedTypes as $type): ?>
					<li><a href="" id="openUnused<?=$type->id?>"><?=$type->type?></a>
						<div class="fancybox" style="display:none;" id="unused<?=$type->id?>">
							<form action="<?=current_url()?>" method="post">
							<input type="hidden" name="id" value="<?=$type->id?>" />
							<input type="text" name="category" size="35" value="<?=$type->type?>" /> <input name="submit" type="submit" value="Rename" /> <input type="button" value="Delete Category" onclick="window.location.href = '<?=site_url('admin/delete_category/'.$type->id)?>'" />
							</form>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
	        <br />
			<p><b>Categories in Use</b></p>
			<ul>
				<?php foreach($usedTypes as $type): ?>
					<li><a href="" id="openUsed<?=$type->id?>"><?=$type->type?></a>
						<div class="fancybox" style="display:none;" id="used<?=$type->id?>">
							<form action="<?=current_url()?>" method="post">
							<input type="hidden" name="id" value="<?=$type->id?>" />
							<input type="text" name="category" size="35" value="<?=$type->type?>" /> <input name="submit" type="submit" value="Rename" />
							</form>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<br />
			<p><b>Add a Category</b></p>
			<form action="<?=current_url()?>" method="post">
			<input type="text" name="category" size="35" /> <input type="submit" name="submit" value="Add Category" />
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	<?php foreach($unusedTypes as $type): ?>
		$('#openUnused<?=$type->id?>').click(function(event) {
			event.preventDefault();
			$('#unused'+<?=$type->id?>).toggle('slow');
		});
	<?php endforeach; ?>
	<?php foreach($usedTypes as $type): ?>
		$('#openUsed<?=$type->id?>').click(function(event) {
			event.preventDefault();
			$('#used<?=$type->id?>').toggle('slow');
		});
	<?php endforeach; ?>
</script>