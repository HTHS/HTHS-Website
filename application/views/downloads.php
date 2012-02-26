<div id="content_left">
	<div id="content_left_above">
		<style type="text/css">
			#downloads_wrapper {
				padding-left: 30px;
				padding-top: 15px;
				position: relative;
			}
			#downloads_sorter.downloads_sorter_floating {
				border: 1px solid #CCC;
				width: 130px;
				padding: 0;
				box-shadow: 2px 2px 10px #AAA;
				position: absolute;
				z-index: 10;
				background-color: #FFF;
				left: -118px;
				top: 15px;
			}
			#downloads_sorter_title {
				margin: 0;
				padding: 10px 10px 4px 10px;
				font-weight: bold;
				font-size: 11pt;
				text-transform: uppercase;
			}
			ul#downloads_sorter_typewrapper {
				list-style-type: none;
				padding: 0 0 7px 0;
				margin: 0;
				font-size: 10pt;
			}
			#downloads_sorter_typewrapper a {
				display: block;
				border: 0;
			}
			#downloads_sorter_typewrapper a.downloads_sorter_type_current, #downloads_sorter_typewrapper a:hover {
				background-color: #BD0000;
				color: #FFF;
			}
			.downloads_sorter_type {
				padding: 3px 3px 3px 12px;
			}
			.downloads_type_title {
				text-transform: uppercase;
				font-size: 16pt;
				font-weight: normal;
			}
			ul.downloads_type_itemwrapper {
				list-style-type: none;
				padding-left: 0; 
			}
			ul.downloads_type_itemwrapper li {
				margin: 15px 0 15px 15px;
			}
			.downloads_type_item_icon {
				float: left;
			}
			.downloads_type_item_info {
				font-size: 11pt;
				margin-left: 35px;
				padding-top: 3px;
				overflow: auto;
			}
			.downloads_type_item_title {
				float: left;
				font-size: 12pt;
				border-bottom: 1px solid #AAA;
				font-weight: bold;
			}
			.downloads_type_item_size {
				float: right;
			}
			.downloads_type_item_downloadcount {
				margin-top: 5px;
				clear: both;
				float: left;
			}
			.downloads_type_item_date {
				margin-top: 5px;
				clear: right;
				float: right;
			}
		</style>
		<script type="text/javascript" src="<?=site_url('js/downloads.js')?>"></script>
		<div class="fancybox">
			<h2 class="fancytitle black">Downloads</h2>
			<?php
			function download_type_anchor($type) {
				$search = array(' ', "'", '"');
				return 'category_' . strtolower(str_replace($search, '_', $type));
			}
			function format_filesize($filesize) {
				$units = array('bytes', 'KB', 'MB', 'GB');
				$power = floor(log($filesize, 1024));
				return round($filesize / pow(1024, $power)) . ' ' . $units[$power];
			}
			?>
			<div id="downloads_wrapper">
				<div id="downloads_sorter" class="downloads_sorter_floating">
					<h4 id="downloads_sorter_title">Categories</h4>
					<ul id="downloads_sorter_typewrapper">
						<? foreach ($types as $type): ?>
						<a href="#<?=download_type_anchor($type->type)?>"><li class="downloads_sorter_type"><?=$type->type?></li></a>
						<? endforeach; ?>
					</ul>
				</div>
			<? foreach ($types as $type): ?>
				<h3 class="downloads_type_title" id="<?=download_type_anchor($type->type)?>"><?=$type->type?></h3>
				<ul class="downloads_type_itemwrapper">
					<? foreach ($forms[$type->type] as $form): ?>
						<li>
							<a class="downloads_type_item" href="<?=site_url('downloads/' . $form->filename)?>">
								<div class="downloads_type_item_icon">
									<img src="" width="24" height="24"></img>
								</div>
								<div class="downloads_type_item_info">
									<span class="downloads_type_item_title"><?=$form->name?></span>
									<span class="downloads_type_item_size"><?=format_filesize($form->filesize)?></span>
									<span class="downloads_type_item_downloadcount"><?=number_format($form->download_count)?> downloads</span>
									<span class="downloads_type_item_date"><?=date('M n, Y', $form->time)?></span>
								</div>
							</a>
						</li>
					<? endforeach; ?>
				</ul>
			<? endforeach; ?>
			</div>
		</div>
	</div>
</div>