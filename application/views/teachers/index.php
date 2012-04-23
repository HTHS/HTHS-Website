<?php
function get_teacher_photo($username) {
    if (file_exists('images/teachers/' . $username.'.png')) {
        return base_url('images/teachers/' . $username.'.png');
    } else {
        return base_url('images/teachers/unknown.png');
    }
}
?>

<style type="text/css">
#teacherbox_container {
	overflow: auto;
}
.teacherbox_outer {
	width: 50%;
	float: left;
}
.teacherbox_outer:nth-child(odd) {
	clear: left;
}
.teacherbox {
	margin: 10px;
	padding: 10px 10px 17px 10px;
	box-shadow: 0px 2px 15px #DDD;
	border-left: 1px solid #CCC;
	border-top: 1px solid #CCC;
	border-right: 1px solid #CCC;
	position: relative;
}
.teacherbox:after {
	content: "";
	width: 100%;
	position: absolute;
	bottom: 0px;
	left: 0px;
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
.teacherbox_photo img {
    width: 80px;
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
	font-size: 15pt;
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
				<? foreach($teachers as $teacher): ?>
				<div class="teacherbox_outer">
					<div class="teacherbox">
						<div class="teacherbox_info">
							<div class="teacherbox_photo"><img src="<?=get_teacher_photo($teacher->username);?>"></img></div>
							<div class="teacherbox_links">
								<a class="teacherbox_link" href="<?=site_url('teachers/' . $teacher->username . '/')?>">About</a>
								<a class="teacherbox_link teacherbox_link_left" href="<?=site_url('teachers/' . $teacher->username . '#blog')?>">Blog</a>
								<a class="teacherbox_link teacherbox_link_right" href="<?=site_url('teachers/' . $teacher->username . '#pages')?>">Pages</a>
								<a class="teacherbox_link" href="<?=site_url('teachers/' . $teacher->username . '/contact')?>">Contact</a>
							</div>
						</div>
						<div class="teacherbox_title">
							<div class="teacherbox_name" title="Teacher's Name"><?=$teacher->prefix.''.$teacher->first_name.''.$teacher->last_name.''.$teacher->last_name.''.$teacher->suffix?></div>
							<div class="teacherbox_subject" title="Teacher's Subject"><?=$teacher->subject?></div>
						</div>
					</div>
				</div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
</div>