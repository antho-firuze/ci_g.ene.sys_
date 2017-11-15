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
	
	{* Chart Sales Order *}
	col = [], row = [], boxes = [];
	var boxInfo0 = BSHelper.Box({ type:"info", header: true, title: "Hit Access", icon: "" });
	boxInfo0.find('.box-header').append($('<div class="box-tools pull-right" />').append(BSHelper.GroupButton( { cls:"btn-step", list:[{ id: "btn1", title: "Hourly", text: "H" }, { id: "btn2", title: "Daily", text: "D", active: true }, { id: "btn3", title: "Weekly", text: "W" }, { id: "btn4", title: "Monthly", text: "M" }, ]} )) );
	col.push('<div class="chart"><canvas id="lineChart" style="height:180px"></canvas></div>');
	row.push(subCol(12, col)); col = [];
	col.push(BSHelper.Pills({ dataList:[{ title: "Hits", value: "#" },{ title: "Create (POST)", value: "#" },{ title: "Read (GET)", value: "#" },{ title: "Modify (PUT)", value: "#" }] }));
	row.push(subCol(3, col)); col = [];

	{* boxInfo0.find('.box-body').append('<div class="chart"><canvas id="lineChart" style="height:180px"></canvas></div>'); *}
	boxInfo0.find('.box-body').append(subRow(row));
	boxes.push(subCol(12, boxInfo0));
</script>
