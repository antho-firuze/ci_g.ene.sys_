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

	var boxFilter = BSHelper.Box();
	col.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	boxFilter.find('.box-body').append(subRow(subCol(6, col)));
	$(".content").append(boxFilter);	

	
	col = [], row = [];
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"step", }));
	form1.append(subRow(subCol(6, col)));
	$(".content").append(form1);	

	col = [], row = [];
	box1.find('.box-header').append($('<div class="box-tools pull-right" />').append(BSHelper.GroupButton( [{ id: "btn1", title: "Hourly", text: "H" }, { id: "btn2", title: "Daily", text: "D", active: true }, { id: "btn3", title: "Weekly", text: "W" }, { id: "btn4", title: "Monthly", text: "M" }, ] )) );
	{* col.push($('<div class="box-tools" />').append(BSHelper.GroupButton(  *}
		{* [ *}
			{* { id: "btn1", title: "Hourly", text: "Hourly" },  *}
			{* { id: "btn2", title: "Daily", text: "Daily", active: true },  *}
			{* { id: "btn3", title: "Weekly", text: "Weekly" },  *}
			{* { id: "btn4", title: "Monthly", text: "Monthly" },  *}
		{* ]  *}
	{* ))); *}
	col.push('<div class="chart"><canvas id="lineChart" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	col.push('<div class="description-block border-right"><span></div>');
	row.push(subCol(6, col)); col = [];
	box1.find('.box-body').append(subRow(row));
	$(".content").append(box1);
	
	col = [], row = [];
	var boxHost = BSHelper.Box({ type:"info", header: true, title: "Domain", icon: "" });
	col.push('<div class="chart"><canvas id="host" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	boxHost.find('.box-body').append(subRow(row));
	
	col = [], row = [];
	var boxPlatform = BSHelper.Box({ type:"info", header: true, title: "Platform", icon: "" });
	col.push('<div class="chart"><canvas id="platform" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	boxPlatform.find('.box-body').append(subRow(row));
	
	col = [], row = [];
	var boxBrowser = BSHelper.Box({ type:"info", header: true, title: "Browser Usage", icon: "" });
	col.push('<div class="chart"><canvas id="browser" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	boxBrowser.find('.box-body').append(subRow(row));
	
	col = [], row = [];
	var boxScreenRes = BSHelper.Box({ type:"info", header: true, title: "Screen Resolution", icon: "" });
	col.push('<div class="chart"><canvas id="screen_res" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	boxScreenRes.find('.box-body').append(subRow(row));
	
	col.push(subCol(3, boxHost));
	col.push(subCol(3, boxPlatform));
	col.push(subCol(3, boxBrowser));
	col.push(subCol(3, boxScreenRes));
	$(".content").append(subRow(col));
	
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
				
				update_chart();
			}
	);
	
	$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	$("#fdate").val(start.format('YYYY-MM-DD'));
	$("#tdate").val(end.format('YYYY-MM-DD'));
	$("#step").val('D');
	
	var optHits = {
		spanGaps: true,
		responsive: true,
		title:{
				display: false,
				text: 'Server Hit Access'
		},
		legend: {
        display: false
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
	var dataHits = {
		labels: ["1", "2", "3", "4", "5", "6", "7"],
		datasets: [
			{
				label: 'Hits',
				borderColor: 'rgba(210, 180, 222, 1)',
				data: [0, 0, 0, 0, 0, 0, 0]
			}
		]
	};
	
	
	var optHost = {
		responsive: true,
		legend: {
				position: 'top',
		},
		title: {
				display: false,
				text: 'Chart.js Doughnut Chart'
		},
		animation: {
				animateScale: true,
				animateRotate: true
		}
	};
	var dataHost = {
		labels: ["Red", "Orange", "Yellow", "Green", "Blue"],
		datasets: [{
				label: 'Dataset 1',
				data: [10, 20, 30, 40, 50],
				backgroundColor: [
						'rgb(255, 99, 132)',
						'rgb(255, 159, 64)',
						'rgb(255, 205, 86)',
						'rgb(75, 192, 192)',
						'rgb(54, 162, 235)',
				],
		}],
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
	
	var hitsChart = new Chart("lineChart", { type: "line",	data: dataHits, options: optHits });
	{* var hostChart = new Chart("host", { type: "doughnut",	data: dataHost, options: optHost }); *}
	{* var hostPlatform = new Chart("platform", { type: "pie",	data: dataHost, options: optHost }); *}
	
	function update_chart(){
		$.getJSON($url_module, form1.serializeOBJ(), function(result){ 
			$.each(result.host, function(k, v){ console.log(k+' - '+v); });
			hitsChart.data = result.dataHits;
			hitsChart.update();
			var hostChart = new Chart("host", { type: "pie",	data: result.dataHost, options: optHost });
			var hostPlatform = new Chart("platform", { type: "pie",	data: result.dataPlatform, options: optHost });
			var hostBrowser = new Chart("browser", { type: "pie",	data: result.dataBrowser, options: optHost });
			var hostScreenRes = new Chart("screen_res", { type: "pie",	data: result.dataScreenRes, options: optHost });
			{* hostChart.data = result.dataHost; *}
			{* hostChart.update(); *}
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
	
	setTimeout(function(){
		update_chart();
	}, 1000);
	
</script>
