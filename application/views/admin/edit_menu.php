<script type="text/javascript">
$(function() {
	var menu = <?=$menu?>;
});
</script>

<style type="text/css">
#menueditor {
	width: 500px;
	border: 1px solid #555;
	border-bottom: 0;
}
.menueditor_item, .menueditor_additem {
	border-bottom: 1px solid #555;
	
	background: #ededed; /* Old browsers */
	background: -moz-linear-gradient(top,  #ededed 42%, #ffffff 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(42%,#ededed), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #ededed 42%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #ededed 42%,#ffffff 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #ededed 42%,#ffffff 100%); /* IE10+ */
	background: linear-gradient(top,  #ededed 42%,#ffffff 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ededed', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}
.menueditor_item_remove {
	float: left;
	padding: 7px;
	text-align: center;
}
.menueditor_button {
	border: 1px solid #777;
	width: 20px;
	height: 20px;
	display: inline-block;
	border-radius: 3px;
	font-size: 16pt;
	text-align: center;
	
	background: #eeeeee; /* Old browsers */
	background: -moz-linear-gradient(top,  #eeeeee 0%, #cccccc 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#eeeeee), color-stop(100%,#cccccc)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* IE10+ */
	background: linear-gradient(top,  #eeeeee 0%,#cccccc 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#eeeeee', endColorstr='#cccccc',GradientType=0 ); /* IE6-9 */

	text-shadow: 1px 1px 1px #FFF;
}
.menueditor_item_linkwrapper {
	margin-left: 35px;
	border-left: 1px solid #555;
}
.menueditor_item_link {
	border-bottom: 1px solid #555;
	padding: 7px;
}
.menueditor_item_link_title, .menueditor_item_link_url {
	width: 180px;
}
.menueditor_item_addlink {
	padding: 7px;
}
.menueditor_item_addlink .menueditor_button, .menueditor_additem .menueditor_button {
	margin-right: 10px;
}
.menueditor_item_link_remove {
	display: inline-block;
	margin-right: 10px;
}
.menueditor_additem {
	padding: 7px;
}
#menueditor_submit {
	text-align: center;
	width: 500px;
	padding: 10px;
}
#menueditor_submit .menueditor_button {
	font-size: inherit;
	width: auto;
	height: auto;
	padding: 3px;
}
</style>

<div class="fancybox">
	<h2 class="fancytitle">Menu Editor</h2>
	<div id="menueditor">
		<div class="menueditor_item">
			<div class="menueditor_item_remove"><a class="menueditor_button" href="#">-</a></div>
			<div class="menueditor_item_linkwrapper">
				<div class="menueditor_item_link">
					<input class="menueditor_item_link_title"></input>&nbsp;-&gt;&nbsp;<input class="menueditor_item_link_url"></input>
				</div>
				<div class="menueditor_item_link">
					<div class="menueditor_item_link_remove"><a class="menueditor_button" href="#">-</a></div>
					<input class="menueditor_item_link_title"></input>&nbsp;-&gt;&nbsp;<input class="menueditor_item_link_url"></input>
				</div>
				<div class="menueditor_item_link">
					<div class="menueditor_item_link_remove"><a class="menueditor_button" href="#">-</a></div>
					<input class="menueditor_item_link_title"></input>&nbsp;-&gt;&nbsp;<input class="menueditor_item_link_url"></input>
				</div>
				<div class="menueditor_item_addlink">
					<a class="menueditor_button" href="#">+</a> Add Submenu Item
				</div>
			</div>
		</div>
		<div class="menueditor_additem">
			<a class="menueditor_button" href="#">+</a> Add Menu Item
		</div>
	</div>
	<div id="menueditor_submit"><a class="menueditor_button" href="#">Save Menu</a></div>
</div>
