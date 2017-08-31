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
		columns: [
			{ width:"100px", orderable:false, data:"date", title:"Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"so_unmatch", title:"SO" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"ship_unmatch", title:"Shipment" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"po_unmatch", title:"PO" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"mr_unmatch", title:"MR" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"req_unmatch", title:"Planning" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"pr_unmatch", title:"PR" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"outflow_unmatch", title:"Oth_Outflow" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"inflow_unmatch", title:"Oth_Inflow" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"inv_c_unmatch", title:"Inv_Cust" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"inv_v_unmatch", title:"Inv_Vend" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"inv_if_unmatch", title:"Inv_Oth_Inflow" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"inv_of_unmatch", title:"Inv_Oth_Outflow" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"ar_unmatch", title:"Cash_Rcv" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"ap_unmatch", title:"Cash_Pay" },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
