<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Random Group Generator</h2>
			<form action="<?=current_url()?>" method="post">
				<?=validation_errors()?>
				<input type="hidden" name="step" value="2" />
				<input type="hidden" name="count" value="<?=$count?>" />
				<input type="hidden" name="groups" value="<?=$groups?>" />
				<p>To continue, please enter the names of the students in the table below.</p>
				<table>
					<?php for($i = 1; $i <= $count; $i++): ?>
						<tr>
							<td>Student <?=$i?>: </td>
							<td><input type="text" name="student<?=$i?>" size="25" value="<?=set_value('student'.$i)?>" />
						</tr>
					<?php endfor; ?>
					<tr>
						<td colspan="2"><input type="submit" value="Continue" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
