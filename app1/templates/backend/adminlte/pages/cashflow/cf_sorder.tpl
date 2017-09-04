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
<script src="{$.const.TEMPLATE_URL}plugins/bootstrap-validator/validator.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.date.extensions.js"></script>
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/jquery.inputmask.js"></script>
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-process'],
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
		{* order: ['doc_no'], *}
		columns: [
			{ width:"100px", orderable:false, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:false, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:true, data:"doc_no", title:"Doc No" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"etd", title:"ETD" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"expected_dt_cust", title:"Expected DT Customer" },
			{ width:"150px", orderable:false, data:"bpartner_name", title:"Customer" },
			{ width:"200px", orderable:false, data:"description", title:"Description" },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"sub_total", title:"Sub Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"vat_total", title:"VAT Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"grand_total", title:"Grand Total", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"plan_total", title:"Plan Total", render: function(data, type, row){ return format_money(data); } },
			{* { width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } }, *}
		],
	};
	
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
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.find("[data-mask]").inputmask();
		form1.on('submit', function(e){ e.preventDefault(); });
		
		BootstrapDialog.show({
			title: 'Update SO ETD', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_SMALL, message: form1, 
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
