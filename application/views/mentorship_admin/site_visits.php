<div id="content_left">
	<div id="content_left_above">
		<div id="content_left_left">
			<div class="fancybox">
				<h2 class="fancytitle">Upcoming Visits</h2>
				<?=$calendar?>
			</div>
		</div>
		<div id="content_left_right">
			<div class="fancybox">
				<h2 class="fancytitle black">Details</h2>
				<div id="dynamicContent">
					<p>Select a date for details.</p>
				</div>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>

<script type="text/javascript">
	var data = new Array();
	<?php foreach($visits->result() as $visit): ?>
		if(data[<?=date('j',$visit->site_visit)?>] == undefined)
			data[<?=date('j',$visit->site_visit)?>] = '<p>Visit to <?=$visit->firm?> to visit <?=$visit->name?> working with <?=$visit->mentor?>.</p>';
		else
			data[<?=date('j',$visit->site_visit)?>] += '<p>Visit to <?=$visit->firm?> to visit <?=$visit->name?> working with <?=$visit->mentor?>.</p>';
	<?php endforeach; ?>
	
	function showDetails(date) {
		$('#dynamicContent').html(data[date]);
	}
</script>