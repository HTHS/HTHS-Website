<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<rss version="2.0">
    <channel>
    <title><?=$title?></title>
    <link><?=$link?></link>
    <description><?=$description?></description>
    <language>en-US</language>
    <pubDate><?=date('r', $items[0]->date)?></pubDate>
<?php foreach ($items as $item) { ?>
    <item>
        <title><?=$item->title?></title>
        <link><?=$item->link?></link>
        <description><?=$item->contents?></description>
        <pubDate><?=date('r', $item->date)?></pubDate>
        <guid><?=$item->link?></guid>
    </item>
<?php } ?>
    </channel>
</rss>