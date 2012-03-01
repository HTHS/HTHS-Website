<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Add Student</h2>
			<form action="<?=current_url()?>" method="post">
			<?=validation_errors()?>
			<table>
				<tr>
					<td>Name: </td>
					<td><input type="text" name="name" value="<?=set_value('name')?>" size="35" /></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input type="text" name="email" value="<?=set_value('email')?>" size="35" /></td>
				</tr>
				<tr>
					<td>Firm: </td>
					<td><input type="text" name="firm" value="<?=set_value('firm')?>" size="35" /></td>
				</tr>
				<tr>
					<td>Mentor: </td>
					<td><input type="text" name="mentor" value="<?=set_value('mentor')?>" size="35" /></td>
				</tr>
				<tr>
					<td>Tags: </td>
					<td><input type="text" name="tags" value="<?=set_value('tags')?>" size="50" /></td>
				</tr>
				<tr>
					<td>Semester: </td>
					<td>
						<select name="semester">
							<option value="1">Fall</option>
							<option value="2">Spring</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Year: </td>
					<td><input type="text" name="year" value="<?=set_value('year')?>" size="4" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add Student" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>