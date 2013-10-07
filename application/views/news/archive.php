<div id="content_left">
	<div id="news" class="fancybox">
		<h2 class="fancytitle black">News Archives</h2>
	<?php foreach($posts as $news): ?>
		<h3><?=$news->title?></h2>
		<p><font size="-5">Posted on <?=date('F j, Y',$news->start)?></font></p>
		<?=$news->contents?>
		<br /><br />
	<?php endforeach; ?>
	</div>
	
	<?php if($pageLinks != ''): ?>
		<div class="fancybox">
		<?=$pageLinks?>
		</div>
	<?php endif; ?>
</div>


