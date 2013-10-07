<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">HTHS Faculty</h2>
			<table border="1" width="100%" class="centerTable">
				<tr class="header">
					<td width="30%">Name</td>
					<td width="20%">Subject</td>
					<td width="10%">Voicemail Extension</td>
					<td width="15%">Send Email</td>
					<td width="15%">Webpage</td>
					<td width="10%">Blog</td>
				</tr>
				<?php foreach($teachers->result() as $teacher): ?>
					<tr>
						<td><?=$teacher->name?></td>
						<td><?=$teacher->subject?></td>
						<td><?=$teacher->voicemail?></td>
						<td><?php if($teacher->email != ''): ?><a href="" id="email<?=$teacher->id?>">Send Email</a><?php else: ?>Not Available<?php endif; ?></td>
						<td><?php if($teacher->page_contents != ''): ?><a href="<?=site_url('home/teacher_pages/'.$teacher->id)?>">Webpage</a><?php else: ?>Not Available<?php endif; ?></td>
						<td><?php if($teacher->blog_count != 0): ?><a href="<?=site_url('home/blogs/'.$teacher->id)?>">Blog</a><?php else: ?>Not Available<?php endif; ?></td>
					</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>

<?php foreach($teachers->result() as $teacher): 
	if($teacher->email != ''): ?>
		<div id="teacherEmail<?=$teacher->id?>" style="display:none;">
			<div id="formOutput<?=$teacher->id?>"></div>
			<table>
				<tr>
					<td>Your Email:</td>
					<td><input type="text" name="email_address" id="email_address<?=$teacher->id?>" size="50" /></td>
				</tr>
				<tr>
					<td>Subject:</td>
					<td><input type="text" name="subject" id="subject<?=$teacher->id?>" size="50" /></td>
				</tr>
				<tr>
					<td>Message:</td>
					<td><textarea name="contents" id="contents<?=$teacher->id?>" rows="6" cols="53"></textarea>
				</tr>
				<tr>
					<td rowspan="2">Security Code:</td>
					<td><?=$cap['image']?></td>
				</tr>
				<tr>
					<td><input type="text" name="verify" id="verify<?=$teacher->id?>" size="10" /></td>
				<tr>
					<td colspan="2"><input type="button" id="sendEmail<?=$teacher->id?>" value="Send Email" /></td>
				</tr>
			</table>
			<br />
			<p>All emails sent are logged, please use this for serious contact only.</p>
		</div>
<?php  endif; 
endforeach; ?>

<script type="text/javascript">
<?php foreach($teachers->result() as $teacher): 
	if($teacher->email != ''): ?>
		$('#teacherEmail'+<?=$teacher->id?>).dialog({autoOpen: false, title: 'Email <?=$teacher->name?>', width: 600, height: 600});
		$('#teacherEmail'+<?=$teacher->id?>).attr('style', '');
		$('#email'+<?=$teacher->id?>).click(function(event) {
			event.preventDefault();
			$('#teacherEmail'+<?=$teacher->id?>).dialog('open');
		});
		$('#sendEmail'+<?=$teacher->id?>).click({ targetTeacherId: <?=$teacher->id?> }, function(event) {
			var id = event.data.targetTeacherId;
			$('#formOutput'+id).html('<img src="<?=site_url('images/icons/ajax-loader.gif')?>" alt="Loading" style="text-align:center;" />');
			$.post('<?=site_url('json/send_email')?>', { teacher_id: id, email_address: $('#email_address'+id).val(), subject: $('#subject'+id).val(), message: $('#contents'+id).val(), verify: $('#verify'+id).val() }, function(response) {
				if(response == 'TRUE') {
					$('#formOutput'+id).html('<div class="success">Email sent successfully!</div>');
					$('#email_address'+id).val('');
					$('#subject'+id).val('');
					$('#contents'+id).val('');
					$('#verify'+id).val('');
				}
				else 
					$('#formOutput'+id).html(response);
			});
		})
<?php  endif; 
endforeach; ?>
</script>