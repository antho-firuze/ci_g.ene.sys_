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
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<style>
{* for calendar *}
.calDayGreen {
	background-color: green;
}
.calDayRed {
	background-color: red;
}
</style>
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

	function wcal(fdate, tdate){
		var fdate = typeof(fdate) == 'undefined' ? new Date() : fdate;
		var tdate = typeof(tdate) == 'undefined' ? new Date() : tdate;
		var calendar_value;

		fdate = isDate(fdate) ? fdate : dateParsing(fdate, "yyyy-mm-dd");
		fdate = start_month(fdate, "yyyy-mm-dd");
		tdate = isDate(tdate) ? tdate : dateParsing(tdate, "yyyy-mm-dd");
		tdate = end_month(tdate, "yyyy-mm-dd");

		$.getJSON("{$.php.base_url()}"+"cashflow/get_calendar_value?fdate="+fdate+"&tdate="+tdate, {}, function(response){
			calendar_value = response.data;
			create_cal();
		});
		
		function create_cal(){
			var box_container = $("#box-calendar");
			if (! box_container.length) {
				var box1 = BSHelper.Box({ type:"info", idname: "box-calendar", header:true, title:"Calendar", icon:"fa fa-calendar", toolbtn:['min','rem'] });
				var container = $('<div id="calendar" style="width: 100%" />');
				box1.find('.box-body').append(container);
			} else {
				var container = $("#box-calendar").find("#calendar");
				if (container.length) {
					container.datepicker("destroy");
					container.remove();
				} 
				container = $('<div id="calendar" style="width: 100%" />');
				box_container.find('.box-body').append(container);
			}
			
			container.datepicker({ format:"yyyy-mm-dd", 
				beforeShowDay: function(date){
					var dateFormat = date.getFullYear() + '-' + ((date.getMonth()+1)<10?('0'+(date.getMonth()+1)):(date.getMonth()+1)) + '-' + (date.getDate()<10?('0'+date.getDate()):date.getDate());
					
					var cMoney = parseFloat(calendar_value[dateFormat]);
					var cTitle = accounting.formatMoney(cMoney, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}");
					var cColor = !cMoney ? "" : (cMoney > 0 ? "calDayGreen" : "calDayRed");
					
					return { classes: cColor, tooltip: cTitle };
				}
			})
			.datepicker('setDate',fdate)
			.on("changeDate", function(e){
				{* console.log(e.format()); *}
				if (e.format()) {
					{* var link = $BASE_URL+"systems/x_page?pageid=231&cfilter="+e.format(); *}
					var param = ["date", e.format()];
					var link = URI($BASE_URL+"systems/x_page?pageid=231").addSearch("filter", param.join("="));
					window.open(link, "_blank");
					container.datepicker('setDate',null);
				}
			})
			.on("changeMonth", function(e){
				var fdate = start_month(e.date, "yyyy-mm-dd");
				var tdate = end_month(e.date, "yyyy-mm-dd");
				wcal(fdate, tdate);
			})
			.datepicker('setDate',null);
				
			if (! box_container.length)
				$(".col-lg-5").append(box1);
		}
	}
	
	function visitor_maps(){
		var col = [], row = [];
		var box1 = BSHelper.Box({ type:"info", cls:"bg-light-blue-gradient", header:true, title:"Visitor Maps", icon:"fa fa-map-marker", toolbtn:['min','rem'] });
		box1.find('.box-body').append($('<div id="world-map" style="height: 250px; width: 100%;"> </div>'));
		return box1;
	}
	
	var $pageid = getURLParameter("pageid");
	var url = URI($X_INFO_LNK).addSearch('valid', 1).addSearch('pageid', $pageid);
	$.ajax({ url: url, method: "GET", async: true, dataType: 'json',
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
