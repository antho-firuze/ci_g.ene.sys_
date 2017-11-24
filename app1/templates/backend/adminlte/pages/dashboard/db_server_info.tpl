<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.css">
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/chartjs/Chart.bundle.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/textfill/jquery.textfill.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Start :: Init for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));
	{* End :: Init for Title, Breadcrumb *}
	
	{* For design form interface *}
	col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"step", }));
	form1.append(subRow(subCol(6, col)));
	$(".content").append(form1);	

	{* Filter *}
	col = [], row = [];
	var boxFilter = BSHelper.Box();
	col.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	boxFilter.find('.box-body').append(subRow(subCol(6, col)));
	$(".content").append(boxFilter);	

	{* Main Info () *}
	{* var col = [], row = []; *}
	{* var box1 = BSHelper.Box({ type:"info", header: true, title: "Hit Access" }); *}
	{* box1.find('.box-header').append($('<div class="box-tools pull-right" />').append(BSHelper.GroupButton( { cls:"btn-step", list:[{ id: "btn1", title: "Hourly", text: "H" }, { id: "btn2", title: "Daily", text: "D", active: true }, { id: "btn3", title: "Weekly", text: "W" }, { id: "btn4", title: "Monthly", text: "M" }, ]} )) ); *}
	{* col.push($('<div class="box-tools" />').append(BSHelper.GroupButton(  *}
		{* [ *}
			{* { id: "btn1", title: "Hourly", text: "Hourly" },  *}
			{* { id: "btn2", title: "Daily", text: "Daily", active: true },  *}
			{* { id: "btn3", title: "Weekly", text: "Weekly" },  *}
			{* { id: "btn4", title: "Monthly", text: "Monthly" },  *}
		{* ]  *}
	{* ))); *}
	{* col.push('<div class="chart"><canvas id="lineChart" style="height:250px"></canvas></div>'); *}
	{* row.push(subCol(12, col)); col = []; *}
	{* col.push('<div class="description-block border-right"><span></div>'); *}
	{* row.push(subCol(6, col)); col = []; *}
	{* box1.find('.box-body').append(subRow(row)); *}
	{* $(".content").append(box1); *}
	
	
	{* Server Hits *}
	{* col = [], row = []; *}
	{* var boxHost = BSHelper.Box({ type:"info", header: true, title: "Domain", icon: "" }); *}
	{* col.push('<div class="chart"><canvas id="host" style="height:250px"></canvas></div>'); *}
	{* row.push(subCol(12, col)); col = []; *}
	{* boxHost.find('.box-body').append(subRow(row)); *}
	
	{* col = [], row = []; *}
	{* var boxPlatform = BSHelper.Box({ type:"info", header: true, title: "Platform", icon: "" }); *}
	{* col.push('<div class="chart"><canvas id="platform" style="height:250px"></canvas></div>'); *}
	{* row.push(subCol(12, col)); col = []; *}
	{* boxPlatform.find('.box-body').append(subRow(row)); *}
	
	{* col = [], row = []; *}
	{* var boxBrowser = BSHelper.Box({ type:"info", header: true, title: "Browser Usage", icon: "" }); *}
	{* col.push('<div class="chart"><canvas id="browser" style="height:250px"></canvas></div>'); *}
	{* row.push(subCol(12, col)); col = []; *}
	{* boxBrowser.find('.box-body').append(subRow(row)); *}
	
	{* col = [], row = []; *}
	{* var boxScreenRes = BSHelper.Box({ type:"info", header: true, title: "Screen Resolution", icon: "" }); *}
	{* col.push('<div class="chart"><canvas id="screen_res" style="height:250px"></canvas></div>'); *}
	{* row.push(subCol(12, col)); col = []; *}
	{* boxScreenRes.find('.box-body').append(subRow(row)); *}
	
	{* col.push(subCol(3, boxHost)); *}
	{* col.push(subCol(3, boxPlatform)); *}
	{* col.push(subCol(3, boxBrowser)); *}
	{* col.push(subCol(3, boxScreenRes)); *}
	{* $(".content").append(subRow(col)); *}
	
	{* col.push('BoxInfo1'); *}
	{* row.push(subCol(12, col)); col = []; *}
	{* boxInfo4.find('.box-body').append(subRow(row)); *}
	
	
	
	col = [], row = [], boxes = [];
	var boxInfo0 = BSHelper.Box({ type:"info", header: true, title: "Hit Access", icon: "" });
	{* boxInfo0.find('.box-header').append($('<div class="box-tools pull-right" />').append(BSHelper.GroupButton( { cls:"btn-step", list:[{ id: "btn1", title: "Hourly", text: "H" }, { id: "btn2", title: "Daily", text: "D", active: true }, { id: "btn3", title: "Weekly", text: "W" }, { id: "btn4", title: "Monthly", text: "M" }, ]} )) ); *}
	col.push('<div class="chart"><canvas id="lineChart" style="height:180px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	col.push(BSHelper.Pills({ dataList:[{ title: "Total", idname: "total", value: 0 }] }));
	row.push(subCol(3, col)); col = [];
	col.push(BSHelper.Pills({ dataList:[{ title: "Avg/Hour", idname: "avg_hour", value: 0 }] }));
	row.push(subCol(2, col)); col = [];
	col.push(BSHelper.Pills({ dataList:[{ title: "Avg/Day", idname: "avg_day", value: 0 }] }));
	row.push(subCol(2, col)); col = [];
	col.push(BSHelper.Pills({ dataList:[{ title: "Avg/Week", idname: "avg_week", value: 0 }] }));
	row.push(subCol(2, col)); col = [];
	col.push(BSHelper.Pills({ dataList:[{ title: "Avg/Month", idname: "avg_month", value: 0 }] }));
	row.push(subCol(3, col)); col = [];

	{* boxInfo0.find('.box-body').append('<div class="chart"><canvas id="lineChart" style="height:180px"></canvas></div>'); *}
	boxInfo0.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo0));
	
	{* Sub Info (4) *}
	{* Hosting : Domain, Request Method *}
	{* Demographics : Country/Territory, City *}
	{* System : Browser, Operating System, Service Provider, Screen Resolution *}
	{* Mobile : Browser, Operating System, Service Provider, Screen Resolution *}
	col = [], row = [];
	var boxInfo1 = BSHelper.Box({ type:"info", });
	col.push(BSHelper.Stacked({ title: "Hosting", dataList:[{ title: "Domain", link: "#", active: true },{ title: "Request Method", link: "#" }] }));
	col.push(BSHelper.Stacked({ title: "Demographics", dataList:[{ title: "Country / Territory", link: "#" },{ title: "City", link: "#" }] }));
	col.push(BSHelper.Stacked({ title: "System", dataList:[{ title: "Browser", link: "#" },{ title: "Operating System", link: "#" },{ title: "Service Provider", link: "#" },{ title: "Screen Resolution", link: "#" }] }));
	col.push(BSHelper.Stacked({ title: "Mobile", dataList:[{ title: "Browser", link: "#" },{ title: "Operating System", link: "#" },{ title: "Service Provider", link: "#" },{ title: "Screen Resolution", link: "#" }] }));
	boxInfo1.find('.box-body').append(subRow(subCol(12, col)));
	boxes.push(subCol(3, boxInfo1));
	{* Sub Info (5) *}
	{* Penjelasan dari (sub (4)) *}
	col = [], row = [];
	var boxInfo2 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(4, boxInfo2));
	{* Sub Info (3) *}
	{* Pendukung dari (sub (5)) *}
	col = [], row = [];
	var boxInfo3 = BSHelper.Box({ type:"info", });
	col.push('<div class="canvas-holder"><canvas id="pieChart" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo3.find('.box-body').append(subRow(row));
	boxes.push(subCol(5, boxInfo3));
	$(".content").append(subRow(boxes));
	
	{* Initialization *}
	var format_money = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var format_percent = function(value){ return accounting.formatMoney(value, { symbol: "%", format: "%v%s" }) };
	var format_average = function(value){ return accounting.formatMoney(value, '', 2, '', '.') };
	var start = moment().subtract(6, 'days');
	var end = moment();
	{* //Date range as a button *}
	$('#btn_cal').daterangepicker(
			{
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				startDate: moment().subtract(6, 'days'),
				endDate: moment()
			},
			function (start, end) {
				{* console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('MMMM D, YYYY')); *}
				$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$("#fdate").val(start.format('YYYY-MM-DD'));
				$("#tdate").val(end.format('YYYY-MM-DD'));
				
				update_datas();
			}
	);
	
	$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	$("#fdate").val(start.format('YYYY-MM-DD'));
	$("#tdate").val(end.format('YYYY-MM-DD'));
	$("#step").val('D');
	
	var optLineChart1 = {
		spanGaps: true,
		responsive: true,
		title:{	display: false,	text: 'Server Hit Access'	},
		legend: { display: false },
		tooltips: {	mode: 'index', intersect: false, },
		hover: { mode: 'nearest',	intersect: true	},
		elements: {	line: {	tension: 0.000001	} },
		scales: {
				xAxes: [{
						display: true,
						scaleLabel: {
								display: false,
								labelString: 'Month'
						}
				}],
				yAxes: [{
						display: true,
						scaleLabel: {
								display: false,
								labelString: 'Value'
						}
				}]
		},
 	};
	var lineChart = new Chart("lineChart", { type: "line",	data: {}, options: optLineChart1 });

	var optPieChart1 = {
		responsive: true,
		legend: { display: false },
 	};
	var pieChart = new Chart("pieChart", { type: "pie",	data: {}, options: optPieChart1 });
	
	$("ul.nav-stacked-link li").on("click", function(){
		$(this).parent().parent().parent().find("li").removeClass("active");
		$(this).addClass("active");

		var opt = [ "hosting_domain", 
								"hosting_request_method", 
								"demographics_country_/_territory", 
								"demographics_city", 
								"system_browser", 
								"system_operating_system", 
								"system_service_provider", 
								"system_screen_resolution", 
								"mobile_browser", 
								"mobile_operating_system", 
								"mobile_service_provider", 
								"mobile_screen_resolution", 
							];
		var parent = $(this).parent().find("li.header").text().toLowerCase().replace(/\s/g, "_");
		var txt = $(this).text().toLowerCase().replace(/\s/g, "_");
		list_table($.inArray( parent+'_'+txt, opt));
	});
	
	var result;
	function update_datas(){
		{* Validation *}
		var fdate = moment($("#fdate").val(), 'YYYY-MM-DD');
		var tdate =	moment($("#tdate").val(), 'YYYY-MM-DD');
		{* var durra = moment.duration(tdate.diff(fdate)); *}
		
		{* if (durra.asDays() > 1) {
			$("#btn1").attr("disabled", true);
			$(".btn-step>button").removeClass("active");
			$("#btn2").addClass("active");
			$("#step").val('D');
		} else {
			$("#btn1").attr("disabled", false);
		}
		if (durra.asDays() > 30) {
			$("#btn2").attr("disabled", true);
			$(".btn-step>button").removeClass("active");
			$("#btn3").addClass("active");
			$("#step").val('W');
		} else {
			$("#btn2").attr("disabled", false);
		}
		if (durra.asDays() > 180) {
			$("#btn3").attr("disabled", true);
			$(".btn-step>button").removeClass("active");
			$("#btn4").addClass("active");
			$("#step").val('M');
		} else {
			$("#btn3").attr("disabled", false);
		} *}

		$.getJSON($url_module, form1.serializeOBJ(), function(response){ 
			result = response;
			
			line_chart();
			small_boxes();
			list_table(0);
			
		}).fail(function(data) {
			{* console.log(data); *}
			if (data.status >= 500){
				var message = data.statusText;
			} else {
				var error = JSON.parse(data.responseText);
				var message = error.message;
			}
			BootstrapDialog.show({ message:message, closable: false, type:'modal-danger', title:'Notification', 
				buttons: [{ label: 'OK', hotkey: 13, 
					action: function(dialogRef) {
						dialogRef.close();
					} 
				}],
			});
		});
	}
	
	function small_boxes(){
		$("#total a span").text(result.data.total);
		$("#avg_hour a span").text(format_average(result.data.avg_hour));
		$("#avg_day a span").text(format_average(result.data.avg_day));
		$("#avg_week a span").text(format_average(result.data.avg_week));
		$("#avg_month a span").text(format_average(result.data.avg_month));
	}
	
	function line_chart(){
		lineChart.data = result.dataHits;
		lineChart.update();
	}
	
	function list_table(opt){
		var opt_data_title = ['Domain','Request Method','Country/Territory','City','System Browser','Operating System','Service Provider','Screen Resolution','Mobile Browser','Mobile OS','Mobile ISP','Mobile Resolution',];
		var opt_data_list = ['domain','method','country','city','browser','os','isp','screen_res','m_browser','m_os','m_isp','m_screen_res',];
		var opt_data_chart = ['domain_chart','method_chart','country_chart','city_chart','browser_chart','os_chart','isp_chart','screen_res_chart','m_browser_chart','m_os_chart','m_isp_chart','m_screen_res_chart',];
		col = []; 
		boxInfo2.find('.box-body').empty();

		var datas = [];
		$.each(result.data[opt_data_list[opt]], function(i, v){
			datas.push({ title: v.name, link: "#", value: v.count +' ('+ format_percent(v.percent) +')' });
		});
		col.push(BSHelper.List({ title: opt_data_title[opt], title_right: "Value (%)", dataList: datas }));
		boxInfo2.find('.box-body').append(subRow(subCol(12, col)));
		
		pieChart.data = result.data[opt_data_chart[opt]];
		pieChart.update();
	}
	
	update_datas();
	
</script>
