<style>
body {
	margin-top: 35px;
}
.toolbar {
	height: 35px;
	position: fixed;
	top: 0;
	left: 0;
	right: 0;
	background-color: #DDD;
	z-index: 9001;
	box-shadow: 0 0 10px rgba(0,0,0,0.5)
}
.toolbar_inner {
	width: 800px;
	margin-left: auto;
	margin-right: auto;
	text-align: left;
}
.toolbar span {
	font-weight: bold;
	font-size: 1.2em;
	display: inline-block;
	float: left;
	margin-top: 7px;
}
ul.toolbar_actions {
	list-style-type: none;
	margin: 0;
	padding: 0;
	display: inline-block;
	float: right;
}
ul.toolbar_actions li {
	display: inline-block;
}
ul.toolbar_actions li a {
	display: inline-block;
	height: 100%;
	padding: 8px 10px 10px 10px;
	border-left: 1px solid #999;
	border-right: 1px solid #999;
	margin-left: -1px;
	text-decoration: none;
}
</style>

<div class="toolbar">
	<div class="toolbar_inner">
		<span>Hello, Admin</span>
		<ul class="toolbar_actions">
			<!-- Note: Leave out the closing </li> tags to prevent extra blank space from appearing-->
			<li><a href="<?=site_url("admin")?>">Admin Panel</a>
			<li><a href="<?=site_url("admin/logout")?>">Logout</a>
		</ul>
	</div>
</div>