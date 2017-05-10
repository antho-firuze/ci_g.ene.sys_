  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row box-3">
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
			{foreach $content_box_7 as $board}
				{include $.const.TEMPLATE_PATH ~ "pages/{$board}"}
			{/foreach}
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
			{foreach $content_box_5 as $board}
				{include $.const.TEMPLATE_PATH ~ "pages/{$board}"}
			{/foreach}
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  
  
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Start :: Init for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));
	
	$.getJSON($url_module, {}, function(result){ 
		{* // console.log(data[0]); *}
		if (result.status){
			var c = [], r = [], a = [];
			$.each(result.data, function(i, val){
				{* console.log(val.type); *}
				if (val.type == 'BOX-3'){
					c.push(BSHelper.WidgetBox3({ title:val.name, color:val.color, value:val.value, icon:val.icon, link:val.link }));
				}
			});
			$(".box-3").append(c);
			{* console.log(c); *}
		}
	});
	
	
	{* End :: Init for Title, Breadcrumb *}
	{* $(".connectedSortable").sortable({
		placeholder: "sort-highlight",
		connectWith: ".connectedSortable",
		handle: ".box-header, .nav-tabs",
		forcePlaceholderSize: true,
		zIndex: 999999
	}); *}
	
	{* $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move"); *}

	{* var conhead = $('.content-header'); *}
	{* var info_list = $('<ul id="info_marquee" class="info-marquee marquee" />'); *}
	{* $.ajax({ url: InfoLst_url, method: "GET", async: true, dataType: 'json', *}
		{* success: function(data) { *}
			{* $.each(data.data.rows, function(k, v){ *}
				{* if (v.description) { *}
					{* $('<li />').html(v.description).appendTo(info_list); *}
					{* conhead.prepend(info_list); *}
					{* $('#info_marquee').marquee({ yScroll: "bottom" }); *}
				{* } *}
			{* }); *}
		{* }, *}
		{* error: function(data) { *}
			{* if (data.status==500){ *}
				{* var message = data.statusText; *}
			{* } else { *}
				{* var error = JSON.parse(data.responseText); *}
				{* var message = error.message; *}
			{* } *}
			{* console.log('[Error: info_list]: '+message); *}
		{* } *}
	{* }); *}
</script>
