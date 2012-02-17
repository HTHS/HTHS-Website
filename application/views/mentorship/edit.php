<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Edit Log Entry</h2>
			<?=validation_errors()?>
			<form action="<?=current_url()?>" method="post">
			<table>
				<tr>
					<td>Date: </td>
					<td><input type="text" size="15" value="<?=unix_to_friendly($entry->date)?>" disabled="disabled" /></td>
				</tr>
				<tr>
					<td>Activities: </td>
					<td><textarea name="activities" rows="5" cols="50"><?=set_value('activities',$entry->activities)?></textarea></td>
				</tr>
				<tr>
					<td>Comments: </td>
					<td><textarea name="comments" rows="5" cols="50"><?=set_value('comments',$entry->comments)?></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Edit Log" /> <input type="button" value="Delete Log" onclick="window.location.href = '<?=site_url('mentorship/delete/'.$entry->id)?>'" /> <input type="button" value="Cancel" onclick="window.location.href = '<?=site_url('mentorship')?>'" /></td>
				</tr>
			</table>
		</div>
	</div>
</div>

