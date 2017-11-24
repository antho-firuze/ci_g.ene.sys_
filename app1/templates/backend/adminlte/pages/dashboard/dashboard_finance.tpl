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
	
	{* col = [], row = []; *}
	{* col.push(BSHelper.WidgetBox3({ idname:"box3_total_so", title:"Total Receipt by SO", color:"bg-blue", value:0, icon:"ion ion-pie-graph", link:"", tooltip:"" })); *}
	{* col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_amount", title:"Total SO (Rp)", color:"bg-blue", value:0, icon:"ion ion-cash", link:"", tooltip:"" })); *}
	{* col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_late", title:"Total (Late)", color:"bg-red", value:0, icon:"ion ion-clock", link:"", tooltip:"" })); *}
	{* col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_penalty", title:"Total Penalty (Rp)", color:"bg-red", value:0, icon:"ion ion-alert-circled", link:"", tooltip:"" })); *}
	{* $(".content").append(subRow(col));	 *}
	{* $('div.small-box div.val').textfill({	maxFontPixels: 38 }); *}
	{* $('div.small-box div.title').textfill({	maxFontPixels: 15 }); *}
	
	{* Line Chart *}
	col = [], row = [], boxes = [];
	var boxInfo0 = BSHelper.Box({ type:"info", header: true, title: "Invoice Customer vs Release Invoice", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo0.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo0));
	col = [], row = [];
	var boxInfo1 = BSHelper.Box({ type:"info", });
	{* col.push(BSHelper.Stacked({ title: "Sales Order Late", dataList:[{ title: "All Status", link: "#", active: true },{ title: "Complete", link: "#" },{ title: "Incomplete", link: "#" }] })); *}
	{* boxInfo1.find('.box-body').append(subRow(subCol(12, col))); *}
	boxes.push(subCol(3, boxInfo1));
	{* Line Chart 2*}
	col = [], row = [];
	var boxInfo02 = BSHelper.Box({ type:"info", header: true, title: "Invoice Inflow vs Release Invoice", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart2" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo02.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo02));
	{* Line Chart 3*}
	col = [], row = [];
	var boxInfo03 = BSHelper.Box({ type:"info", header: true, title: "Invoice Vendor vs Release Invoice", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart3" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo03.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo03));
	{* Line Chart 4*}
	col = [], row = [];
	var boxInfo04 = BSHelper.Box({ type:"info", header: true, title: "Invoice Outflow vs Release Invoice", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart4" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo04.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo04));
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
	var lineChart2 = new Chart("lineChart2", { type: "line",	data: {}, options: optLineChart1 });
	var lineChart3 = new Chart("lineChart3", { type: "line",	data: {}, options: optLineChart1 });
	var lineChart4 = new Chart("lineChart4", { type: "line",	data: {}, options: optLineChart1 });
	
	var optPieChart1 = {
		responsive: true,
		legend: { display: false },
 	};
	var pieChart = new Chart("pieChart", { type: "pie",	data: {}, options: optPieChart1 });
	
	$("ul.nav-stacked li").on("click", function(){
		$(this).parent().find("li").removeClass("active");
		$(this).addClass("active");

		var opt = { "all_status":0, "complete":1, "incomplete":2 };
		var txt = $(this).text().toLowerCase().replace(/\s/g, "_");
		list_table(opt[txt]);
	});
	
	var result;
	function update_datas(){
		{* Validation *}
		var fdate = moment($("#fdate").val(), 'YYYY-MM-DD');
		var tdate =	moment($("#tdate").val(), 'YYYY-MM-DD');
		
		$.getJSON($url_module, form1.serializeOBJ(), function(response){ 
			result = response;
			
			{* small_boxes(); *}
			line_chart();
			{* list_table(0); *}
			
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
		col = []; 
		boxInfo1.find('.box-body').empty();

		var datas = [];
		$.each(result.data.total_by_document], function(i, v){
			datas.push({ title: v.name, link: "#", value: v.count +' ('+ format_percent(v.percent) +')' });
		});
		col.push(BSHelper.List({ title: "Reasons", title_right: "Value (%)", dataList: datas }));
		boxInfo1.find('.box-body').append(subRow(subCol(12, col)));
	}
	
	function line_chart(){
		lineChart.data = result.data.linechart;
		lineChart.update();
		lineChart2.data = result.data.linechart2;
		lineChart2.update();
		lineChart3.data = result.data.linechart3;
		lineChart3.update();
		lineChart4.data = result.data.linechart4;
		lineChart4.update();
	}
	
	function list_table(opt){
		var opt_data_list = ['so_late_all','so_late_complete','so_late_incomplete'];
		var opt_data_chart = ['so_late_all_chart','so_late_complete_chart','so_late_incomplete_chart',];
		col = []; 
		boxInfo2.find('.box-body').empty();

		var datas = [];
		$.each(result.data[opt_data_list[opt]], function(i, v){
			datas.push({ title: v.name, link: "#", value: v.count +' ('+ format_percent(v.percent) +')' });
		});
		col.push(BSHelper.List({ title: "Reasons", title_right: "Value (%)", dataList: datas }));
		boxInfo2.find('.box-body').append(subRow(subCol(12, col)));
		
		pieChart.data = result.data[opt_data_chart[opt]];
		pieChart.update();
	}
	
	update_datas();
	
</script>
