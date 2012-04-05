<style type="text/css">
#teacherbox_container {
	margin-right: 20px;
}
.teacherbox_outer {
	width: 50%;
}
.teacherbox_outer:nth-child(even) {
	margin-right: -20px;
}
.teacherbox {
	margin: 10px;
	padding: 10px;
	box-shadow: 0px 2px 15px #AAA;
	border: 0;
	border-bottom: 7px solid #A70000;
}
.teacherbox_info {
	height: 101px;
}
.teacherbox_photo {
	float: left;
	width: 80px;
	height: 100%;
	overflow: hidden;
}
.teacherbox_links {
	margin-left: 90px;
	height: 100%;
}
.teacherbox_link {
	display: block;
	width: 100%;
	height: 25px;
	margin-bottom: 10px;
	border: 1px solid #CCC;
	background-color: #777; 
	color: #FFF !important;
	font-size: 15px;
	text-transform: uppercase;
	font-weight: bold;
	line-height: 25px;
	text-indent: 7px;
	text-shadow: -1px -1px #000;
	box-shadow: 2px 2px 3px #AAA;
}
.teacherbox_link:active {
	box-shadow: 1px 1px 3px #AAA;
}
.teacherbox_link_left {
	float: left;
	width: 47%;
}
.teacherbox_link_right {
	margin-left: 53%;
	width: 47%;
	clear: right;
}
.teacherbox_title {
	clear: both;
	margin-top: 10px;
}
.teacherbox_name {
	font-size: 16pt;
	font-weight: bold;
}
.teacherbox_subject {
	text-transform: uppercase;
	font-size: 10pt;
}
</style>

<div id="content_left">
	<div id="content_left_above">
		<div class="fancybox">
			<h2 class="fancytitle black">Teachers & Faculty</h2>
			
			<div id="teacherbox_container">
				<? foreach($teachers->result() as $teacher): ?>
				<div class="teacherbox_outer">
					<div class="teacherbox">
						<div class="teacherbox_info">
							<div class="teacherbox_photo"></div>
							<div class="teacherbox_links">
								<a class="teacherbox_link" href="<?=site_url('teachers/' . $teacher->username . '/')?>">About</a>
								<a class="teacherbox_link teacherbox_link_left" href="<?=site_url('teachers/' . $teacher->username . '#blog')?>">Blog</a>
								<a class="teacherbox_link teacherbox_link_right" href="<?=site_url('teachers/' . $teacher->username . '#pages')?>">Pages</a>
								<a class="teacherbox_link" href="<?=site_url('teachers/' . $teacher->username . '/contact')?>">Contact</a>
							</div>
						</div>
						<div class="teacherbox_title">
							<div class="teacherbox_name"><?=$teacher->name?></div>
							<div class="teacherbox_subject"><?=$teacher->subject?></div>
						</div>
					</div>
				</div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
</div>