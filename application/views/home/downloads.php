<div id="content_left">
	<div id="content_left_above">
		<style type="text/css">
			
		</style>
		<div class="fancybox">
			<h2 class="fancytitle black">Downloads</h2>
			
			<? foreach($types as $type): ?>
				<h3><?=$type->type?></h3>
				<table border="1" width="50%" class="centerTable" style="margin-left: 10px;">
					<tr class="header">
						<td>Date</td>
						<td>Form</td>
						<td>Type</td>
					</tr>
					<? foreach($forms[$type->type] as $form): 
						$ext = explode('.', $form->filename); ?>
						<tr>
							<td><?=date('m/y', $form->time)?></td>
							<td><a href="<?=site_url('downloads/'.$form->filename)?>"><?=$form->name?></a></td>
							<td>.<?=$ext[1]?></td>
						</tr>
					<? endforeach; ?>
				</table>
				<br />
			<? endforeach; ?>
		</div>
	</div>
</div>