<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
<script src="{$.const.TEMPLATE_URL}plugins/chartjs/Chart.min.js"></script>
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
	var box1 = BSHelper.Box({ type:"info" });
	col.push('<div class="chart"><canvas id="lineChart" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	form1.append(subRow(row));
	box1.find('.box-body').append(form1);
	$(".content").append(box1);
	
	{* Initialization *}
	var areaChartData = {
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [
			{
				label: "Electronics",
				fillColor: "rgba(210, 214, 222, 1)",
				strokeColor: "rgba(210, 214, 222, 1)",
				pointColor: "rgba(210, 214, 222, 1)",
				pointStrokeColor: "#c1c7d1",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [65, 59, 80, 81, 56, 55, 40]
			}
		]
	};

	var areaChartOptions = {
		{* //Boolean - If we should show the scale at all *}
		showScale: true,
		{* //Boolean - Whether grid lines are shown across the chart *}
		scaleShowGridLines: false,
		{* //String - Colour of the grid lines *}
		scaleGridLineColor: "rgba(0,0,0,.05)",
		{* //Number - Width of the grid lines *}
		scaleGridLineWidth: 1,
		{* //Boolean - Whether to show horizontal lines (except X axis) *}
		scaleShowHorizontalLines: true,
		{* //Boolean - Whether to show vertical lines (except Y axis) *}
		scaleShowVerticalLines: true,
		{* //Boolean - Whether the line is curved between points *}
		bezierCurve: true,
		{* //Number - Tension of the bezier curve between points *}
		bezierCurveTension: 0.3,
		{* //Boolean - Whether to show a dot for each point *}
		pointDot: false,
		{* //Number - Radius of each point dot in pixels *}
		pointDotRadius: 4,
		{* //Number - Pixel width of point dot stroke *}
		pointDotStrokeWidth: 1,
		{* //Number - amount extra to add to the radius to cater for hit detection outside the drawn point *}
		pointHitDetectionRadius: 20,
		{* //Boolean - Whether to show a stroke for datasets *}
		datasetStroke: true,
		{* //Number - Pixel width of dataset stroke *}
		datasetStrokeWidth: 2,
		{* //Boolean - Whether to fill the dataset with a color *}
		datasetFill: true,
		{* //String - A legend template *}
		{* legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>", *}
		{* //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container *}
		maintainAspectRatio: true,
		{* //Boolean - whether to make the chart responsive to window resizing *}
		responsive: true
	};

	var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
	var lineChart = new Chart(lineChartCanvas);
	var lineChartOptions = areaChartOptions;
	lineChartOptions.datasetFill = false;
	lineChart.Line(areaChartData, lineChartOptions);
</script>
