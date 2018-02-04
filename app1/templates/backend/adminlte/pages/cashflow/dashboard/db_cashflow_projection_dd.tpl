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
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
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
		showColumnMenu: false,
		tableWidth: '150%',
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [],
		columns: [
			{ width:"100px", orderable:false, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:true, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:true, data:"bpartner_name", title:"Business Partner Name" },
			{ width:"100px", orderable:false, data:"account_name", title:"Account Name" },
			{ width:"100px", orderable:false, data:"doc_type_name", title:"Doc Type Name" },
			{ width:"100px", orderable:false, data:"doc_type_reference", title:"Doc Type Reference" },
			{ width:"100px", orderable:false, data:"invoice_no", title:"Invoice No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"invoice_plan_date", title:"Invoice Plan Date" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"invoice_date", title:"Invoice Date" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"received_plan_date", title:"Received Plan Date" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"payment_plan_date", title:"Payment Plan Date" },
			{ width:"100px", orderable:false, data:"voucher_no", title:"Voucher No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"voucher_date", title:"Voucher Date" },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"amount", title:"Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"adj_amount", title:"Adj Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"net_amount", title:"Net Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, data:"created_by_name", title:"Created By" },
			{ width:"100px", orderable:true, data:"updated_by_name", title:"Updated By" },
			{ width:"100px", orderable:false, data:"note", title:"Note" },
			{ width:"200px", orderable:false, data:"description", title:"Description" },
		],
		order: ['id desc'],
	};
	
	{* INITILIZATION *}
	setTimeout(function(){
		var $filter = $.parseJSON(getURLParameter("filter"));
		var $title = $filter.title;
		var fdate = moment($filter.fdate).format('DD/MM/YYYY');
		var tdate = moment($filter.tdate).format('DD/MM/YYYY');
		{* console.log($title); *}
		$(".content-header").find("h1").text($(".content-header").find("h1").text()+" ("+$title+") as per "+fdate+" - "+tdate);
	}, 500);
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
