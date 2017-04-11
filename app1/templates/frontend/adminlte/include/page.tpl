  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
			{$description}
    </section>
    <!-- /.content -->
  </div>
  
  
<script>
	{* Default init for for Title, Breadcrumb *}
	$( document ).ready(function() {
		$(".content").before(BSHelper.PageHeader({ 
			title:"{$title}", 
			title_desc:"{$title_desc}", 
			bc_list:[
				{ icon:"fa fa-dashboard", title:"Home", link:"{$.const.HOME_LNK}" },
				{ icon:"", title:"{$title}", link:"" },
			]
		}));
	});
	{* 
	$(".connectedSortable").sortable({
		placeholder: "sort-highlight",
		connectWith: ".connectedSortable",
		handle: ".box-header, .nav-tabs",
		forcePlaceholderSize: true,
		zIndex: 999999
	});
	
	$(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
	 *}
	{* var conhead = $('.content-header');
	var info_list = $('<ul id="info_marquee" class="info-marquee marquee" />');
	$.ajax({ url: setInfo_url, method: "GET", async: true, dataType: 'json',
		success: function(data) {
			$.each(data.data.rows, function(k, v){
				console.log(v.description);
				if (v.description != '') {
					$('<li />').html(v.description).appendTo(info_list);
					conhead.prepend(info_list);
					$('#info_marquee').marquee({ yScroll: "bottom" });
				}
			});
		},
		error: function(data) {
			console.log(data.responseText);
			if (data.status==500){
				var message = data.statusText;
			} else {
				var error = JSON.parse(data.responseText);
				var message = error.message;
			}
			$('<li />').html(message).appendTo(info_list);
			conhead.prepend(info_list);
			$('#info_marquee').marquee();
		}
	}); *}
</script>
