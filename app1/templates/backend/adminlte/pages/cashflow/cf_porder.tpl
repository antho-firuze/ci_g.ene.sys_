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
<script src="{$.const.TEMPLATE_URL}plugins/jQuery-QueryBuilder/js/query-builder.standalone.min.js"></script>
{* <script src="{$.const.TEMPLATE_URL}plugins/interact/interact.js"></script> *}
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process','btn-filter'],
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
			{ width:"100px", orderable:false, data:"doc_no", title:"Doc No" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_import", title:"Import", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"eta", title:"ETA" },
			{ width:"100px", orderable:false, data:"doc_no_requisition", title:"PR Doc No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date_requisition", title:"PR Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"eta_requisition", title:"PR ETA" },
			{ width:"150px", orderable:false, data:"bpartner_name", title:"Vendor" },
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
		var col = [], row = [], a = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		{* col.push("<h3>Sales Order : <br>"+data.doc_no+"</h3>"); *}
		{* a.push(BSHelper.LineDesc({ label:"Doc Date", value: data.doc_date })); *}
		{* a.push(BSHelper.LineDesc({ label:"Customer", value: data.bpartner_name })); *}
		{* a.push(BSHelper.LineDesc({ label:"Reference No", value: data.doc_ref_no })); *}
		{* a.push(BSHelper.LineDesc({ label:"Reference Date", value: data.doc_ref_date })); *}
		{* a.push(BSHelper.LineDesc({ label:"Expected DT Customer", value: data.expected_dt_cust })); *}
		{* col.push(BSHelper.Input({ horz:false, type:"date", label:"ETD", idname:"etd", cls:"auto_ymd", format:"{$.session.date_format}", required: true })); *}
		{* col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", })); *}
		col.push($('<div id="builder" />'));
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.on('submit', function(e){ e.preventDefault(); });
		
  var options = {
    allow_empty: true,

    sort_filters: true,

    plugins: {
      {* 'bt-tooltip-errors': { delay: 100 }, *}
      {* 'sortable': null, *}
      {* 'filter-description': { mode: 'bootbox' }, *}
      {* 'bt-selectpicker': null, *}
      {* 'unique-filter': null, *}
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
        id: 'is_import',
        label: 'Is Import',
        type: 'string',
        input: 'radio',
        values: {
          '1': 'Yes',
          '0': 'No'
        },
        operators: ['equal']
      },
		],
  };

  $('.parse-sql').on('click', function() {
    var res = $('#builder').queryBuilder('getSQL', $(this).data('stmt'), false);
    $('#result').removeClass('hide')
      .find('pre').html(
      res.sql + (res.params ? '\n\n' + JSON.stringify(res.params, undefined, 2) : '')
    );
  });
  form1.find('#builder').queryBuilder(options);

		BootstrapDialog.show({ title: 'Filter Record/s', type: BootstrapDialog.TYPE_SUCCESS, message: form1,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-success',
				label: '&nbsp;&nbsp;Filter',
				action: function(dialog) {
					var button = this;
					button.spin();
					
					var res = form1.find('#builder').queryBuilder('getSQL', false, false);
					console.log(res.sql);
					return false;
					
					var $xdel = getURLParameter("xdel") ? "&xdel=1" : "";
					$.ajax({ url: $url_module+"?id="+ids.join()+$xdel, method: "DELETE", async: true, dataType: 'json',
						success: function(data) {
							dialog.close();
							dataTable1.ajax.reload( null, false );
							BootstrapDialog.alert(data.message);
						},
						error: function(data) {
							if (data.status >= 500){
								var message = data.statusText;
							} else {
								var error = JSON.parse(data.responseText);
								var message = error.message;
							}
							button.stopSpin();
							dialog.enableButtons(true);
							dialog.setClosable(true);
							BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
						}
					});
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
