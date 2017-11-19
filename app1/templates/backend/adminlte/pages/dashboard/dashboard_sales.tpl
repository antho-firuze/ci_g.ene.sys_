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
	
	col = [], row = [];
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so", title:"Total SO", color:"bg-blue", value:0, icon:"ion ion-pie-graph", link:"", tooltip:"" }));
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_amount", title:"Total SO (Rp)", color:"bg-blue", value:0, icon:"ion ion-cash", link:"", tooltip:"" }));
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_late", title:"Total (Late)", color:"bg-red", value:0, icon:"ion ion-clock", link:"", tooltip:"" }));
	col.push(BSHelper.WidgetBox3({ idname:"box3_total_so_penalty", title:"Total Penalty (Rp)", color:"bg-red", value:0, icon:"ion ion-alert-circled", link:"", tooltip:"" }));
	{* row.push(subCol(3, col)); col = []; *}
	{* row.push(subCol(12, col)); col = []; *}
	$(".content").append(subRow(col));	
	$('div.small-box div.val').textfill({	maxFontPixels: 38 });
	$('div.small-box div.title').textfill({	maxFontPixels: 15 });
	
	{* Chart Sales Order *}
	col = [], row = [], boxes = [];
	var boxInfo0 = BSHelper.Box({ type:"info", header: true, title: "Sales Orders VS Late", icon: "" });
	{* boxInfo0.find('.box-header').append($('<div class="box-tools pull-right" />').append(BSHelper.GroupButton( { cls:"btn-step", list:[{ id: "btn1", title: "All", text: "All" }, { id: "btn2", title: "Complete", text: "Complete", active: true }, { id: "btn3", title: "Incomplete", text: "Incomplete" }, ]} )) ); *}
	col.push('<div class="chart"><canvas id="lineChart" style="height:200px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	boxInfo0.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo0));
	$(".content").append(subRow(boxes));
	
	{* Initialization *}
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
					'This Year': [moment().startOf('year'), moment().endOf('year')],
				},
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month')
			},
			function (start, end) {
				{* console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('MMMM D, YYYY')); *}
				$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$("#fdate").val(start.format('YYYY-MM-DD'));
				$("#tdate").val(end.format('YYYY-MM-DD'));
				
				update_chart();
			}
	);
	
	$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	$("#fdate").val(start.format('YYYY-MM-DD'));
	$("#tdate").val(end.format('YYYY-MM-DD'));
	{* $("#step").val('D'); *}
	
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
	
	function update_chart(){
		{* Validation *}
		var fdate = moment($("#fdate").val(), 'YYYY-MM-DD');
		var tdate =	moment($("#tdate").val(), 'YYYY-MM-DD');
		{* var durra = moment.duration(tdate.diff(fdate)); *}
		
		{* if (durra.asDays() > 1) { *}
			{* $("#btn1").attr("disabled", true); *}
			{* $(".btn-step>button").removeClass("active"); *}
			{* $("#btn2").addClass("active"); *}
			{* $("#step").val('D'); *}
		{* } else { *}
			{* $("#btn1").attr("disabled", false); *}
		{* } *}
		{* if (durra.asDays() > 30) { *}
			{* $("#btn2").attr("disabled", true); *}
			{* $(".btn-step>button").removeClass("active"); *}
			{* $("#btn3").addClass("active"); *}
			{* $("#step").val('W'); *}
		{* } else { *}
			{* $("#btn2").attr("disabled", false); *}
		{* } *}
		{* if (durra.asDays() > 180) { *}
			{* $("#btn3").attr("disabled", true); *}
			{* $(".btn-step>button").removeClass("active"); *}
			{* $("#btn4").addClass("active"); *}
			{* $("#step").val('M'); *}
		{* } else { *}
			{* $("#btn3").attr("disabled", false); *}
		{* } *}

		$.getJSON($url_module, form1.serializeOBJ(), function(result){ 
			lineChart.data = result.data;
			lineChart.update();
			
			$("#box3_total_so .val span").text(result.data.total_so);
			$("#box3_total_so_amount .val span").text(result.data.total_so_amount);
			$("#box3_total_so_late .val span").text(result.data.total_so_late);
			$("#box3_total_so_penalty .val span").text(result.data.total_so_penalty);
			
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
	
	update_chart();
	
</script>
