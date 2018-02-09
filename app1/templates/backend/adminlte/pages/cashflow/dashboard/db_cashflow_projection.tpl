<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<!-- /.row -->
		<div class="filter"></div>
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
<script src="{$.const.TEMPLATE_URL}plugins/datatables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Advance filter Init *}
	var AdvanceFilter_Init = {
		enable: true, 
		params: [ 'fdate', 'tdate' ],
		fdate: moment().startOf("month"),
		tdate: moment().endOf("month"),
		dateRanges: {
			'This Week': [moment().startOf('week'), moment().endOf('week')],
			'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'This Year': [moment().startOf('year'), moment().endOf('year')],
			'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
		},
	};
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
		showPaginate: true,
		showColumnMenu: false,
		{* tableWidth: '100%', *}
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [],
		fixedColumns: {
			leftColumns: 1,
		},
		order: ['seq asc'],
		columns: [
			{ width:"200px", orderable:false, data:"description", title:"Description", render: function(data, type, row){ return (row.type == 'T' || row.type == 'L') ? '<b>'+data+'</b>' : data; } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"projection", title:"Projection", render: 
				function(data, type, row){ 
					var o = { fdate:$("#fdate").val(), tdate:$("#tdate").val(), account_id:row.account_id, type:1, title:row.projection_title };
					var link = $BASE_URL+'systems/x_page?pageid=256&filter='+encodeURI(JSON.stringify(o));
					return (row.type == 'T') 
						? '' 
						: (row.account_id) 
							? '<a target="_blank" href="'+link+'">'+format_money(data)+'</a>' 
							: format_money(data); 
				} 
			},
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"actual", title:"Actual", render: 
				function(data, type, row){ 
					var o = { fdate:$("#fdate").val(), tdate:$("#tdate").val(), account_id:row.account_id, type:2, title:row.actual_title };
					var link = $BASE_URL+'systems/x_page?pageid=256&filter='+encodeURI(JSON.stringify(o));
					return (row.type == 'T') 
						? '' 
						: (row.account_id) 
							? '<a target="_blank" href="'+link+'">'+format_money(data)+'</a>' 
							: format_money(data); 
				} 
			},
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"projection", title:"Difference", render: function(data, type, row){ return format_money(Math.abs(row.projection-row.actual)); } },
		],
	};
	
	{* INITILIZATION *}
	setTimeout(function(){
		{* var $filter = dateFormat(dateParsing(getURLParameter("filter").split('=')[1], "yyyy-mm-dd"), "dd/mm/yyyy"); *}
		updateTitle();
	}, 500);
	
	function updateTitle(){
		var fdate = moment($("#fdate").val()).format('DD/MM/YYYY');
		var tdate = moment($("#tdate").val()).format('DD/MM/YYYY');
		if ($(".content-header").find("h1 span").length > 0)
			$(".content-header").find("h1 span").text(" as per "+fdate+" - "+tdate);
		else
			$(".content-header").find("h1 small").before($("<span />").text(" as per "+fdate+" - "+tdate).prop('outerHTML'));
	}
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
<script>
	$("#form_advance_filter").validator().on('submit', function(e) {
		updateTitle();
	});
</script>
