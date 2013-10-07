<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black"><?=$teacher->name?>'s Blog</h2>
			<?php foreach($blog->result() as $entry): ?>
				<h3><?=$entry->title?></h3>
				<p><font size="-5">Posted on: <?=date('F j, Y',$entry->date)?></font></p>
				<?=$entry->contents?>
				<br /><br />
			<?php endforeach; ?>
		</div>
		<?php if($page_links != ''): ?>
			<div class="fancybox">
				<?=$page_links?>
			</div>
		<?php endif; ?>
	</div>
</div>
