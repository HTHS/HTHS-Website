<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Edit Student</h2>
			<form action="<?=current_url()?>" method="post">
			<?=validation_errors()?>
			<table>
				<tr>
					<td>Name: </td>
					<td><input type="text" name="name" value="<?=set_value('name', $user->name)?>" size="35" /></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input type="text" name="email" value="<?=set_value('email', $user->email)?>" size="35" /></td>
				</tr>
				<tr>
					<td>Firm: </td>
					<td><input type="text" name="firm" value="<?=set_value('firm', $user->firm)?>" size="35" /></td>
				</tr>
				<tr>
					<td>Mentor: </td>
					<td><input type="text" name="mentor" value="<?=set_value('mentor', $user->mentor)?>" size="35" /></td>
				</tr>
				<tr>
					<td>Tags: </td>
					<td><input type="text" name="tags" value="<?=set_value('tags', $user->tags)?>" size="50" /></td>
				</tr>
				<tr>
					<td>Semester: </td>
					<td>
						<select name="semester">
							<option value="1" <?=set_select('semester', '1', $user->semester == 1)?> >Fall</option>
							<option value="2" <?=set_select('semester', '2', $user->semester == 2)?> >Spring</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Year: </td>
					<td><input type="text" name="year" value="<?=set_value('year', $user->year)?>" size="4" /></td>
				</tr>
				<tr>
					<td>Site Visit: </td>
					<td><input type="text" name="site_visit" id="visit" value="<?=set_value('site_visit', unix_to_friendly($user->site_visit))?>" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Save Changes" /> <input type="button" value="Cancel" onclick="window.location.href = '<?=site_url('teachers/dashboard/mentorship/students')?>'" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#visit').datepicker();
</script>