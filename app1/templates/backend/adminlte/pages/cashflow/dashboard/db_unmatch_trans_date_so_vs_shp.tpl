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
	var format_percent = function(value){ return accounting.formatMoney(value, { symbol: "%", format: "%v%s" }) };
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
			{ width:"100px", orderable:false, data:"residence", title:"Residence" },
			{ width:"100px", orderable:true, data:"doc_no", title:"SO No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"doc_date", title:"SO Date" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"expected_dt_cust", title:"DT Customer" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"etd", title:"SCM ETD" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"delivery_date", title:"Delivery Date (Actual)" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"late", title:"Actual Late (Days)", 
				render: function(data, type, row){ 
					if ( parseInt(data) > 0 && parseInt(data) <= 7 ) 
						return $("<span>").addClass('label label-warning').text(data).prop('outerHTML');
					else if ( parseInt(data) > 7 ) 
						return $("<span>").addClass('label label-danger').text(data).prop('outerHTML'); 
					else 
						return $("<span>").addClass('label label-success').text(data).prop('outerHTML'); 
				},
			},
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"penalty_amount", title:"Actual penalty (Amount)", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"penalty_percent", title:"Actual Penalty (Percent)", render: function(data, type, row){ return format_percent(data * 100); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"max_penalty_percent", title:"Max Penalty (Percent)", render: function(data, type, row){ return format_percent(data * 100); } },
			{ width:"200px", orderable:true, data:"reason_name", title:"Late Reason", createdCell: function (td, cellData, rowData, row, col) { $(td).css({ 'text-overflow':'unset', 'overflow-x':'auto' }); } },
			{ width:"100px", orderable:true, data:"category_name", title:"Category" },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"sub_total", title:"Sub Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"vat_total", title:"VAT Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"grand_total", title:"Grand Total", render: function(data, type, row){ return format_money(data); } },
		],
		footers: [
			{ data: 'sub_total', 	title: 'Sub Total' }, 
			{ data: 'vat_total', 	title: 'VAT Total' }, 
			{ data: 'grand_total', 	title: 'Grand Total' }, 
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
