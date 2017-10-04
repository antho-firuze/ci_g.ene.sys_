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
			{ width:"100px", orderable:false, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:false, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:false, data:"doc_no_order", title:"PO No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"payment_plan_date", title:"PO Payment Plan Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"payment_plan_date_invoice", title:"FIN Payment Plan Date" },
			{ width:"100px", orderable:false, data:"bpartner_name", title:"Business Partner" },
			{ width:"250px", orderable:false, data:"note", title:"Note" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"amount", title:"Amount", render: function(data, type, row){ return format_money(data); } },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
