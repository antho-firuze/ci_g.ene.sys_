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
	{* Additional filter *}
	var col = [], row = [], a = [];
	var form0 = BSHelper.Form({ autocomplete:"off" });
	var box0 = BSHelper.Box({ type:"info", header:true, title:"Advance Filter", toolbtn:['min'], collapse:true });
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"account_id", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"type", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"title", }));
	a.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	col.push(BSHelper.Label({ horz: false, label:"Period", idname:"fperiod", required: false, elcustom: a }));
	row.push(subCol(6, col)); col = [];
	form0.append(subRow(row));
	form0.append(subRow(subCol()));
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	form0.append( col );
	box0.find('.box-body').append(form0);
	$(".content .filter").after(box0);
	{* INITILIZATION *}
	var start = moment().startOf('week');
	var end = moment().endOf('week');
	{* //Date range as a button *}
	$('#btn_cal').daterangepicker(
			{
				ranges: {
					'This Week': [moment().startOf('week'), moment().endOf('week')],
					'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
					'Next Week': [moment().add(1, 'week').startOf('week'), moment().add(1, 'week').endOf('week')],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
				},
				startDate: moment().startOf('week'),
				endDate: moment().endOf('week')
			},
			function (start, end) {
				{* console.log(start.format('YYYY-MM-DD') + ' - ' + end.format('MMMM D, YYYY')); *}
				$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$("#fdate").val(start.format('YYYY-MM-DD'));
				$("#tdate").val(end.format('YYYY-MM-DD'));
			}
	);
	$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	$("#fdate").val(start.format('YYYY-MM-DD'));
	$("#tdate").val(end.format('YYYY-MM-DD'));
	
	var $filter = $.parseJSON(getURLParameter("filter"));
	if ($filter){
		$('#btn_cal span').html(moment($filter.fdate).format('MMMM D, YYYY') + ' - ' + moment($filter.tdate).format('MMMM D, YYYY'));
		$('#btn_cal').daterangepicker({ 
			ranges: {
				'This Week': [moment().startOf('week'), moment().endOf('week')],
				'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
				'Next Week': [moment().add(1, 'week').startOf('week'), moment().add(1, 'week').endOf('week')],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
			},
			startDate: moment($filter.fdate), endDate: moment($filter.tdate) });
		$("#fdate").val($filter.fdate);
		$("#tdate").val($filter.tdate);
		updateTitle();
	}
	
	form0.validator().on('submit', function(e) {
		if (e.isDefaultPrevented()) { return false;	} 
		
		var $origin_url = getURLFull();
		var f = form0.serialize();
		$origin_url = URI($origin_url).setSearch('filter', form0.serializeJSON());
		$url_module = URI($url_module).setSearch('filter', form0.serializeJSON()).setSearch('ob', "seq asc");
		$filter = form0.serializeJSON();
		history.pushState({}, '', $origin_url);
		dataTable1.ajax.url( $url_module ).load();
		
		updateTitle();
		
		return false;
	});

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
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"projection", title:"Projection", render: function(data, type, row){ return (row.type == 'T') ? '' : (row.account_id) ? '<a target="_blank" href="'+$BASE_URL+'systems/x_page?pageid=256&filter='+encodeURI(form0.find("#account_id").val(row.account_id).parent().find("#type").val(1).parent().find("#title").val(row.projection_title).parent().serializeJSON())+'">'+format_money(data)+'</a>' : format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"actual", title:"Actual", render: function(data, type, row){ return (row.type == 'T') ? '' : (row.account_id) ? '<a target="_blank" href="'+$BASE_URL+'systems/x_page?pageid=256&filter='+encodeURI(form0.find("#account_id").val(row.account_id).parent().find("#type").val(2).parent().find("#title").val(row.actual_title).parent().serializeJSON())+'">'+format_money(data)+'</a>' : format_money(data); } },
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
