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
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-new','btn-copy','btn-delete','btn-print','btn-message','btn-import','btn-process'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	{* DataTable Init *}
	var format_money = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var DataTable_Init = {
		enable: true,
		tableWidth: '130%',
		act_menu: { copy: false, edit: false, delete: false },
		sub_menu: [],
		order: ['id desc'],
		columns: [
			{ width:"100px", orderable:true, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:true, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:true, data:"bpartner_name", title:"Business Partner" },
			{ width:"100px", orderable:true, data:"residence", title:"Residence" },
			{ width:"100px", orderable:true, data:"ap_no", title:"Outflow No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"ap_date", title:"Outflow Date" },
			{ width:"100px", orderable:true, data:"doc_no", title:"Invoice No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"doc_date", title:"Invoice Date (Actual)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"payment_plan_date", title:"Payment Date (Actual)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"invoice_plan_date", title:"Invoice Date (Plan)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"pay_plan_date", title:"Payment Date (Plan)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"late", title:"Late (Days)", 
				render: function(data, type, row){ return parseInt(data) > 0 ? data : 0; },
				createdCell: function (td, cellData, rowData, row, col) { if ( parseInt(cellData) > 0 ) { $(td).css({ 'background-color':'red', 'font-weight':'bold' }); } },
			},
			{ width:"200px", orderable:true, data:"note", title:"Payment Type" },
			{ width:"100px", orderable:true, data:"status", title:"Late Reason" },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"amount", title:"Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"adj_amount", title:"Adj Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"net_amount", title:"Net Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"20px", orderable:true, className:"dt-head-center dt-body-center", data:"po_top", title:"TOP (Days)" },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
