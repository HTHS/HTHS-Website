<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Subscribe to News Feed</h2>
			<?=validation_errors()?>
			<p>Enter your email address below to subscribe to news from High Technology High School.
			Important news announcments will be automatically emailed to you.
			You may unsubscribe at any time.</p>
		</div>
	</div>
	<div id="content_left_below">
		<div id="content_left_left">
			<div class="fancybox">
				<h2 class="fancytitle">Subscribe</h2>
				<p>Email Address: </p>
				<form action="<?=current_url()?>" method="post">
					<input type="text" name="email_address" value="<?=set_value('email_address')?>" size="25" />
					<input type="submit" name="submit" value="Subscribe" />
				</form>
			</div>
		</div>
		<div id="content_left_right">
			<div class="fancybox">
				<h2 class="fancytitle red">Unsubscribe</h2>
				<p>Email Address: </p>
				<form action="<?=current_url()?>" method="post">
					<input type="text" name="email_address" value="<?=set_value('email_address')?>" size="35" />
					<input type="submit" name="submit" value="Unsubscribe" />
				</form>
			</div>
		</div>
	</div>
</div>