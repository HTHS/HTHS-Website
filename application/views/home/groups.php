<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Random Group Generator</h2>
			<form action="<?=current_url()?>" method="post">
				<?=validation_errors()?>
				<input type="hidden" name="step" value="1" />
				<p>Welcome to the random group generator. This tool will sort a list of student names into randomly assigned groups of a desired size. To begin, please enter the number of students you wish to create groups for and the number of groups.</p>
				<table>
					<tr>
						<td>Number of Students: </td>
						<td><input type="text" name="studentCount" value="<?=set_value('studentCount')?>" size="3" /></td>
					</tr>
					<tr>
						<td>Number of Groups: </td>
						<td><input type="text" name="groups" value="<?=set_value('groups')?>" size="3" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Continue" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
