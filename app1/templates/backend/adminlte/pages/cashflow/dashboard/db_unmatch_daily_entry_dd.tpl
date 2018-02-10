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
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-process','btn-new','btn-delete','btn-print','btn-import','btn-viewlog'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	{* DataTable Init *}
	var format_money = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var DataTable_Init = {
		enable: true,
		rows: 10,
		showFilter: true,
		showPaginate: true,
		showColumnMenu: false,
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [],
		order: [],
		columns: [
			{ width:"100px", orderable:true, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:true, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:true, data:"module", title:"Module" },
			{ width:"100px", orderable:true, data:"doc_no", title:"Doc No" },
			{ width:"70px", orderable:true, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"70px", orderable:true, className:"dt-head-center dt-body-center", data:"created_at", title:"Created Date" },
			{ width:"100px", orderable:true, data:"created_by", title:"Created By" },
			{ width:"100px", orderable:true, data:"status", title:"Status" },
		],
	};
	
	{* INITILIZATION *}
	{* setTimeout(function(){ *}
		{* var $filter = dateFormat(dateParsing(getURLParameter("filter").split('=')[1], "yyyy-mm-dd"), "dd/mm/yyyy"); *}
		{* $(".content-header").find("h1").text($(".content-header").find("h1").text()+" as per "+$filter); *}
	{* }, 500); *}
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
