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
                            <a href="" class="button_link">
                                <table>
                                    <tr>
                                        <td>>></td>
                                        <td>Prospective Students</td>
                                    </tr>
                                </table>
                            </a>             
                            <a href="http://hthsalumni.org/" class="button_link">
                                <table>
                                    <tr>
                                        <td>>></td>
                                        <td>Alumni</td>
                                    </tr>
                                </table>
                            </a>
                        </div> 
						<div id="feed" class="fancybox">
							<h2 class="fancytitle">Social Feed</h2>
							<script type="text/javascript">
							var post_limit = 3;
							var feed_url = "https://www.facebook.com/feeds/page.php?format=atom10&id=218788884843140";
							var feed_json = 'https://ajax.googleapis.com/ajax/services/feed/load?v=1.0&q=' + encodeURIComponent(feed_url) + '&callback=?';
							$.getJSON(feed_json, function(data) {
								var posts = data.responseData.feed.entries;
								for (var i=0; i<posts.length && i<post_limit; i++) {
									var post = posts[i];
									
									var date_parse = new Date(post.publishedDate);
									var date_string = date_parse.toDateString();
									
									var element = $('#socialwidget_primatives .socialwidget_post').clone();
									
									$(element).find('a').attr('href', post.link);
									$(element).find('.socialwidget_post_content').html(post.contentSnippet);
									$(element).find('.socialwidget_post_date').html(date_string);
									
									$(element).appendTo('#socialwidget');
								}
							});
							</script>
							<style type="text/css">
							#socialwidget_primatives {
								display: none;
							}
							
							.socialwidget_post {
								margin: 5px 0 5px 0;
							}
							.socialwidget_post_content {
								font-size: 9pt;
							}
							.socialwidget_post_date {
								font-size: 8pt;
								color: #555;
								font-style: italic;
								text-align: right;
							}
							</style>
							<div id="socialwidget"></div>
							<div id="socialwidget_primatives">
								<div class="socialwidget_post">
									<a href="#">
										<div class="socialwidget_post_content"></div>
										<div class="socialwidget_post_date"></div>
									</a>
								</div>
							</div>
							<h2 class="fancytitle">Stay Connected</h2>
							<table>
								<tr>
									<td><img height="16" width="20" src="<?=site_url('images/icons/plus.gif')?>" /></td>
									<td><a href="<?=site_url('news/subscribe')?>" />Subscribe to News Feed</a></td>
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
							<h2 class="fancytitle">News <a href="<?=site_url('rss/feed/news')?>"><img src="<?=site_url('images/icons/rss.png')?>" alt="RSS Feed" /></a></h2>
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
			<? foreach($news as $newsItem): ?>
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
			
			