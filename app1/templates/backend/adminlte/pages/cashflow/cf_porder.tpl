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
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/jQuery-QueryBuilder/css/query-builder.default.min.css">
<script src="{$.const.TEMPLATE_URL}plugins/jQuery-QueryBuilder/js/query-builder.standalone.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/interact/dist/interact.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/sql-parser/browser/sql-parser.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process','btn-filter','btn-sort'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-process'],
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
		tableWidth: '200%',
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [
			{ pageid: 110, subKey: 'order_id', title: 'Purchase Order Line', },
			{ pageid: 111, subKey: 'order_id', title: 'Purchase Order Plan' },
			{ pageid: 112, subKey: 'order_id', title: 'Purchase Order Plan Clearance' },
			{ pageid: 113, subKey: 'order_id', title: 'Purchase Order Plan Custom Duty' },
		],
		columns: [
			{ width:"100px", orderable:false, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:false, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"150px", orderable:false, data:"bpartner_name", title:"Vendor" },
			{ width:"100px", orderable:false, data:"doc_no", title:"Doc No" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_import", title:"Import", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"eta", title:"ETA" },
			{ width:"100px", orderable:false, data:"doc_no_requisition", title:"PR Doc No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date_requisition", title:"PR Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"eta_requisition", title:"PR ETA" },
			{ width:"200px", orderable:false, data:"description", title:"Description" },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"sub_total", title:"Sub Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"vat_total", title:"VAT Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"grand_total", title:"Grand Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"plan_total", title:"Plan Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"plan_cl_total", title:"Plan Total (CL)", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"plan_im_total", title:"Plan Total (IM)", render: function(data, type, row){ return format_money(data); } },
		],
		order: ['id desc'],
	};
	
	{* Initialization *}
	function func_filter(data) {
		var col = [], row = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		col.push($('<div id="builder" />'));
		row.push(subCol(12, col));
		form1.append(subRow(row));
		form1.on('submit', function(e){ e.preventDefault(); });
		
		var options = {
			allow_empty: true,
			sort_filters: true,
			plugins: {
				'bt-tooltip-errors': { delay: 100 },
				'sortable': null,
				{* 'filter-description': { mode: 'bootbox' }, *}
				{* 'bt-selectpicker': null, *}
				'unique-filter': null,
				{* 'bt-checkbox': { color: 'primary' }, *}
				{* 'invert': null, *}
				{* 'not-group': null *}
			},
			operators: [
				{ type: 'equal', optgroup: 'basic' },
				{ type: 'not_equal', optgroup: 'basic' },
				{ type: 'in', optgroup: 'basic' },
				{ type: 'not_in', optgroup: 'basic' },
				{ type: 'less', optgroup: 'numbers' },
				{ type: 'less_or_equal', optgroup: 'numbers' },
				{ type: 'greater', optgroup: 'numbers' },
				{ type: 'greater_or_equal', optgroup: 'numbers' },
				{ type: 'between', optgroup: 'numbers' },
				{ type: 'not_between', optgroup: 'numbers' },
				{ type: 'begins_with', optgroup: 'strings' },
				{ type: 'not_begins_with', optgroup: 'strings' },
				{ type: 'contains', optgroup: 'strings' },
				{ type: 'not_contains', optgroup: 'strings' },
				{ type: 'ends_with', optgroup: 'strings' },
				{ type: 'not_ends_with', optgroup: 'strings' },
				{ type: 'is_empty' },
				{ type: 'is_not_empty' },
				{ type: 'is_null' },
				{ type: 'is_not_null' }
			],
			filters: [
				{
					unique: true,
					id: 'is_import',
					label: 'Is Import',
					type: 'string',
					input: 'radio',
					values: {
						'1': 'Yes',
						'0': 'No'
					},
					operators: ['equal'],
				},
				{
					unique: true,
					id: 'grand_total',
					label: 'Grand Total',
					type: 'double',
					size: 5,
					validation: {
						min: 0,
						step: 0.01
					},
				},
				{
					unique: true,
					id: 't1.doc_date',
					label: 'Doc Date',
					type: 'datetime',
				},
			],
		};

		form1.find('#builder').queryBuilder(options);
		var $method = $url_module.split('/')[4];
		var $sfilter = get('sfilter_'+$method);
		if ($sfilter && typeof($sfilter) !== null)
			form1.find('#builder').queryBuilder('setRulesFromSQL', $sfilter);

		BootstrapDialog.show({ title: 'Filter Records', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_WIDE, message: form1,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-success',
				label: '&nbsp;&nbsp;Submit',
				action: function(dialog) {
					var button = this;
					button.spin();
					
					var res = form1.find('#builder').queryBuilder('getSQL', false, false);
					if (res.sql) {
						store('sfilter_'+$method, res.sql);
						var url = URI(dataTable1.ajax.url()).removeSearch('sfilter').addSearch('sfilter', res.sql);
						$("#btn-filter").addClass("active");
					}	else {
						remove('sfilter_'+$method);
						var url = URI(dataTable1.ajax.url()).removeSearch('sfilter');
						$("#btn-filter").removeClass("active");
					}
					dataTable1.ajax.url( url ).load();
					dialog.close();
				}
			}, {
					label: 'Cancel',
					action: function(dialog) { dialog.close(); }
			}],
			onshown: function(dialog) {
			}
		}); 
	}
	
	function func_sort(data) {
		var col = [], row = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		col.push($('<div id="builder" />'));
		row.push(subCol(12, col));
		form1.append(subRow(row));
		form1.on('submit', function(e){ e.preventDefault(); });
		
		var options = {
			conditions: ['AND'],
			allow_empty: true,
			allow_groups: false,
			plugins: {
				'bt-tooltip-errors': { delay: 100 },
				'unique-filter': null,
			},
			filters: [
				{
					unique: true,
					id: 'doc_no',
					label: 'Doc No',
					type: 'string',
					operators: ['asc', 'desc'],
				},
				{
					unique: true,
					id: 't1.doc_date',
					label: 'Doc Date',
					type: 'string',
					operators: ['asc', 'desc'],
				},
			],
		};

		form1.find('#builder').queryBuilder(options);
		var $method = $url_module.split('/')[4];
		var $ob = get('ob_'+$method);
		if ($ob && typeof($ob) !== null) {
			var rules = [];
			$.each($ob.split(', '), function(k, v){
				rules.push({ "id":v.split(' ')[0], "operator":v.split(' ')[1].toLowerCase() }); 
			});
			form1.find('#builder').queryBuilder('setRules', { "condition":"AND", "rules":rules });
		}

		BootstrapDialog.show({ title: 'Sorting Records', type: BootstrapDialog.TYPE_SUCCESS, message: form1,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-success',
				label: '&nbsp;&nbsp;Submit',
				action: function(dialog) {
					var button = this;
					button.spin();
					
					var res = form1.find('#builder').queryBuilder('getSQL', false, false);
					{* console.log(res.sql.split(' AND').join()); *}
					{* return false; *}
					if (res.sql) {
						store('ob_'+$method, res.sql.split(' AND').join());
						var url = URI(dataTable1.ajax.url()).removeSearch('ob').addSearch('ob', res.sql.split(' AND').join());
						$("#btn-sort").addClass("active");
					}	else {
						remove('ob_'+$method);
						var url = URI(dataTable1.ajax.url()).removeSearch('ob');
						$("#btn-sort").removeClass("active");
					}
					dataTable1.ajax.url( url ).load();
					dialog.close();
				}
			}, {
					label: 'Cancel',
					action: function(dialog) { dialog.close(); }
			}],
			onshown: function(dialog) {
			}
		}); 
	}
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
