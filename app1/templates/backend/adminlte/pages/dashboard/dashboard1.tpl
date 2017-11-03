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
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/marquee/css/jquery.marquee.min.css">
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/tag-it/css/jquery.tagit.css"> *}
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/tag-it/css/tagit.ui-zendesk.css"> *}
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/jQueryUI/jquery-ui.min.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/summernote/summernote.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/datepicker/bootstrap-datepicker.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/tag-it/js/tag-it.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/textfill/jquery.textfill.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/marquee/lib/jquery.marquee.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Start :: Init for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));
	{* End :: Init for Title, Breadcrumb *}
	
  var visitorsData = {};
	$.getJSON($url_module, {}, function(result){ 
		{* // console.log(data[0]); *}
		if (result.status){
			var c = [], r = [], a = [];
			$.each(result.data, function(i, val){
				{* console.log(val.type); *}
				if (val.type == 'BOX-3'){
					var link = val.link ? $BASE_URL+val.link : '';
					c.push(BSHelper.WidgetBox3({ title:val.name, color:val.color, value:val.value, icon:val.icon, link:link, tooltip:val.description, seq:val.seq }));
				}
				if (val.type == 'BOX-7' && val.name == 'Quick Email'){
					r.push(qemail());
				}
				if (val.type == 'BOX-5' && val.name == 'Calendar'){
					a.push(wcal());
				}
				if (val.type == 'BOX-7' && val.name == 'Visitor Maps'){
					visitorsData = val.value;
					r.push(visitor_maps());
				}
			});
			if (c)
				$(".box-3").append(c);
			if (r)
				$(".col-lg-7").append(r);
			if (a)
				$(".col-lg-5").append(a);
			{* console.log(c); *}
			if ($('#world-map').length > 0){
				$('#world-map').vectorMap({
					map: 'world_mill_en',
					backgroundColor: "transparent",
					regionStyle: {
						initial: {
							fill: '#e4e4e4',
							"fill-opacity": 1,
							stroke: 'none',
							"stroke-width": 0,
							"stroke-opacity": 1
						}
					},
					series: {
						regions: [{
							values: visitorsData,
							scale: ['#b6d6ff', '#005ace'],
							normalizeFunction: 'polynomial'
						}]
					},
					onRegionLabelShow: function (e, el, code) {
						if (typeof visitorsData[code] != "undefined")
							el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
					}
				});
			}
		}
		{* console.log($('div.small-box h3').html()); *}
		$('div.small-box div.val').textfill({	maxFontPixels: 38 });
		$('div.small-box div.title').textfill({	maxFontPixels: 15 });
	});
	
	function qemail(){
		var col = [], row = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		var box1 = BSHelper.Box({ type:"info", header:true, title:"Quick Email", icon:"fa fa-envelope", toolbtn:['min','rem'], footer:true });
		col.push(BSHelper.Input({ horz:false, type:"text", idname:"email_from", value:"{$.session.user_email}", readonly:true }) );
		col.push(BSHelper.Input({ horz:false, type:"text", idname:"email_to", required: true, placeholder:"Email to:", role:"tagsinput" }) );
		col.push(BSHelper.Input({ horz:false, type:"text", idname:"subject", required: true, placeholder:"Subject:" }) );
		col.push(BSHelper.Input({ horz:false, type:"textarea", idname:"message", cls:"summernote", placeholder:"Message" }));
		{* col.push(BSHelper.Button({ type:"submit", label:'Send <i class="fa fa-arrow-circle-right"></i>', idname:"submit_btn" })); *}
		form1.append( col );
		box1.find('.box-body').append(form1);
		box1.find('.box-footer').addClass('clearfix').append('<button type="button" class="pull-right btn btn-info" id="sendEmail">Send <i class="fa fa-arrow-circle-right"></i></button>');
		box1.find("#email_to").tagsinput();
		box1.find("#email_to").on('itemAdded itemRemoved', function(event) {
			$(this).parents('.control-input').find('input').attr('placeholder', $(this).val() ? '' : 'Email to:');
		});
		box1.find(".summernote")
			.summernote({ height: 150, minHeight: null, maxHeight: null, focus: true })
			.summernote('code', '');
		box1.find('.note-btn').attr('title', '');
		
		box1.find('#sendEmail').click(function(e){
			{* form1.validator().trigger('submit'); *}
			form1.validator('validate');
			if (form1.find(".has-error").length > 0) { return false; }
			
			paceOptions = {	ajax: true };
			Pace.restart();
			
			{* console.log(form1.serializeJSON()); *}
			box1.find('#sendEmail').prop( "disabled", true );
			form1.append( BSHelper.Input({ type:"hidden", idname:"send_mail", value:1 }) );
			
			$.ajax({ url: $url_module, method: "POST", async: true, dataType:'json',
				data: form1.serializeJSON(),
				success: function(data) {
					form1.shollu_autofill('reset');
					box1.find('#sendEmail').prop( "disabled", false );
					BootstrapDialog.alert(data.message);
				},
				error: function(data) {
					if (data.status==500){
						var message = data.statusText;
					} else {
						var error = JSON.parse(data.responseText);
						var message = error.message;
					}
					box1.find('#sendEmail').prop( "disabled", false );
					BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
				}
			});
			
			paceOptions = {	ajax: false };
		});
		return box1;
	}

	function wcal(){
		var col = [], row = [];
		var box1 = BSHelper.Box({ type:"info", header:true, title:"Calendar", icon:"fa fa-calendar", toolbtn:['min','rem'] });
		box1.find('.box-body').append($('<div id="calendar" style="width: 100%"> </div>'));
		box1.find("#calendar").datepicker({ todayHighlight: true, format:"yyyy-mm-dd",
			beforeShowDay: function(date){
				{* var dateFormat = date.getUTCFullYear() + '-' + (date.getUTCMonth()+1) + '-' + date.getUTCDate(); *}
				{* var dateFormat = date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate(); *}
				{* console.log(dateFormat); *}
				{* if (dateFormat == '2017-10-1'){ *}
					{* console.log(dateFormat); *}
					{* return { classes: 'highlight', tooltip: 'Title', content:'<a target="_blank" href="#">'+date.getDate()+'</a>' }; *}
				{* } *}
			}
		})
			.on("changeDate", function(e){
				var link = $BASE_URL+"systems/x_page?pageid=231&cfilter="+e.format();
				window.open(link, "_blank");
				{* window.location.replace(link); *}

				{* console.log(e.format()); *}
			})
			.on("changeMonth", function(e){
				{* console.log(e.timeStamp); *}
				{* console.log(unix_timestamp_format(e.timeStamp)); *}
			});
		return box1;
	}
	
	function visitor_maps(){
		var col = [], row = [];
		var box1 = BSHelper.Box({ type:"info", cls:"bg-light-blue-gradient", header:true, title:"Visitor Maps", icon:"fa fa-map-marker", toolbtn:['min','rem'] });
		box1.find('.box-body').append($('<div id="world-map" style="height: 250px; width: 100%;"> </div>'));
		return box1;
	}
	
	$.ajax({ url: "{$.const.X_INFO_LNK}?valid=1", method: "GET", async: true, dataType: 'json',
		success: function(result) {
			if (! isempty_arr(result.data.rows)) {
				var info_list = $('<ul id="info_marquee" class="info-marquee marquee" />');
				var info = [];
				$.each(result.data.rows, function(k, v){
					if (v.description) {
						console.log(v.description);
						info_list.append($('<li />').html(v.description));
					}
				});
				$(".content-header").before(info_list);
				$("#info_marquee").marquee({ yScroll: "bottom" });
			}
		},
		error: function(data) {
			if (data.status==500){
				var message = data.statusText;
			} else {
				var error = JSON.parse(data.responseText);
				var message = error.message;
			}
			console.log('[Error: info_list]: '+message);
		}
	});
</script>
