<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Download Categories</h2>
			<?=validation_errors()?>
			<p>Below you can add and remove download categories from the system. Click the name of a category to remove it, or add a new one at the bottom of the page. You can only remove categories which have no downloads associated with them.</p>
			<br />
			<p><b>Categories Not in Use</b></p>
			<ul>
				<? foreach($unusedTypes->result() as $type): ?>
					<li><a href="<?=site_url('admin/delete_category/'.$type->id)?>"><?=$type->type?></a></li>
				<? endforeach; ?>
			</ul>
	        <br />
			<p><b>Categories in Use</b></p>
			<ul>
				<? foreach($usedTypes->result() as $type): ?>
					<li><?=$type->type?></li>
				<? endforeach; ?>
			</ul>
			<br />
			<p><b>Add a Category</b></p>
			<form action="<?=current_url()?>" method="post">
			<input type="text" name="category" size="35" /> <input type="submit" value="Add Category" />
			</form>
		</div>
	</div>
</div>
