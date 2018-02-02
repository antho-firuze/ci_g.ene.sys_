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
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/daterangepicker.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/shollu-combobox/js/shollu_cb.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Additional filter *}
	var col = [], row = [], a = [];
	var form0 = BSHelper.Form({ autocomplete:"off" });
	var box0 = BSHelper.Box({ type:"info", header:true, title:"Advance Filter", toolbtn:['min'], collapse:true });
	col.push(BSHelper.Input({ type:"hidden", idname:"fdate", }));
	col.push(BSHelper.Input({ type:"hidden", idname:"tdate", }));
	a.push(BSHelper.Button({ type:"button", label:'<i class="fa fa-calendar"></i>&nbsp;<span>Date range picker</span> &nbsp;&nbsp;<i class="fa fa-caret-down"></i>', cls:"btn-danger", idname: "btn_cal", }));
	col.push(BSHelper.Label({ horz: false, label:"Period", idname:"fperiod", required: false, elcustom: a }));
	col.push(BSHelper.Combobox({ label:"Module", idname:"module_id", required: true, 
		list:[
			{ id:"1", name:"Sales Order" },
			{ id:"2", name:"Shipment" },
			{ id:"3", name:"Request/Planning" },
			{ id:"4", name:"Purchase Request" },
			{ id:"5", name:"Purchase Order" },
			{ id:"6", name:"Material Receipt" },
			{ id:"7", name:"Inflow" },
			{ id:"8", name:"Outflow" },
			{ id:"9", name:"Invoice Customer" },
			{ id:"10", name:"Invoice Vendor" },
			{ id:"11", name:"Invoice Inflow" },
			{ id:"12", name:"Invoice Outflow" },
			{ id:"13", name:"Bank Received" },
			{ id:"14", name:"Bank Payment" },
		] 
	}));
	row.push(subCol(6, col)); col = [];
	form0.append(subRow(row));
	form0.append(subRow(subCol()));
	col.push( BSHelper.Button({ type:"submit", label:"Submit", idname:"submit_btn" }) );
	form0.append( col );
	box0.find('.box-body').append(form0);
	$(".content .filter").after(box0);
	{* INITILIZATION *}
	var start = moment().startOf('month');
	var end = moment().endOf('month');
	{* //Date range as a button *}
	$('#btn_cal').daterangepicker(
			{
				ranges: {
					{* 'Today': [moment(), moment()], *}
					{* 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')], *}
					{* 'Last 7 Days': [moment().subtract(6, 'days'), moment()], *}
					{* 'Last 30 Days': [moment().subtract(29, 'days'), moment()], *}
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
					'Next Month': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')],
				},
				startDate: moment().startOf('month'),
				endDate: moment().endOf('month')
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
		$("#module_id").shollu_cb('setValue', $filter.module_id);
	}
	
	form0.validator().on('submit', function(e) {
		if (e.isDefaultPrevented()) { return false;	} 
		
		var $origin_url = getURLFull();
		var f = form0.serialize();
		$origin_url = URI($origin_url).setSearch('filter', form0.serializeJSON());
		$url_module = URI($url_module).setSearch('filter', form0.serializeJSON());
		$filter = form0.serializeJSON();
		history.pushState({}, '', $origin_url);
		dataTable1.ajax.url( $url_module ).load();
		return false;
	});

	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: false,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-new','btn-copy','btn-delete','btn-print','btn-message','btn-import','btn-process'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	{* DataTable Init *}
	var format_money = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var format_percent = function(value){ return accounting.formatMoney(value, { symbol: "%", precision: 1, format: "%v%s" }) };
	var DataTable_Init = {
		enable: true,
		rows: 100,
		showFilter: false,
		showColumnMenu: false,
		{* tableWidth: '130%', *}
		act_menu: { copy: false, edit: false, delete: false },
		sub_menu: [],
		columns: [
			{ width:"100px", orderable:true, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:true, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"match", title:"Match (Qty/Percent)", 
				render: function(data, type, row){
					perc = data/row.total*100;
					if ( parseInt(perc) > 30 && parseInt(perc) <= 70 ) 
						return $("<span>").addClass('label label-warning').text(data +' / '+ format_percent(perc)).prop('outerHTML');
					else if ( parseInt(perc) > 70 ) 
						return $("<span>").addClass('label label-success').text(data +' / '+ format_percent(perc)).prop('outerHTML'); 
					else 
						return $("<span>").addClass('label label-danger').text(data +' / '+ format_percent(perc)).prop('outerHTML'); 
				},
			},
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"unmatch", title:"Unmatch (Qty/Percent)", 
				render: function(data, type, row){
					perc = data/row.total*100;
					if ( parseInt(perc) > 0 && parseInt(perc) <= 70 ) 
						return $("<span>").addClass('label label-danger').text(data +' / '+ format_percent(perc)).prop('outerHTML');
					else if ( parseInt(perc) > 70 ) 
						return $("<span>").addClass('label label-danger').text(data +' / '+ format_percent(perc)).prop('outerHTML'); 
					else 
						return $("<span>").addClass('label label-success').text(data +' / '+ format_percent(perc)).prop('outerHTML'); 
				},
			},
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"total", title:"Qty Total" },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
