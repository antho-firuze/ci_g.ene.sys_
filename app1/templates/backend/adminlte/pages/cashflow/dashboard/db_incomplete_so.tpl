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
	{* Advance filter: Display Setup *}
	var col = [], row = [], a = [];
	var form0 = BSHelper.Form({ autocomplete:"off" });
	var box0 = BSHelper.Box({ type:"info", header:true, title:"Advance Filter", toolbtn:['min'], collapse:true });
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	a.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	col.push(BSHelper.Label({ horz: false, label:"Period", idname:"fperiod", required: false, elcustom: a }));
	row.push(subCol(6, col)); col = [];
	form0.append(subRow(row));
	form0.append(subRow(subCol()));
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	form0.append( col );
	box0.find('.box-body').append(form0);
	$(".content .filter").after(box0);
	
	{* Advance filter: Event for Submit *}
	form0.validator().on('submit', function(e) {
		if (e.isDefaultPrevented()) { return false;	} 
		
		var $origin_url = getURLFull();
		$origin_url = URI($origin_url).setSearch("filter", form0.serializeJSON());
		$url_module = URI(dataTable1.ajax.url()).setSearch("filter", form0.serializeJSON());
		$filter = form0.serializeJSON();
		history.pushState({}, '', $origin_url);
		dataTable1.ajax.url( $url_module ).load();
		
		return false;
	});

	{* Advance filter: Default Value *}
	function advance_filter_set_value(obj){
		var start = obj == undefined ? moment().startOf('week') : moment(obj.fdate);
		var end = obj == undefined ? moment().endOf('week'): moment(obj.tdate);
		var dateRanges = {
			'This Week': [moment().startOf('week'), moment().endOf('week')],
			'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
			'Next Week': [moment().add(1, 'week').startOf('week'), moment().add(1, 'week').endOf('week')],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
		};
		
		$('#btn_cal').daterangepicker({	startDate: start, endDate: end,	ranges: dateRanges,	})
		.on('apply.daterangepicker', function(ev, picker) {
			$('#btn_cal span').html(picker.startDate.format('MMMM D, YYYY') + ' - ' + picker.endDate.format('MMMM D, YYYY'));
			$("#fdate").val(picker.startDate.format('YYYY-MM-DD'));
			$("#tdate").val(picker.endDate.format('YYYY-MM-DD'));
		});
		$('#btn_cal span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		$("#fdate").val(start.format('YYYY-MM-DD'));
		$("#tdate").val(end.format('YYYY-MM-DD'));
	}
	
	{* Advance filter: Pre-defined Value *}
	var $filter = $.parseJSON(getURLParameter("filter"));
	advance_filter_set_value($filter);
	
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
		footers: [
			{ data: 'grand_total', 	title: 'Grand Total SO' }, 
			{* { data: 'plan_total', 	title: 'Total Plan SO' },  *}
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
