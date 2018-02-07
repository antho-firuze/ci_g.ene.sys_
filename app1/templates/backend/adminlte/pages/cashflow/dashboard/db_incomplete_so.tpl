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
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [
			{* { pageid: 122, subKey: 'ar_ap_id', title: 'Outflow Line', }, *}
			{ pageid: 123, subKey: 'ar_ap_id', title: 'Outflow Plan', },
		],
		order: ['id desc'],
		columns: [
			{ width:"100px", orderable:true, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:true, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:true, data:"bpartner_name", title:"Business Partner" },
			{ width:"100px", orderable:true, data:"residence", title:"Residence" },
			{ width:"100px", orderable:true, data:"so_no", title:"SO No" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"so_date", title:"SO Date" },		
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"etd", title:"SCM ETD" },		
			{ width:"100px", orderable:true, data:"category_name", title:"Category" },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"grand_total", title:"SO Taxable (Amount)", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"plan_total", title:"Plan Total (Amount)", render: function(data, type, row){ return format_money(data); } },		
		],
		summary: ['grand_total'],
	};
	
	{* For design form interface *}
	var col = [], row = [];
	var form1 = BSHelper.Form({ autocomplete:"off" });
	var box1 = BSHelper.Box({ type:"info", footer: false });
	var format_money_2 = "'alias': 'decimal', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'rightAlign': true, 'autoGroup': true, 'autoUnmask': true";
	col.push(BSHelper.Input({ horz:true, lblsize:"col-sm-4", colsize:"col-sm-8", type:"text", label:"Grand Total SO", idname:"grand_total", style: "text-align: right;", format: format_money_2, required: false, value: 0, readonly: true, }));
	row.push(subCol(12, col)); col = [];
	form1.append(subRow(row)); row = [];
	box1.find('.box-body').append(form1);
	row.push(subCol(7));
	row.push(subCol(5, box1));
	$(".content").append(subRow(row));
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
