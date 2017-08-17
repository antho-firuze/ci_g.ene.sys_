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
		disableBtn: ['btn-copy','btn-message','btn-process'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	if ("{$is_canimport}" == "0") Toolbar_Init.disableBtn.push('btn-import');
	if ("{$is_canexport}" == "0") Toolbar_Init.disableBtn.push('btn-export');
	{* DataTable Init *}
	var format_money = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var DataTable_Init = {
		enable: true,
		tableWidth: '135%',
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [
			{ pageid: 114, subKey: 'inout_id', title: 'Material Receipt Line', },
		],
		columns: [
			{ width:"100px", orderable:false, data:"doc_no", title:"Doc No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"received_date", title:"Received Date" },
			{ width:"100px", orderable:false, data:"doc_no_order", title:"PO Doc No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date_order", title:"PO Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"eta_order", title:"PO ETA" },
			{ width:"150px", orderable:false, data:"bpartner_name", title:"Vendor" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
			{* { width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"sub_total", title:"Sub Total", render: function(data, type, row){ return format_money(data); } }, *}
			{* { width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"vat_total", title:"VAT Total", render: function(data, type, row){ return format_money(data); } }, *}
			{* { width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"grand_total", title:"Grand Total", render: function(data, type, row){ return format_money(data); } }, *}
			{* { width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"plan_total", title:"Plan Total", render: function(data, type, row){ return format_money(data); } }, *}
			{* { width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } }, *}
		],
		order: ['id desc'],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
