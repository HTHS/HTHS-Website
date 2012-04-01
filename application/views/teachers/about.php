<div id="content_left">
<div id="content_left_above">
<div class="fancybox">
<div class="fancytitle"><?=$teacher->name?></div>
<?php
if (defined($teacher->image) && $teacher->image != '') {
?>
<img src="<?=base_url('images/teachers/' . $teacher->image)?>" class="teacher_image"></img>
<br /><br />
<?php
}
?>
<?=$teacher->description?>
</div>

<div class="fancybox">
<div class="fancytitle black">Latest Blog Posts - <a href="<?=$teacher->blog?>">View Blog</a></div>
<?php
$this->load->helper('news_formatter');
foreach ($entries as $entry) {
    generate_news_item($entry, $entry->link, true);
}
?>
</div>

<div class="fancybox">
<div id="pages" class="fancytitle black">Pages</div>
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