<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<!-- /.row -->
		<div class="box box-body datagrid table-responsive no-padding"></div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/datatables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: false,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-process'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	{* DataTable Init *}
	var format_money = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var DataTable_Init = {
		enable: true,
		rows: 100,
		showFilter: false,
		showPaginate: false,
		showColumnMenu: false,
		tableWidth: '100%',
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [],
		fixedColumns: {
			leftColumns: 1,
		},
		columns: [
			{ width:"200px", orderable:false, data:"description", title:"Description", render: function(data, type, row){ return (row.type == 'T' || row.type == 'L') ? '<b>'+data+'</b>' : data; } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"current", title:"Current Date <br>Projection", render: function(data, type, row){ return (row.type == 'T') ? '' : (row.account_id) ? '<a target="_blank" href="'+$BASE_URL+'systems/x_page?pageid=232&filter='+row.today_param+'&title='+row.today_title+'">'+format_money(data)+'</a>' : format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"current", title:"Current Date <br>Projection", render: function(data, type, row){ return (row.type == 'T') ? '' : (row.account_id) ? '<a target="_blank" href="'+$BASE_URL+'systems/x_page?pageid=232&filter='+row.today_param+'&title='+row.today_title+'">'+format_money(data)+'</a>' : format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"current", title:"Current Date <br>Projection", render: function(data, type, row){ return (row.type == 'T') ? '' : (row.account_id) ? '<a target="_blank" href="'+$BASE_URL+'systems/x_page?pageid=232&filter='+row.today_param+'&title='+row.today_title+'">'+format_money(data)+'</a>' : format_money(data); } },
		],
		order: ['seq asc'],
	};
	
	{* INITILIZATION *}
	setTimeout(function(){
		var $filter = dateFormat(dateParsing(getURLParameter("filter").split('=')[1], "yyyy-mm-dd"), "dd/mm/yyyy");
		$(".content-header").find("h1").text($(".content-header").find("h1").text()+" as per "+$filter);
	}, 500);
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
