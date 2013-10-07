<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle"><?=$user->name?>'s Mentorship Log Entries</h2>
			<?php foreach($log->result() as $entry): ?>
				<h3><?=date('F j, Y',$entry->date)?></h3><br />
				<p><b>Time In:</b> <?=$entry->in_time?> <b>Time Out:</b> <?=$entry->out_time?></p>
				<p><b>Activities:</b> <?=nl2br($entry->activities)?></p><br />
				<p><b>Comments/Problems:</b> <?=nl2br($entry->comments)?></p>
				<br /><br />
			<?php endforeach; ?>
		</div>
		
		<?php if($pageLinks != ''): ?>
			<div class="fancybox">
			<?=$pageLinks?>
			</div>
		<?php endif; ?>
	</div>
</div>