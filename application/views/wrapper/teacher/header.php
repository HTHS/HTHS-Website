<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Cache-Control" content="NO-CACHE" />
		<title>High Technology High School</title>
        <link type="text/css" href="<?=site_url('css/template.css')?>" rel="stylesheet" />
		<link type="text/css" href="<?=site_url('css/jquery-ui-1.8.17.custom.css')?>" rel="stylesheet" />
		<script src="<?=site_url('js/jquery-1.7.1.min.js')?>" type="text/javascript"></script>
		<script src="<?=site_url('js/jquery-ui-1.8.17.custom.min.js')?>" type="text/javascript"></script>
	</head>

	<body>

    
		<div id="header">
			<div id="header_container">
				<div id="header_links">
				</div>
				
				<div id="title_wrapper">
					<h1>HIGH TECHNOLOGY HIGH SCHOOL</h1>
				</div>
				
				<div id="navbar">
					<ul>
						<li><a href="<?=site_url()?>">Site Home</a></li>
						<li><a href="">Dashboard</a></li>
						<li><a href="<?=site_url('teacher_dashboard/about')?>">My Info</a>
							<? if($this->session->userdata('mentorship_admin')): ?>
								<ul>
									<li><a href="<?=site_url('teacher_dashboard/about')?>">Edit Info</a></li>
									<li><a href="<?=site_url('teacher_dashboard/mentorship')?>">Mentorship</a></li>
								</ul>
							<? endif; ?>
						</li>
						<li><a href="<?=site_url('teacher_dashboard/pages')?>">My Pages</a>
							<ul>
								<li><a href="<?=site_url('teacher_dashboard/add_page')?>">Add Page</a></li>
								<li><a href="<?=site_url('teacher_dashboard/pages')?>">Manage Pages</a></li>
							</ul>
						</li>
						<li><a href="<?=site_url('teacher_dashboard/blog')?>">My Blog</a>
                        	<ul>
                                <li><a href="<?=site_url('teacher_dashboard/add_blog')?>">Add Blog Entry</a></li>
                                <li><a href="<?=site_url('teacher_dashboard/blog')?>">Manage Blog</a></li>
                            </ul>
                        </li>
						<li><a href="">Placeholder</a></li>
						<li><a href="<?=site_url('teacher_dashboard/change_password')?>">Password</a></li>
                        <li><a href="<?=site_url('teacher_dashboard/logout')?>">Logout</a></li>
					</ul>
				</div>
			</div>
        </div>
        
        <div id="container">
        
                
				
            
            
