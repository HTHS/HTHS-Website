<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Random Group Generator</h2>
			<p>Here are your randomly generated groups! To re-generate the groups, refresh this page.</p>
			<?php foreach($groups as $key => $value):
				if($key != 0): ?>
				<h3>Group <?=$key?></h3>
				<ol>
					<?php foreach($value as $student): ?>
						<li><?=$student?></li>
					<?php endforeach; ?>
				</ol>
				<br />
			<?php 	endif;
			endforeach; ?>
			<input type="button" value="Start Over!" onclick="window.location.href = '<?=current_url()?>'" />
		</div>
	</div>
</div>
