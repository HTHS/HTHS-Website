<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle"><?=$user->name?>'s Mentorship Log Entries</h2>
			<? foreach($log->result() as $entry): ?>
				<h3><?=date('F j, Y',$entry->date)?></h3><br />
				<p><b>Activities:</b> <?=$entry->activities?></p><br />
				<p><b>Comments/Problems:</b> <?=$entry->comments?></p>
				<br /><br />
			<? endforeach; ?>
		</div>
		
		<? if($pageLinks != ''): ?>
			<div class="fancybox">
			<?=$pageLinks?>
			</div>
		<? endif; ?>
	</div>
</div>