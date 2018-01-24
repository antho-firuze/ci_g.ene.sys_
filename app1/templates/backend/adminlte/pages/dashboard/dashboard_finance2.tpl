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
	var boxInfo0 = BSHelper.Box({ type:"info", header: true, title: "Cash Received Plan (Customer) vs Actual", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo0.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo0));
	{* Line Chart 2*}
	col = [], row = [];
	var boxInfo02 = BSHelper.Box({ type:"info", header: true, title: "Cash Received Plan (Other) vs Actual", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart2" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo02.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo02));
	{* Line Chart 3*}
	col = [], row = [];
	var boxInfo03 = BSHelper.Box({ type:"info", header: true, title: "Cash Payment Plan (Vendor) vs Actual", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart3" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo03.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo03));
	{* Line Chart 4*}
	col = [], row = [];
	var boxInfo04 = BSHelper.Box({ type:"info", header: true, title: "Cash Payment Plan (Other) vs Actual", icon: "" });
	col.push('<div class="chart"><canvas id="lineChart4" style="height:200px" /></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo04.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo04));
	{* Info Box *}
	col = [], row = [];
	var boxInfo11 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo11));
	col = [], row = [];
	var boxInfo12 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo12));
	col = [], row = [];
	var boxInfo13 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo13));
	col = [], row = [];
	var boxInfo14 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo14));
	{* Info Box *}
	col = [], row = [];
	var boxInfo21 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo21));
	col = [], row = [];
	var boxInfo22 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo22));
	col = [], row = [];
	var boxInfo23 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo23));
	col = [], row = [];
	var boxInfo24 = BSHelper.Box({ type:"info", });
	boxes.push(subCol(3, boxInfo24));
	{* col = [], row = []; *}
	{* var boxInfo2 = BSHelper.Box({ type:"info", }); *}
	{* boxes.push(subCol(4, boxInfo2)); *}
	{* col = [], row = []; *}
	{* var boxInfo3 = BSHelper.Box({ type:"info", }); *}
	{* col.push('<div class="canvas-holder"><canvas id="pieChart" /></div>'); *}
	{* row.push(subCol(12, col)); col = []; *}
	{* boxInfo3.find('.box-body').append(subRow(row)); *}
	{* boxes.push(subCol(5, boxInfo3)); *}
	$(".content").append(subRow(boxes));
	
	{* Initialization *}
	{* var format_money = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") }; *}
	var format_money = function(money){ return accounting.formatMoney(money, '', 0, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var format_percent = function(value){ return accounting.formatMoney(value, { symbol: "%", precision: 1, format: "%v%s" }) };
	var start = moment().startOf('month');
	var end = moment().endOf('month');
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
					'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
					'This Year': [moment().startOf('year'), moment().endOf('year')],
					'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
				},
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month')
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
	
	{* var optPieChart1 = { *}
		{* responsive: true, *}
		{* legend: { display: false }, *}
 	{* }; *}
	{* var pieChart = new Chart("pieChart", { type: "pie",	data: {}, options: optPieChart1 }); *}
	
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
			
			info_box_by_document();
			info_box_by_amount();
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
	
	{* Ditaruh diatas biar bisa masuk ke variable window *}
	var datas1 = []; {* invoice customer *}
	var datas2 = []; {* invoice inflow *}
	var datas3 = []; {* invoice vendor *}
	var datas4 = []; {* invoice outflow *}
	function info_box_by_document(){
		datas1 = [];
		datas2 = [];
		datas3 = [];
		datas4 = [];
		var grp = ["","Bank Received Customer (qty)","Bank Received Other (qty)","Bank Payment Vendor (qty)","Bank Payment Outflow (qty)"];
		var title = ["Plan","Act (Ontime)","Act (Early)","Act (Late)","Not Yet"];
		var field = ["","total_release","total_release_early","total_release_late","total_unrelease"];
		var field_percent = ["","total_release_percent","total_release_early_percent","total_release_late_percent","total_unrelease_percent"];

		datas1.push({ title: title[0], link: "#", value: result.data.total_by_document['total_projection1'] });
		datas2.push({ title: title[0], link: "#", value: result.data.total_by_document['total_projection2'] });
		datas3.push({ title: title[0], link: "#", value: result.data.total_by_document['total_projection3'] });
		datas4.push({ title: title[0], link: "#", value: result.data.total_by_document['total_projection4'] });
		for (var i = 1; i < title.length; i++){
			for (var j = 1; j < field.length; j++){
				var v = result.data.total_by_document[field[j]+i];
				var vp = result.data.total_by_document[field_percent[j]+i];
				var fmt = v + ' ('+ format_percent(vp) +')';
				{* var fmt = '<div><div><span>'+v+'</span></div><div style=""><span>'+format_percent(vp)+'</span></div></div>'; *}
				window['datas'+i].push({ title: title[j], link: "#", value: fmt });
			}
		}
		
		{* Auto *}
		for (var i = 1; i < grp.length; i++){
			window['boxInfo1'+i].find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: grp[i], dataList: window['datas'+i] }))));
			window['datas'+i] = [];
		}
		
		{* Manual *}
		{* boxInfo11.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Customer", dataList: datas1 })))); *}
		{* boxInfo12.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Inflow", dataList: datas2 })))); *}
		{* boxInfo13.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Vendor", dataList: datas3 })))); *}
		{* boxInfo14.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Outflow", dataList: datas4 })))); *}
	}
	
	function info_box_by_amount(){
		datas1 = [];
		datas2 = [];
		datas3 = [];
		datas4 = [];
		var grp = ["","Bank Received Customer (amt)","Bank Received Other (amt)","Bank Payment Vendor (amt)","Bank Payment Other (amt)"];
		var title = ["Plan","Act (Ontime)","Act (Early)","Act (Late)","Not Yet"];
		var field = ["","total_release","total_release_early","total_release_late","total_unrelease"];
		var field_percent = ["","total_release_percent","total_release_early_percent","total_release_late_percent","total_unrelease_percent"];

		datas1.push({ title: title[0], link: "#", value: format_money(result.data.total_by_amount['total_projection1']) });
		datas2.push({ title: title[0], link: "#", value: format_money(result.data.total_by_amount['total_projection2']) });
		datas3.push({ title: title[0], link: "#", value: format_money(result.data.total_by_amount['total_projection3']) });
		datas4.push({ title: title[0], link: "#", value: format_money(result.data.total_by_amount['total_projection4']) });
		for (var i = 1; i < title.length; i++){
			for (var j = 1; j < field.length; j++){
				var v = result.data.total_by_amount[field[j]+i];
				var vp = result.data.total_by_amount[field_percent[j]+i];
				var fmt = format_money(v) + ' ('+ format_percent(vp) +')';
				window['datas'+i].push({ title: title[j], link: "#", value: fmt });
			}
		}
		
		{* Auto *}
		for (var i = 1; i < grp.length; i++){
			window['boxInfo2'+i].find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: grp[i], dataList: window['datas'+i] }))));
			window['datas'+i] = [];
		}
		
		{* Manual *}
		{* boxInfo21.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Customer", dataList: datas1 })))); *}
		{* boxInfo22.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Inflow", dataList: datas2 })))); *}
		{* boxInfo23.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Vendor", dataList: datas3 })))); *}
		{* boxInfo24.find('.box-body').empty().append(subRow(subCol(12, BSHelper.Pills({ title: "Invoice Outflow", dataList: datas4 })))); *}
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
