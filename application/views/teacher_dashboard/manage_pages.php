<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Manage Pages</h2>
			<p>Click the name of a page below to edit or delete that page.</p>
			<ul>
			<? foreach($pages->result() as $page): ?>
				<li><a href="" id="page<?=$page->id?>"><?=$page->title?></a></li>
				<div id="pageOptions<?=$page->id?>" style="display:none;">
					Link: <input type="text" size="50" value="<?=site_url('teachers/'.$this->session->userdata('username').'/page/'.$page->url)?>" /><br />
					<input type="button" value="Edit Page" onclick="window.location.href = '<?=site_url('teacher_dashboard/edit_page/'.$page->id)?>'" /> <input type="button" value="Delete Page" onclick="confirm<?=$page->id?>();" />
				</div>
			<? endforeach; ?>
			</ul>
		</div>
	</div>
</div>

<script type="text/javascript">
	<? foreach($pages->result() as $page): ?>
		$('#page'+<?=$page->id?>).click(function(event) {
			event.preventDefault();
			$('#pageOptions'+<?=$page->id?>).show('slow');
		});
		
		function confirm<?=$page->id?>() {
			var c = confirm("Are you sure that you want to delete this page? All data on the page will be lost!");
			if(c)
				window.location.href = '<?=site_url("teacher_dashboard/delete_page/".$page->id)?>';
		}
	<? endforeach; ?>
</script>