	<? if(!isset($nosidebar)): ?>	
		<div id="sidebar">
			<div class="fancybox">
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
			<div class="fancybox">
            	<h2 class="fancytitle">Calendar</h2>
            	<script type="text/javascript">
            		$(function() {
            			var feedJSON = 'https://ajax.googleapis.com/ajax/services/feed/load?v=1.0&q=https://www.google.com/calendar/feeds/chiefsimonhths%40gmail.com/public/basic&callback=?';
            			$.getJSON(feedJSON, function(data) {
            				var events = data.responseData.feed.entries;
            				for (var i=0; i<events.length; i++) {
            					var event = events[i];
            					
            					// Clone the calendar widget event primative and hold it in a variable. 
            					var element = $('#calendarwidget_primatives .calendarwidget_event').clone();
            					
            					// Extract the date from the returned data. 
            					var regex = /When: ([a-zA-Z0-9:,\- ]*)/;
            					var result = regex.exec(event.contentSnippet);
            					
            					$(element).find('.calendarwidget_date').html(result[1]);
            					$(element).find('.calendarwidget_title').html(event.title);
            					
            					$(element).appendTo('#calendarwidget_list');
            				}
            			});
            		});
            	</script>
				<p id="calendarwidget">
					<div id="calendarwidget_header">Upcoming Events:</div>
					<div id="calendarwidget_list"></div>
					<div id="calendarwidget_link"><a href="https://www.google.com/calendar/b/0/embed?src=chiefsimonhths@gmail.com&ctz=America/New_York">See all events</a></div>
				</p>
				<style type='text/css'>
					#calendarwidget_primatives {
						display: none;
					}
					#calendarwidget_header {
						text-align: center;
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
			<div class="fancybox">
				<img src="<?=site_url('images/icons/one-call-now-banner-logo.gif')?>" /><br />
				<iframe width="178" height="125" frameborder="0" scrolling="no" marginheight="0" src="https://www.onecallnow.com/Access/Banner/BannerWrapper.aspx?BT=LHB&EGI=0%2fXbzuia0a5jnWFIqn9mcw%3d%3d&S=09,10,11,12,20&L=Click+the+call+button+to+replay+the+latest+message+from+High+Technology+High+School.&F=1&Y=s"></iframe>
			</div>
			
			<div class="fancybox">
				<img src="<?=site_url('images/icons/one-call-now-banner-logo-family-profile.gif')?>" /><br />
				<table>
					<tr>
						<td><img src="<?=site_url('images/icons/plus.gif')?>" /></td>
						<td><a href="https://secure.onecallnow.com/Access/FamilyProfile/FamilyProfile.aspx?G=DBWFgIxwNPowx%2bNPnanAWg%3d%3d">
							Click here to add additional phone numbers and e-mail addresses to our automated messaging system.</a></td>
					</tr>
				</table>
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
                <a href="">Non-Discrimination Clause</a>
            </div>
        </div>

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