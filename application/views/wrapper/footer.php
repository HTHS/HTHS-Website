	<? if(!isset($nosidebar)): ?>	
		<div id="sidebar">
			<div class="fancybox">
            	<h2 class="fancytitle">Calendar</h2>
            	<script type="text/javascript">
            		$(function() {
            			var feedJSONHTHS = 'http://www.google.com/calendar/feeds/chiefsimonhths@gmail.com/public/full?alt=json-in-script&orderby=starttime&max-results=5&singleevents=true&sortorder=ascending&futureevents=true&callback=?';
            			var feedJSONMCVSD = 'http://www.google.com/calendar/feeds/5j96g4ul0gkpcbd0ldq6li6mgo@group.calendar.google.com/public/full?alt=json-in-script&orderby=starttime&max-results=2&singleevents=true&sortorder=ascending&futureevents=true&callback=?';
            			var feedJSONPFA = 'http://www.google.com/calendar/feeds/ppklihq3hv1k05n2phutlu7j84@group.calendar.google.com/public/full?alt=json-in-script&orderby=starttime&max-results=2&singleevents=true&sortorder=ascending&futureevents=true&callback=?';
            			
            			var generateWidget = (function(data, target) {
            				var events = data.feed.entry;
            				for (var i=0; i<events.length; i++) {
            					var event = events[i];
            					console.log(event);	
            					
            					// Clone the calendar widget event primative and hold it in a variable. 
            					var element = $('#calendarwidget_primatives .calendarwidget_event').clone();
            					
            					// Create a readable date from the returned data. 
            					var regex = /([0-9]+)-([0-9]+)-([0-9]+)/.exec(event.gd$when[0].startTime);
            					var d = new Date(regex[1], regex[2]-1, regex[3]);
            					var date = d.toLocaleDateString();
            					
            					$(element).find('.calendarwidget_date').html(date);
            					$(element).find('.calendarwidget_title').html(event.title.$t);
            					
            					$(element).appendTo(target);
            				}
            			});
            			$.getJSON(feedJSONHTHS, function(data) {
            				generateWidget(data, '#calendarwidget_list_hths');
            			});
						$.getJSON(feedJSONMCVSD, function(data) {
            				generateWidget(data, '#calendarwidget_list_mcvsd');
            			});
						$.getJSON(feedJSONPFA, function(data) {
            				generateWidget(data, '#calendarwidget_list_pfa');
            			});
            		});
            	</script>
				<p id="calendarwidget">
					<div id="calendarwidget_header">Upcoming HTHS Events:</div>
					<div id="calendarwidget_list_hths"></div>
					<br />
					<div id="calendarwidget_header">MCVSD Events:</div>
					<div id="calendarwidget_list_mcvsd"></div>
					<br />
					<div id="calendarwidget_header">PFA Events:</div>
					<div id="calendarwidget_list_pfa"></div>
					<div id="calendarwidget_link"><a href="https://www.google.com/calendar/embed?height=600&wkst=1&bgcolor=%23FFFFFF&src=chiefsimonhths%40gmail.com&color=%23182C57&src=5j96g4ul0gkpcbd0ldq6li6mgo%40group.calendar.google.com&color=%23691426&src=ppklihq3hv1k05n2phutlu7j84%40group.calendar.google.com&color=%23856508&ctz=America%2FNew_York">See all events</a></div>
				</p>
				<style type='text/css'>
					#calendarwidget_primatives {
						display: none;
					}
					#calendarwidget_header {
						font-weight: bold;
						font-size: 10pt;
						margin-bottom: 5px;
					}
					.calendarwidget_event {
						padding: 3px;
					}
					.calendarwidget_title {
						font-weight: bold;
						font-size: 9pt;
						display: block;
					}
					.calendarwidget_date {
						font-size: 8pt;
						display: block;
					}
					#calendarwidget_link {
						text-align: center;
						font-weight: bold;
						font-size: 10pt;
						margin-top: 5px;
					}
				</style>
				<div id="calendarwidget_primatives">
					<div class="calendarwidget_event">
						<span class="calendarwidget_title"></span>
						<span class="calendarwidget_date"></span>
					</div>
				</div>
			</div>
			<div id="weather_widget" class="fancybox">
			    <h2 class="fancytitle">Weather</h2>
                <!--Begin Weatherbug Code-->
                <div class="wXstickerbody" style="word-wrap:normal !important;width:180px;height:150px;border:1px #000 solid;background:url(http://img.weather.weatherbug.com/images/stickers/v2/180x150/bg.gif) no-repeat; margin-left: -2px;">
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
	<? endif; ?>
		<div id="clear_float">
		</div>
		</div>
        <div id="footer">
			<div class="left">
            	765 Newman Springs Road, Lincroft, New Jersey 07738<br />
            	Phone: (732) 842-8444 | Fax: (732) 219-9418
            </div>
            
            <div class="right">
            	(c) <?=date('Y',time())?> High Technology High School <br  />
                <a href="<?=site_url('pages/non-discrimination')?>">Non-Discrimination Clause/Anti-Bullying Info</a>
            </div>
        </div>
        
        <div id="mobile_switcher">View site in:<br /><a href="#" id="mobileview">Mobile View</a>&nbsp;|&nbsp;<a href="#" id="desktopview">Desktop View</a></div>
	</body>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28702587-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</html>