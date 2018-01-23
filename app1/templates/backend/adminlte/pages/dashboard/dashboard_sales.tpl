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
	form1.append(subRow(subCol(6, col)));
	$(".content").append(form1);	
	
	{* Filter *}
	col = [], row = [];
	var boxFilter = BSHelper.Box();
	col.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	boxFilter.find('.box-body').append(subRow(subCol(6, col)));
	$(".content").append(boxFilter);	
	
	col = [], row = [];
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so", title:"Total SO", color:"bg-blue", value:0, icon:"ion ion-pie-graph", link:"", tooltip:"" }));
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_amount", title:"Total SO (Rp)", color:"bg-blue", value:0, icon:"ion ion-cash", link:"", tooltip:"" }));
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_late", title:"Estimate Late Shipment", color:"bg-red", value:0, icon:"ion ion-clock", link:"", tooltip:"" }));
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_penalty", title:"Estimate Penalty (Rp)", color:"bg-red", value:0, icon:"ion ion-alert-circled", link:"", tooltip:"" }));
	{* row.push(subCol(3, col)); col = []; *}
	{* row.push(subCol(12, col)); col = []; *}
	$(".content").append(subRow(col));	
	$('div.small-box div.val').textfill({	maxFontPixels: 38 });
	$('div.small-box div.title').textfill({	maxFontPixels: 15 });
	
	{* Chart Sales Order *}
	col = [], row = [], boxes = [];
	var boxInfo0 = BSHelper.Box({ type:"info", header: true, title: "Sales Orders VS Estimate Late Shipment", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo0.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo0));
	col = [], row = [];
	var boxInfo1 = BSHelper.Box({ type:"info", });
	col.push(BSHelper.Stacked({ title: "Estimate Shipment", dataList:[{ title: "All", link: "#", active: true },{ title: "Estimate Late Shipment", link: "#" },{ title: "Estimate Ontime Shipment", link: "#" }] }));
	boxInfo1.find('.box-body').append(subRow(subCol(12, col)));
	boxes.push(subCol(3, boxInfo1));
	col = [], row = [];
	var boxInfo2 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(4, boxInfo2));
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
	var start = moment().startOf('year');
	var end = moment().endOf('year');
	{* //Date range as a button *}
	$('#btn_cal').daterangepicker(
			{
				ranges: {
					{* 'Today': [moment(), moment()], *}
					{* 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')], *}
					{* 'Last 7 Days': [moment().subtract(6, 'days'), moment()], *}
					{* 'Last 30 Days': [moment().subtract(29, 'days'), moment()], *}
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'This Year': [moment().startOf('year'), moment().endOf('year')],
				},
				startDate: moment().startOf('year'),
				endDate: moment().endOf('year')
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
	
	var optLineChart1 = {
		spanGaps: true,
		responsive: true,
		title:{	display: false,	text: 'Server Hit Access'	},
		legend: { display: true },
		tooltips: {	mode: 'index', intersect: false, },
		hover: { mode: 'nearest',	intersect: true	},
		elements: {	line: {	tension: 0.000001	} },
		scales: {
				xAxes: [{
						display: true,
						scaleLabel: {	display: false,	labelString: 'Month' }
				}],
				yAxes: [{
						display: true,
						scaleLabel: {	display: false, labelString: 'Value' }
				}]
		},
 	};
	var lineChart = new Chart("lineChart", { type: "line",	data: {}, options: optLineChart1 });
	
	var optPieChart1 = {
		responsive: true,
		legend: { display: false },
 	};
	var pieChart = new Chart("pieChart", { type: "pie",	data: {}, options: optPieChart1 });
	
	$("ul.nav-stacked li.item").on("click", function(){
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");

		list_table($(this).index()-1);
	});
	
	var result;
	function update_datas(){
		{* Validation *}
		var fdate = moment($("#fdate").val(), 'YYYY-MM-DD');
		var tdate =	moment($("#tdate").val(), 'YYYY-MM-DD');
		
		$.getJSON($url_module, form1.serializeOBJ(), function(response){ 
			result = response;
			
			small_boxes();
			line_chart();
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
		$("#box3_total_so .val span").text(result.data.total_so);
		$("#box3_total_so_amount .val span").text(result.data.total_so_amount);
		$("#box3_total_so_late .val span").text(result.data.total_so_late + ' ('+ format_percent(result.data.total_so_late_percent) +')');
		$("#box3_total_so_penalty .val span").text(result.data.total_so_penalty + ' ('+ format_percent(result.data.total_so_penalty_percent) +')');
	}
	
	function line_chart(){
		lineChart.data = result.data.linechart;
		lineChart.update();
	}
	
	function list_table(opt){
		var opt_data_list = ['shipment_all','estimate_late_shipment','estimate_ontime_shipment'];
		col = []; 
		boxInfo2.find('.box-body').empty();

		var datas = [];
		$.each(result.data[opt_data_list[opt]], function(i, v){
			datas.push({ title: v.name, link: "#", value: v.count +' ('+ format_percent(v.percent) +')' });
		});
		col.push(BSHelper.List({ title: "Description", title_right: "Value (%)", dataList: datas }));
		boxInfo2.find('.box-body').append(subRow(subCol(12, col)));
		
		pieChart.data = result.data[(opt_data_list[opt]+'_chart')];
		pieChart.update();
	}
	
	update_datas();
	
</script>
