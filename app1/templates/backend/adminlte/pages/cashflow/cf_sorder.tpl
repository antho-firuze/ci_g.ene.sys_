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
{$.php.link_tag($.const.TEMPLATE_URL~'plugins/bootstrap-multiselect/css/bootstrap-multiselect.css')}
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.date.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
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
		tableWidth: '110%',
		act_menu: { copy: true, edit: true, delete: true },
		add_menu: [
			{ name: 'update_so_etd', title: 'Update SO ETD' }, 
		],
		sub_menu: [
			{ pageid: 99, subKey: 'order_id', title: 'Order Line', },
			{ pageid: 100, subKey: 'order_id', title: 'Order Plan' },
			{* { pageid: 127, subKey: 'order_id', title: 'Update ETD' }, *}
		],
		order: ['id desc'],
		columns: [
			{ width:"100px", orderable:true, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:true, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"150px", orderable:true, data:"bpartner_name", title:"Customer" },
			{ width:"100px", orderable:true, data:"doc_no", title:"Doc No" },
			{ width:"60px", orderable:true, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"expected_dt_cust", title:"Expected DT Customer" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"etd", title:"ETD" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"estimation_late", title:"Estimation Late", 
				render: function(data, type, row){ return parseInt(data) > 0 ? data : 0; },
				createdCell: function (td, cellData, rowData, row, col) { if ( parseInt(cellData) > 0 ) { $(td).css({ 'background-color':'red', 'font-weight':'bold' }); } },
			},
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"estimation_penalty_amount", title:"Estimation Penalty Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"200px", orderable:true, data:"reason_name", title:"Late Reason", createdCell: function (td, cellData, rowData, row, col) { $(td).css({ 'text-overflow':'unset', 'overflow-x':'auto' }); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"sub_total", title:"Sub Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"vat_total", title:"VAT Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"grand_total", title:"Grand Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:true, className:"dt-head-center dt-body-right", data:"plan_total", title:"Plan Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"200px", orderable:true, data:"description", title:"Description" },
		],
		{* createdRow: function( row, data, dataIndex ) { *}
			{* if ( parseInt(data['estimation_late']) > 0 ) {         *}
				{* $(row).attr('style', 'background-color: blue !important;'); *}
			{* } *}
		{* }, *}
	};
</script>
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/jQuery-QueryBuilder/css/query-builder.default.min.css">
<link rel="stylesheet" href="{$.const.TEMPLATE_URL}plugins/datepicker/datepicker3.css">
<script src="{$.const.TEMPLATE_URL}plugins/jQuery-QueryBuilder/js/query-builder.standalone.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/interact/dist/interact.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/bootbox/bootbox.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/sql-parser/browser/sql-parser.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/daterangepicker/moment.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/datepicker/bootstrap-datepicker.js"></script>
<script>
	var Sorting_Fields = [
		{	id: 'org_name', label: 'Org Name' },
		{	id: 'orgtrx_name', label: 'Org Trx Name' },
		{	id: 'bpartner_name', label: 'Customer' },
		{	id: 'doc_no',	label: 'Doc No'	},
		{	id: 'doc_date',	label: 'Doc Date'	},
		{	id: 'expected_dt_cust',	label: 'Expected DT Customer'	},
		{	id: 'etd',	label: 'ETD'	},
		{	id: 'estimation_late', label: 'Estimation Late'	},
		{	id: 'estimation_penalty_amount', label: 'Estimation Penalty Amount'	},
		{	id: 'reason_name', label: 'Late Reason'	},
		{	id: 'sub_total', label: 'Sub Total'	},
		{	id: 'vat_total', label: 'Vat Total'	},
		{	id: 'grand_total', label: 'Grand Total'	},
		{	id: 'plan_total', label: 'Plan Total'	},
	];
	
	function update_so_etd(data) {
		var col = [], row = [], a = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		col.push("<h3>Sales Order : <br>"+data.doc_no+"</h3>");
		a.push(BSHelper.LineDesc({ label:"Doc Date", value: data.doc_date }));
		a.push(BSHelper.LineDesc({ label:"Customer", value: data.bpartner_name }));
		a.push(BSHelper.LineDesc({ label:"Reference No", value: data.doc_ref_no }));
		a.push(BSHelper.LineDesc({ label:"Reference Date", value: data.doc_ref_date }));
		a.push(BSHelper.LineDesc({ label:"Expected DT Customer", value: data.expected_dt_cust }));
		col.push( $('<dl class="dl-horizontal">').append(a) ); a = [];
		col.push(BSHelper.Input({ horz:false, type:"date", label:"ETD", idname:"etd", cls:"auto_ymd", format:"{$.session.date_format}", value: data.etd, required: true }));
		col.push(BSHelper.Multiselect({ horz:false, label:"Late Reason", idname:"scm_dt_reasons", url:"{$.php.base_url('cashflow/rf_scm_dt_reason')}", value: data.scm_dt_reasons, required: false, remote: true }));
		col.push(BSHelper.Input({ horz:false, type:"textarea", label:"Description", idname:"description", }));
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.find("[data-mask]").inputmask();
		form1.on('submit', function(e){ e.preventDefault(); });
		
		BootstrapDialog.show({
			title: 'Update SO ETD', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_MEDIUM, message: form1, 
			buttons:[{ 
				cssClass: 'btn-primary', label: 'Submit', hotkey: 13, action: function(dialog) {
					var button = this;
					
					if (form1.validator('validate').has('.has-error').length === 0) {
						button.spin();
						button.disable();
						
						form1.append(BSHelper.Input({ type:"hidden", idname:"id", value:data.id }));
						
						$.ajax({ url: $url_module+'_etd', method: "OPTIONS", async: true, dataType: 'json',
							data: form1.serializeJSON(),
							success: function(data) {
								BootstrapDialog.show({ closable: false, message:data.message, 
									buttons: [{ label: 'OK', hotkey: 13, action: function(dialogRef){ dialogRef.close(); } }],
								});
								dataTable1.ajax.reload( null, false );
								dialog.close();
								window.history.back(); 
							},
							error: function(data) {
								if (data.status==500){
									var message = data.statusText;
								} else {
									var error = JSON.parse(data.responseText);
									var message = error.message;
								}
								button.stopSpin();
								button.enable();
								BootstrapDialog.show({ closable: false, type:'modal-danger', title:'Notification', message:message, 
									buttons: [{ label: 'OK', hotkey: 13, action: function(dialogRef){ dialogRef.close(); window.history.back(); } }],
								});
							}
						});
					}
				}
			}, {
				label: 'Cancel', cssClass: 'btn-danger', action: function(dialog) { dialog.close(); window.history.back(); }
			}],
			onshown: function(dialog) {
				{* /* This class is for auto conversion from dmy to ymd */ *}
				$(".auto_ymd").on('change', function(){
					$('input[name="'+$(this).attr('id')+'"]').val( datetime_db_format($(this).val(), $(this).attr('data-format')) );
				}).trigger('change');
			}
		});
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
