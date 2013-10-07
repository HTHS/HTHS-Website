<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Add Student</h2>
			<form action="<?=site_url('teachers/dashboard/mentorship/add_student')?>" method="post">
			<table>
				<tr>
					<td>Name: </td>
					<td><input type="text" name="name" size="35" /></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input type="text" name="email" size="35" /></td>
				</tr>
				<tr>
					<td>Firm: </td>
					<td><input type="text" name="firm" size="35" /></td>
				</tr>
				<tr>
					<td>Mentor: </td>
					<td><input type="text" name="mentor" size="35" /></td>
				</tr>
				<tr>
					<td>Tags: </td>
					<td><input type="text" name="tags" size="50" /></td>
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
					<td><input type="text" name="year" size="4" /></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Add Student" /></td>
				</tr>
			</table>
			</form>
		</div>
	</div>
	<div id="content_left_below">
		<div id="content_left_left">
			<div class="fancybox">
				<h2 class="fancytitle">View Logs</h2>
				<ul>
					<?php foreach($currentStudents->result() as $student): ?>
						<li><a href="<?=site_url('teachers/dashboard/mentorship/view/'.$student->id)?>"><?=$student->name?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div id="content_left_right">
			<div class="fancybox">
				<h2 class="fancytitle red">Alerts / Settings</h2>
				<form action="<?=current_url()?>" method="post">
				<table>
					<tr>
						<td>Current Year: </td>
						<td><input type="text" name="year" value="<?=$settings['year']?>" size="4" /></td>
					</tr>
					<tr>
						<td>Current Semester: </td>
						<td>
							<select name="semester">		
								<option value="1" <?=($settings['semester'] == 1) ? 'selected="selected"' : ''; ?> >Fall</option>
								<option value="2" <?=($settings['semester'] == 2) ? 'selected="selected"' : ''; ?> >Spring</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Presentation Signups Open: </td>
						<td>
							<select name="schedule_open">
								<option value="0" <?=($settings['schedule_open'] == 0) ? 'selected="selected"' : ''; ?> >No</option>
								<option value="1" <?=($settings['schedule_open'] == 1) ? 'selected="selected"' : ''; ?> >Yes</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" value="Update" /></td>
					</tr>
				</table>
				</form>
				<p>The following people have not made any log entires in 2 weeks:</p>
				<ul>
					<?php foreach($problemUsers->result() as $user): ?>
							<li><?=$user->name?></li>
					<?php endforeach; ?>
				</ul>
				<p>Today's Site Visits:</p>
				<ul>
					<?php foreach($visits->result() as $visit): ?>
						<li><?=$visit->name?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>