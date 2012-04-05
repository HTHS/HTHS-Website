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
							<h2 class="fancytitle">HTHS Weather</h2>
							<!--Begin Weatherbug Code-->
							<div class="wXstickerbody" style="word-wrap:normal !important;width:180px;height:150px;border:1px #000 solid;background:url(http://img.weather.weatherbug.com/images/stickers/v2/180x150/bg.gif) no-repeat;">
							<div class="wXstickerforecast" style="margin-top:7px !important; margin-left:7px !important;">
							<object type="application/x-shockwave-flash" data="http://weather.weatherbug.com/corporate/products/stickers/v2/MySpace_Sticker_180x150.swf?zipcode=07738&ZCode=z5740&StationID=LNCRF&units=0&lang_id=en-us" height="100" width="166">
							<param name="movie" value="http://weather.weatherbug.com/corporate/products/stickers/v2/MySpace_Sticker_180x150.swf?zipcode=07738&ZCode=z5740&StationID=LNCRF&units=0&lang_id=en-us">
							<param name="allowScriptAccess" value="never">
							<param name="enableJSURL" value="false">
							<param name="enableHREF" value="false">
							<param name="saveEmbedTags" value="true">
							<param name="flashvars" value="zipcode=07738&ZCode=z5740&StationID=LNCRF&units=0">
							<embed src="http://weather.weatherbug.com/corporate/products/stickers/v2/MySpace_Sticker_180x150.swf?zipcode=07738&ZCode=z5740&StationID=LNCRF&units=0&lang_id=en-us" width="166" height="100" FlashVars="zipcode=07738&ZCode=z5545&StationID=LNCRF&units=0"></embed>
							</object>
							</div>
							<div class="wXstickerlinks" style="height:9px;line-height:9px;text-align:center !important;margin-top:0px !important;width:180px;">
							<span class="wXstickerlink"><a href="http://weather.weatherbug.com/NJ/Lincroft-weather/local-forecast/7-day-forecast.html?zcode=z5740&units=0" target="_blank" style="font-family:Arial,Helvetica !important;padding-left:1px !important;text-decoration:none !important;color:#00f !important;font-size:9px !important;font-weight:bold !important;">Forecast</a></span>
							<span class="wXstickerlink"><a href="http://weather.weatherbug.com/NJ/Lincroft-weather/local-radar/doppler-radar.html?zcode=z5740&units=0" target="_blank" style="font-family:Arial,Helvetica !important;padding-left:1px !important;text-decoration:none !important;color:#00f !important;font-size:9px !important;font-weight:bold !important;">Radar</a></span>
							<span class="wXstickerlink"><a href="http://weather.weatherbug.com/NJ/Lincroft-weather/weather-cams/local-cams.html?zcode=z5740&units=0" target="_blank" style="font-family:Arial,Helvetica !important;padding-left:1px !important;text-decoration:none !important;color:#00f !important;font-size:9px !important;font-weight:bold !important;">Cameras</a></span>
							<span class="wXstickerlink"><a href="http://weather.weatherbug.com/weather-photos/photo-gallery.html?zcode=z5740&units=0&zip=07738" target="_blank" style="font-family:Arial,Helvetica !important;padding-left:1px !important;text-decoration:none !important;color:#00f !important;font-size:9px !important;font-weight:bold !important;">Photos</a></span>
							<div class="wXstickerfooter" style="margin-top:6px !important;">
							<a href="http://weather.weatherbug.com/NJ/Lincroft-weather.html?zcode=z5740&units=0" target="_blank"><img src="http://img.weather.weatherbug.com/images/stickers/v2/180x150/wxbug-logo.jpg" style="border:0px;" border="0" alt="WeatherBug" /></a></div>
							</div>
							</div>
							<!--End Weatherbug Code-->
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
			
			