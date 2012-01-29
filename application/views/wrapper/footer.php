	<? if(!isset($nosidebar)): ?>	
		<div id="sidebar">
			<div class="fancybox">
				<a href="" class="button_link">>> Prospective Students</a>             
				<a href="" class="button_link">>> Alumni</a>
			</div> 
			<div class="fancybox">
				<p>insert pretty google calendar here</p>
			</div>
			<div class="fancybox">
				<img src="<?=site_url('images/icons/one-call-now-banner-logo.gif')?>" /><br />
				<iframe width="178" height="78" frameborder="0" scrolling="no" marginheight="0" src="https://www.onecallnow.com/Access/Banner/BannerWrapper.aspx?BT=LHB&EGI=0%2fXbzuia0a5jnWFIqn9mcw%3d%3d&S=09,10,11,12,20&L=Click+here+to+replay+the+latest+message+from+High+Technology+High+School.&F=1&Y=s"></iframe>
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
                Non-Discrimination Clause
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