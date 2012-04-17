<style type="text/css">
.teacher_image {
    float: left;
    margin: 2px 10px 10px 2px;
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
</style>

<div id="content_left">
<div id="content_left_above">
<div class="fancybox">
<div class="fancytitle"><?=$teacher->name?></div>
<? if(file_exists('images/teachers/' . $teacher->username.'.png')): ?>
	<img src="<?=base_url('images/teachers/' . $teacher->username.'.png')?>" class="teacher_image" />
<? endif; ?>
<div id="teacher_description">
<?=$teacher->description?>
</div>
</div>

<? if($teacher->blog != ''): ?>
<div class="fancybox">
<a name="blog"></a>
<div class="fancytitle black">Latest Blog Posts - <a href="<?=$teacher->blog?>">View Blog</a></div>
<?php
$this->load->helper('news_formatter');
foreach ($entries as $entry) {
    generate_news_item($entry, $entry->link, true);
}
?>
</div>
<? endif; ?>

<div class="fancybox">
<div id="pages" class="fancytitle black">Pages</div>
<a name="pages"></a>
<ul id="teacher_page_listing">
<?php
foreach ($pages as $page) {
?>
<li><a href="<?=site_url('teachers/' . $teacher->username . '/page/' . $page->page_url)?>"><?=$page->page_title?></a></li>
<?php
}
?>
</ul>
</div>
</div>
</div>