<script type="text/javascript" src="<?=site_url()?>js/jquery.json-2.3.min.js"></script>
<script type="text/javascript">
var menueditor = {
	remove_item: function(item) {
		if (confirm('Are you sure you want to remove this item?')) {
			$(item).remove();
		}
	},
	add_item: function() {
		var index = $('#menueditor_primitives > .menueditor_item').clone().insertBefore('#menueditor_additem').index('*');
		return $('*').eq(index);
	},
	remove_link: function(link) {
		if (confirm('Are you sure you want to remove this link?')) {
			$(link).remove();
		}
	},
	add_link: function(item) {
		var element = $(item).find('.menueditor_item_addlink');
		var index = $('#menueditor_primitives > .menueditor_item_link').clone().insertBefore(element).index('*');
		return $('*').eq(index);
	},
	load_data: function(data) {
		var this_class = this;
		for item in data {
			var item_element = this_class.add_item();
			for link in item {
				var link_element = this_class.add_link(item_element);
				$(link_element).find('menueditor_item_link_title').value(link.title);
				$(link_element).find('menueditor_item_link_url').value(link.url);
			}
		}
	},
	save_data: function() {
		var this_class = this;
		var data = new Array();
		$('.menueditor_item').each(function() {
			var data_item = new Array();
			$(this).find('.menueditor_item_link').each(function() {
				var data_link = new Object();
				data_link.title = $(this).find('menueditor_item_link_title').value();
				data_link.url = $(this).find('menueditor_item_link_url').value();
				data_item.push(data_link);
			});
			data.push(data_item);
		});
		return $.toJSON(data);
	}
}

$(function() {
	//var menu = <?=$menu?>;
});
</script>

<style type="text/css">
#menueditor {
	width: 500px;
	border: 1px solid #555;
	border-bottom: 0;
}
.menueditor_item, #menueditor_additem {
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
.menueditor_item_addlink .menueditor_button, #menueditor_additem .menueditor_button {
	margin-right: 10px;
}
.menueditor_item_link_remove {
	display: inline-block;
	margin-right: 10px;
}
#menueditor_additem {
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
#menueditor_primitives {
	display: none;
}
</style>

<div class="fancybox">
	<h2 class="fancytitle">Menu Editor</h2>
	<div id="menueditor_primitives">
		<div class="menueditor_item">
		    <div class="menueditor_item_remove"><a class="menueditor_button" href="#">-</a></div>
		    <div class="menueditor_item_linkwrapper">
		        <div class="menueditor_item_addlink">
		            <a class="menueditor_button" href="#">+</a> Add Submenu Item
		        </div>
		    </div>
		</div>
		<div class="menueditor_item_link">
			<div class="menueditor_item_link_remove"><a class="menueditor_button" href="#">-</a></div>
			<input class="menueditor_item_link_title"></input>&nbsp;-&gt;&nbsp;<input class="menueditor_item_link_url"></input>
		</div>
	</div>
	<div id="menueditor">
		<div id="menueditor_additem">
			<a class="menueditor_button" href="#">+</a> Add Menu Item
		</div>
	</div>
	<div id="menueditor_submit"><a class="menueditor_button" href="#">Save Menu</a></div>
</div>
