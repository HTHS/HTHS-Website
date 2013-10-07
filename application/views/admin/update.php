<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">System Updater</h2>
			<?php if($update == false): ?>
				<p>No new updates are available at this time.</p>
				<p>The current version of the site is <b><?=$this->adminmod->getVersion()?></b></p>
			<?php else: ?>
				<form action="<?=current_url()?>" method="post">
				<input type="hidden" name="url" value="<?=$this->input->post('url', TRUE)?>" />
				<input type="hidden" name="submit" value="Install Update" />
				<p>A new update was found. The version of the update found was <b><?=$update?></b>, the current version of the site is <b><?=$this->adminmod->getVersion()?></b>.</p>
				<p>Would you like to install this update?</p>
				<p><input type="submit" value="Yes" /> <input type="button" value="No" onclick="window.location.href = '<?=site_url('admin')?>'" /></p>
				</form>
			<?php endif; ?>
		</div>
	</div>
</div>
