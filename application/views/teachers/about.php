<div class="fancybox">
<div class="fancytitle"><?=$teacher->name?></div>
<?php
if (defined($teacher->image) && $teacher->image != '') {
?>
<img src="<?=base_url('images/' . $teacher->image)?>" class="teacher_image"></img>
<br /><br />
<?php
}
?>
<?=$teacher->description?>
</div>

<div class="fancybox">
<div class="fancytitle black">Latest Blog Posts</div>
<?php
$this->load->helper('news_formatter');
foreach ($entries as $entry) {
    generate_news_item($entry, 'teachers/' . $teacher->username . '/blog/view/');
}
?>
</div>

<div class="fancybox">
<div class="fancytitle black">Pages</div>
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