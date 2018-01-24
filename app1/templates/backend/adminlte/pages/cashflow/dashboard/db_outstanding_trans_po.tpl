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
			{ width:"100px", orderable:false, data:"residence", title:"Residence" },
			{ width:"100px", orderable:true, data:"doc_no", title:"PO No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"doc_date", title:"PO Date" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"eta", title:"Requisition ETA" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"eta", title:"Vendor ETA" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"estimation_late", title:"Receive Days Left", 
				render: function(data, type, row){ return parseInt(data) > 0 ? data : 0; },
				createdCell: function (td, cellData, rowData, row, col) { if ( parseInt(cellData) > 0 ) { $(td).css({ 'background-color':'red', 'font-weight':'bold' }); } },
			},{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"late", title:"Actual Late (Days)", 
				render: function(data, type, row){ return parseInt(data) > 0 ? data : 0; },
				createdCell: function (td, cellData, rowData, row, col) { if ( parseInt(cellData) > 0 ) { $(td).css({ 'background-color':'red', 'font-weight':'bold' }); } },
			},
			{ width:"100px", orderable:true, data:"category_name", title:"Category" },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"sub_total", title:"PO Taxable (Amount)", render: function(data, type, row){ return format_money(data); } },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
