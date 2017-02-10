  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {$title}
        <small>{$short_desc}</small>
      </h1>
      {* <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> *}
    </section>

    <!-- Main content -->
    <section class="content">
			{$description}
			{* 
      <!-- Small boxes (Stat box) -->
      <div class="row">
				{foreach $content_box_3 as $board}
				{include $theme_path ~ "pages/{$board}"}
				{/foreach}
      </div>
			 *}
      <!-- /.row -->
			{* 
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
					{foreach $content_box_7 as $board}
						{include $theme_path ~ "pages/{$board}"}
					{/foreach}
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
					{foreach $content_box_5 as $board}
						{include $theme_path ~ "pages/{$board}"}
					{/foreach}
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
			 *}
    </section>
    <!-- /.content -->
  </div>
  
  
<script>
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
	var conhead = $('.content-header');
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
	});
</script>
