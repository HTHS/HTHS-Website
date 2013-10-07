	<?php if(!isset($nosidebar)): ?>	
		<div id="sidebar">
			<div class="fancybox">
				<a href="<?=site_url('teachers/dashboard')?>" class="button_link">>> Home</a>
				<a href="<?=site_url('teachers/dashboard/change_password')?>" class="button_link">>> Change Password</a>             
				<a href="<?=site_url('teachers/dashboard/logout')?>" class="button_link">>> Logout</a>
			</div> 
			<div class="fancybox">
				<h2 class="fancytitle red">User Data</h2>
				<p>Logged In As: <b><?=$this->session->userdata('username')?></b></p>
				<p>Connected From: <b><?=$this->input->ip_address()?></b></p>
			</div>
		</div>
	<?php endif; ?>
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