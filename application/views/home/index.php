			<div id="content_left">
				<div id="content_left_above">
					<div id="gallery_wrapper" class="fancybox">
						<div id="gallery">
							<img src="<?=site_url('images/makeshift_hths_image.png')?>" />
						</div>
					</div>
				</div>

				<div id="content_left_below">
                    <div id="content_left_left">
						<div id="feed" class="fancybox">
							<h2 class="fancytitle">Facebook + Twitter</h2>
							<p>insert integrated feed here</p>
							<h2 class="fancytitle">Stay Connected</h2>
							<table>
                            	<tr>
                                	<td><img src="<?=site_url('images/icons/news_archive.gif')?>" /></td>
                                    <td><a href="<?=site_url('home/archive')?>">News Archive</a></td>
                                </tr>
								<tr>
									<td><img height="16" width="20" src="<?=site_url('images/icons/plus.gif')?>" /></td>
									<td><a href="<?=site_url('home/subscribe')?>" />Subscribe to News Feed</a></td>
								</tr>
                                <tr>
                                	<td><img src="<?=site_url('images/icons/rss.gif')?>" /></td>
                                    <td><a href="">RSS Feed</a></td>
                                </tr>
                                <tr>
                                	<td><img src="<?=site_url('images/icons/facebook.gif')?>" /></td>
                                    <td><a href="https://www.facebook.com/HighTechHS">Like Us on Facebook</a></td>
                                </tr>
                                <tr>
                                	<td><img src="<?=site_url('images/icons/twitter.gif')?>" /></td>
                                    <td><a href="http://twitter.com/chiefsimonhths">Follow Us on Twitter</a></td>
                                </tr>
                            </table>
						</div>
                    </div>	
                    
                    <div id="content_left_right">
						<div id="news" class="fancybox">
							<h2 class="fancytitle"><a href="<?=site_url('home/archive')?>">News</a></h2>
							<? foreach($news->result() as $newsItem): ?>
								<? ($newsItem->urgent == 1) ? $style = 'style="color:red;"' : $style = ''; ?>
								<h3 <?=$style?>><?=$newsItem->title?></h3>
								<p><font size="-5">Posted on <?=date('F j, Y',$newsItem->start)?></font></p>
								<br /><br />
							<? endforeach; ?>
						</div>
                    </div>  
				</div>
            </div>
			
			