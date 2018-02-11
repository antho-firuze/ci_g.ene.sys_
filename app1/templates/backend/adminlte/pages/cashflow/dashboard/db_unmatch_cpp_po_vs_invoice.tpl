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
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.css">
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Advance filter Init *}
	var AdvanceFilter_Init = {
		enable: true, 
		params: [ 'fdate', 'tdate' ],
		fdate: moment().startOf("year"),
		tdate: moment().endOf("year"),
		dateRanges: {
			'This Week': [moment().startOf('week'), moment().endOf('week')],
			'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'This Year': [moment().startOf('year'), moment().endOf('year')],
			'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
			'All Period': [moment('1601-01-01').startOf('year'), moment('9999-01-01').endOf('year')],
		},
	};
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
		showColumnMenu: false,
		act_menu: { copy: false, edit: false, delete: false },
		sub_menu: [],
		order: ['id desc'],
		columns: [
			{ width:"100px", orderable:true, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:true, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:true, data:"bpartner_name", title:"Business Partner" },
			{ width:"100px", orderable:true, data:"residence", title:"Residence" },
			{ width:"100px", orderable:true, data:"po_no", title:"PO No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"po_date", title:"PO Date" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"eta", title:"Vendor ETA" },
			{ width:"100px", orderable:true, data:"doc_no", title:"Invoice No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"invoice_date", title:"Invoice Date (Actual)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"payment_plan_date", title:"Payment Date (Actual)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"invoice_plan_date", title:"Invoice Date (Plan)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"pay_plan_date", title:"Payment Date (Plan)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"late", title:"Late (Days)", 
				render: function(data, type, row){ 
					if ( parseInt(data) > 0 && parseInt(data) <= 7 ) 
						return $("<span>").addClass('label label-warning').text(data).prop('outerHTML');
					else if ( parseInt(data) > 7 ) 
						return $("<span>").addClass('label label-danger').text(data).prop('outerHTML'); 
					else 
						return $("<span>").addClass('label label-success').text(data).prop('outerHTML'); 
				},
			},
			{ width:"100px", orderable:true, data:"status", title:"Late Reason" },
			{ width:"100px", orderable:true, data:"category_name", title:"Category" },
			{ width:"200px", orderable:true, data:"note", title:"payment Type" },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"amount", title:"Base Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"adj_amount", title:"Adj Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"net_amount", title:"Net Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"20px", orderable:true, className:"dt-head-center dt-body-center", data:"po_top", title:"TOP (days)" },
		],
		footers: [
			{ data: 'amount', 	title: 'Base Total' }, 
			{ data: 'adj_amount', 	title: 'Adj. Total' }, 
			{ data: 'net_amount', 	title: 'Grand Total' }, 
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
