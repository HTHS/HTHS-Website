<style type="text/css">
.teacher_image {
    float: left;
    margin: 2px 10px 5px 2px;
    border: 1px solid #CCC;
    padding: 10px;
    background-color: white;
    width: 160px;
    height: 200px;
}

#teacher_description ul, #teacher_description ol {
	display: inline-block;
	margin: 0 0 1em -20px;
}

#teacher_description_wrapper {
	overflow: auto;
}
</style>
<div id="content_left">
<div id="content_left_above">
<div class="fancybox">
<div class="fancytitle"><?=$teacher->prefix.' '.$teacher->first_name.' '.$teacher->last_name.' '.$teacher->suffix?></div>
<div id="teacher_description_wrapper">
<? if(file_exists('images/teachers/' . $teacher->username.'.png')): ?>
	<img src="<?=base_url('images/teachers/' . $teacher->username.'.png')?>" height="200" class="teacher_image" />
<? endif; ?>
<div id="teacher_description">
<?=$teacher->description?>
</div>
</div>
</div>

<div class="fancybox" id="blog">
<div class="fancytitle black">Latest Blog Posts<?php if($teacher->blog != '') {?> - <a href="<?=$teacher->blog?>">View Blog</a><?}?></div>
<? if($teacher->blog != '') { ?>
<?php
$this->load->helper('news_formatter');
foreach ($entries as $entry) {
    generate_news_item($entry, $entry->link, true);
}
?>
<?
} else {
	echo '<i>This teacher does not have a blog.</i>';
}
?>
</div>

<div class="fancybox" id="pages">
<div id="pages" class="fancytitle black">Pages</div>
<?php
if (count($pages) > 0) {
?>
<ul id="teacher_page_listing">
<?php
foreach ($pages as $page) {
?>
<li><a href="<?=site_url('teachers/' . $teacher->username . '/page/' . $page->page_url)?>"><?=$page->page_title?></a></li>
<?php
}
?>
</ul>
<?php
} else {
	echo '<i>This teacher does not have any pages.</i>';
}
?>
</div>
</div>
</div>