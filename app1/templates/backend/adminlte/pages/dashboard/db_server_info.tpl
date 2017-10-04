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
{* <script src="{$.const.TEMPLATE_URL}plugins/chartjs/Chart.min.js"></script> *}
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
	
	col.push('<div class="chart"><canvas id="ServerHitChart" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	boxFilter.find('.box-body').append(subRow(row));
	$(".content").append(boxFilter);
	
	col = [], row = [];
	box1.find('.box-header').append($('<div class="box-tools pull-right" />').append(BSHelper.GroupButton( [{ id: "btn1", title: "Hourly", text: "H", active: true }, { id: "btn2", title: "Daily", text: "D" }, { id: "btn3", title: "Weekly", text: "W" }, { id: "btn4", title: "Monthly", text: "M" }, ] )) );
	col.push('<div class="chart"><canvas id="ServerHitChart" style="height:250px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	box1.find('.box-body').append(subRow(row));
	$(".content").append(box1);
	
	{* Initialization *}
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
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [
			{
				label: 'Hits',
				borderColor: "rgba(210, 180, 222, 1)",
				data: [0, 0, 0, 15000, 1500, 0, 0]
			}
		]
	};
	
	$(".btn-group").on("click", function(e){
		console.log($(e.target).attr('id'));
	});
	
	var chart3 = new Chart("ServerHitChart", { type: "line",	data: areaChartData, options: optServerHit });

</script>
