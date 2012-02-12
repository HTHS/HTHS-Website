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
							<h2 class="fancytitle">Social Feed</h2>
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
								<a class="newsitem" href="<?=site_url("home/archive")?>">
								<div class="dateindicator">
								<span class="dateindicator_month"><?=date('M',$newsItem->start)?></span>&nbsp;<span class="dateindicator_day"><?=date('j',$newsItem->start)?></span>&nbsp;<span class="dateindicator_year"><?=date('Y',$newsItem->start)?></span>
								</div>
								<div class="newsitem_title" <?=$style?>><?=$newsItem->title?></div>
								<div class="newsitem_arrow">&gt;</div>
								</a>
							<? endforeach; ?>
						</div>
                    </div>  
				</div>
            </div>
			<? foreach($news->result() as $newsItem): ?>
				<? if($newsItem->urgent == 1 && $this->input->cookie('un') != $newsItem->id):
					$cookie = array(
						'name'   => 'un',
						'value'  => $newsItem->id,
						'expire' => '86500',
						'secure' => FALSE
					);
					$this->input->set_cookie($cookie); ?>
					<div id="urgentNews">
						<?=$newsItem->contents?>
					</div>
					<script type="text/javascript">
						$('#urgentNews').dialog({ autoOpen: true, title: "Important Message from HTHS: <?=$newsItem->title?>" });
					</script>
					<? break; ?>
				<? else: 
					$cookie = array(
						'name'   => 'un',
						'value'  => $this->input->cookie('un'),
						'expire' => '86500',
						'secure' => FALSE
					);
					$this->input->set_cookie($cookie);
				endif; ?>
			<? endforeach; ?>
			
			