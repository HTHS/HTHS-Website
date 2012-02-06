<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Administrators</h2>
			<p>Click an administrator's name to remove that administrator.</p>
			<ul>
				<? foreach($admins->result() as $admin): ?>
					<? if($admin->id != $this->session->userdata('id')): ?>
						<li><a href="<?=site_url('admin/delete_admin/'.$admin->id)?>" onclick="return confirm('Are you sure you want to do that?');"><?=$admin->username?></a></li>
					<? else: ?>
						<li><?=$admin->username?></li>
					<? endif; ?>
				<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>

