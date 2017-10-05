<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.css">
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/summernote/summernote.css"> *}
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/datepicker/datepicker3.css"> *}
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/tag-it/css/jquery.tagit.css"> *}
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/tag-it/css/tagit.ui-zendesk.css"> *}
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/bootstrap-tagsinput/bootstrap-tagsinput.css"> *}
{* <link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/jvectormap/jquery-jvectormap-1.2.2.css"> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/jQueryUI/jquery-ui.min.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/summernote/summernote.min.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/datepicker/bootstrap-datepicker.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/tag-it/js/tag-it.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/shollu-autofill/js/shollu-autofill.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/textfill/jquery.textfill.min.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/moment/min/moment.min.js"></script> *}
{* <script src="{$.const.TEMPLATE_URL}plugins/chartjs/Chart.min.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/chartjs/Chart.bundle.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Start :: Init for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));
	{* End :: Init for Title, Breadcrumb *}
	
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var boxFilter = BSHelper.Box({ type:"info", });
	var box1 = BSHelper.Box({ type:"info", header: true, title: "Server Hit Access" });
	
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"step", }));
	form1.append(subRow(subCol(6, col)));
	$(".content").append(form1);	

	col = [], row = [];
	{* box1.find('.box-header').append($('<div class="box-tools pull-right" />').append(BSHelper.GroupButton( [{ id: "btn1", title: "Hourly", text: "H", active: true }, { id: "btn2", title: "Daily", text: "D" }, { id: "btn3", title: "Weekly", text: "W" }, { id: "btn4", title: "Monthly", text: "M" }, ] )) ); *}
	col.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	col.push($('<div class="box-tools" />').append(BSHelper.GroupButton( 
		[
			{ id: "btn1", title: "Hourly", text: "Hourly" }, 
			{ id: "btn2", title: "Daily", text: "Daily", active: true }, 
			{ id: "btn3", title: "Weekly", text: "Weekly" }, 
			{ id: "btn4", title: "Monthly", text: "Monthly" }, 
		] 
	)));
	col.push('<div class="chart"><canvas id="ServerHitChart" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	col.push('<div class="description-block border-right"><span></div>');
	row.push(subCol(6, col)); col = [];
	box1.find('.box-body').append(subRow(row));
	$(".content").append(box1);
	
	{* Initialization *}
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
			}
	);
	
	$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	$("#fdate").val(start.format('YYYY-MM-DD'));
	$("#tdate").val(end.format('YYYY-MM-DD'));
	
	var optServerHit = {
		spanGaps: true,
		responsive: true,
		title:{
				display: false,
				text: 'Server Hit Access'
		},
		tooltips: {
				mode: 'index',
				intersect: false,
		},
		hover: {
				mode: 'nearest',
				intersect: true
		},
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
		elements: {
			line: {
				tension: 0.000001
			}
		},
 	};
	
	var areaChartData = {
		labels: ["1", "2", "3", "4", "5", "6", "7"],
		datasets: [
			{
				label: 'Hits',
				borderColor: 'rgba(210, 180, 222, 1)',
				data: [0, 0, 0, 0, 0, 0, 0]
			}
		]
	};
	
	$(".btn-group").on("click", function(e){
		{* console.log($(e.target).attr('id')); *}
		switch ($(e.target).attr('id')) {
			case 'btn1': $("#step").val('H');	break;
			case 'btn2': $("#step").val('D');	break;
			case 'btn3': $("#step").val('W');	break;
			case 'btn4': $("#step").val('M');	break;
		}
		update_chart();
	});
	
	var chart3 = new Chart("ServerHitChart", { type: "line",	data: areaChartData, options: optServerHit });
	
	function update_chart(){
		{* console.log(chart3.data.datasets); *}
		{* console.log(form1.serializeOBJ()); *}
		{* console.log(form1.serializeJSON()); *}
		{* console.log($url_module); *}
		{* return false; *}
		$.getJSON($url_module, form1.serializeOBJ(), function(result){ 
			{* console.log(result.host["apps.hdgroup.id"]); *}
			$.each(result.host, function(k, v){ console.log(k+' - '+v); });
			chart3.data = result.chartjs;
			chart3.update();
			{* if (!isempty_obj(result.data)){ *}
				{* console.log(result.data); *}
			{* } *}
		}).fail(function(data) {
			console.log(data);
			if (data.status==500){
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
	
</script>
