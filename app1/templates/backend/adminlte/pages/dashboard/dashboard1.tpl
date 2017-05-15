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
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  
  
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/summernote/summernote.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/datepicker/datepicker3.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/tag-it/css/jquery.tagit.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/tag-it/css/tagit.ui-zendesk.css">
<script src="{$.const.TEMPLATE_URL}plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/summernote/summernote.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/tag-it/js/tag-it.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Start :: Init for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));
	{* End :: Init for Title, Breadcrumb *}
	
	$.getJSON($url_module, {}, function(result){ 
		{* // console.log(data[0]); *}
		if (result.status){
			var c = [], r = [], a = [];
			$.each(result.data, function(i, val){
				{* console.log(val.type); *}
				if (val.type == 'BOX-3'){
					var link = val.link ? $BASE_URL+val.link : '';
					c.push(BSHelper.WidgetBox3({ title:val.name, color:val.color, value:val.value, icon:val.icon, link:link }));
				}
			});
			$(".box-3").append(c);
			{* console.log(c); *}
		}
	});
	
	function qemail(){
		var col = [], row = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		var box1 = BSHelper.Box({ type:"info", header:true, title:"Quick Email", toolbtn:['min','rem'], footer:true });
		col.push(BSHelper.Input({ horz:false, type:"text", idname:"email_from", value:"{$.session.user_email}", readonly:true }) );
		col.push(BSHelper.Input({ horz:false, type:"text", idname:"email_to", required: true, placeholder:"Email to:" }) );
		col.push(BSHelper.Input({ horz:false, type:"text", idname:"subject", required: true, placeholder:"Subject:" }) );
		col.push(BSHelper.Input({ horz:false, type:"textarea", idname:"body_content", cls:"summernote", placeholder:"Message" }));
		form1.append( col );
		box1.find('.box-header h3').before($('<i class="fa fa-envelope"></i>'));
		box1.find('.box-body').append(form1);
		box1.find('.box-footer').addClass('clearfix').append('<button type="button" class="pull-right btn btn-default" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>');
		box1.find("#email_to").tagit({ placeholderText:"Email to:" });
		box1.find(".summernote")
			.summernote({ height: 150, minHeight: null, maxHeight: null, focus: true })
			.summernote('code', '');
		box1.find('.note-btn').attr('title', '');
		return box1;
	}
	$(".col-lg-7").append(qemail());

	function wcal(){
		var col = [], row = [];
		var box1 = BSHelper.Box({ type:"info", header:true, title:"Calendar", toolbtn:['min','rem'] });
		box1.find('.box-header h3').before($('<i class="fa fa-calendar"></i>'));
		box1.find('.box-body').append('<div id="calendar" style="width: 100%"></div>');
		box1.find("#calendar").datepicker({ todayHighlight:true });
		return box1;
	}
	$(".col-lg-5").append(wcal());
	
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
