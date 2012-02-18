<?php
if (!defined('BASEPATH')) { exit('No direct script access allowed'); }

function generate_news_item($item, $url_path) {
    // Generates the proper HTML code for display as a neat list of news items. 
    // 
    // $item should be an associative array with at the following elements:
    // $item->title: title of the post
    // $item->date: date of the post
    // (optional) $item->urgent: a numerical value (1 or 0) indicating whether the item should be marked as urgent
    // 
    // $url_path is the relative path to which the item id will be added to generate a link. 
?>
<? ($item->urgent == 1) ? $style = 'style="color:red;"' : $style = ''; ?>
<a class="newsitem" href="<?=site_url($url_path . $item->id)?>">
<div class="dateindicator">
<span class="dateindicator_month"><?=date('M',$item->date)?></span>&nbsp;<span class="dateindicator_day"><?=date('j',$item->date)?></span>&nbsp;<span class="dateindicator_year"><?=date('Y',$item->date)?></span>
</div>
<div class="newsitem_title" <?=$style?>><?=$item->title?></div>
<div class="newsitem_arrow">&gt;</div>
</a>
<?php
}
?>