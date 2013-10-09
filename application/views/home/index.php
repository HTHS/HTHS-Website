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
                        <div id="shortcuts" class="fancybox">
                            <h2 class="fancytitle">Portals</h2>
							<?=$this->menu->render_portals()?>
                        </div> 
						<div id="feed" class="fancybox">
							<h2 class="fancytitle">Social Feed</h2>

                            <a class="twitter-timeline" href="https://twitter.com/HighTechHS" data-widget-id="387519246885875713" data-chrome="nofooter">Tweets by @HighTechHS</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                            <h2 class="fancytitle">Stay Connected</h2>
							<table>
								<tr>
									<td><img height="16" width="16" src="<?=site_url('images/icons/plus.gif')?>" /></td>
									<td><a href="<?=site_url('news/subscribe')?>">Subscribe to News Feed</a></td>
								</tr>
                                <tr>
                                	<td><img height="16" width="16" src="<?=site_url('images/icons/facebook.gif')?>" /></td>
                                    <td><a href="https://www.facebook.com/HighTechHS">Like Us on Facebook</a></td>
                                </tr>
                                <tr>
                                	<td><img height="16" width="16" src="<?=site_url('images/icons/twitter.gif')?>" /></td>
                                    <td><a href="http://twitter.com/HighTechHS">Follow Us on Twitter</a></td>
                                </tr>
								<tr>
									<td><img height="16" width="16" src="<?=site_url('images/icons/news_archive.gif')?>" /></td>
									<td><?=safe_mailto('HighTechHS@gmail.com', 'Contact Webmaster')?></td>
                                </tr>
                            </table>
						</div>
                    </div>	
                    
                    <div id="content_left_right">
						<div id="news" class="fancybox">
							<h2 class="fancytitle">News <a href="<?=site_url('rss/feed/news')?>" id="feed_icon" title="RSS Feed"><img src="<?=site_url('images/icons/rss.png')?>" alt="RSS Feed" /></a></h2>
							<?php
                            $this->load->helper('news_formatter');
                            foreach($news as $newsItem) {
                                $newsItem->date = $newsItem->start;
                                generate_news_item($newsItem, 'news/view/');
                            }
                            ?>
                            <div id="news_archivelink"><a href="<?=site_url("news")?>">News Archives</a></div>
						</div>
						<div id="onecallnow" class="fancybox">
                            <h2 class="fancytitle">Alerts</h2>
                            <img src="<?=site_url('images/icons/one-call-now-banner-logo.gif')?>" /><br />
                            <iframe width="298" height="70" frameborder="0" scrolling="no" marginheight="0" src="http://secure.onecallnow.com/access/banner/bannerwrapper.aspx?BT=LHB&EGI=0%2fXbzuia0a5jnWFIqn9mcw%3d%3d&S=09%2c10%2c11%2c12%2c20&L=&lt;-+Click+button+to+play+latest+message.+++++++++++++++++++++++++++++++++++++++++++++++++&F=1&Y=s"></iframe>
                            <hr />
                            <table>
                                <tr>
                                    <td width="32" align="right"><img src="<?=site_url('images/icons/plus.gif')?>" /></td>
                                    <td><a href="https://secure.onecallnow.com/Access/FamilyProfile/FamilyProfile.aspx?G=DBWFgIxwNPowx%2bNPnanAWg%3d%3d">
                                        Click here to add additional phone numbers or email addresses to One Call Now.</a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
				</div>
            </div>
			<?php foreach($news as $newsItem): ?>
				<?php if($newsItem->urgent == 1 && $this->input->cookie('un') != $newsItem->id):
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
					<?php break; ?>
				<?php else: 
					$cookie = array(
						'name'   => 'un',
						'value'  => $this->input->cookie('un'),
						'expire' => '86500',
						'secure' => FALSE
					);
					$this->input->set_cookie($cookie);
				endif; ?>
			<?php endforeach; ?>
			
			