<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Downloadable Forms</h2>
			<p>Please select a form from below to download. Please note that some forms may require Adobe Reader to open.</p>
			<br />
			<? foreach($types->result() as $type): ?>
				<h3><?=$type->type?></h3>
				<table border="1" width="50%" class="centerTable" style="margin-left: 10px;">
					<tr class="header">
						<td>Date</td>
						<td>Form</td>
						<td>Type</td>
					</tr>
					<? foreach($forms[$type->type]->result() as $form): 
						$ext = explode('.', $form->filename); ?>
						<tr>
							<td><?=date('d/y', $form->time)?></td>
							<td><a href="<?=site_url('downloads/').$form->filename?>"><?=$form->name?></a></td>
							<td>.<?=$ext[1]?></td>
						</tr>
					<? endforeach; ?>
				</table>
				<br />
			<? endforeach; ?>
		</div>
	</div>
</div>