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
<script src="{$.const.TEMPLATE_URL}plugins/inputmask/inputmask.numeric.extensions.js"></script>
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
		tableWidth: '125%',
		act_menu: { copy: true, edit: true, delete: true },
		add_menu: [
			{ name: 'actualization', title: 'Actualization' }, 
			{ name: 'adjust_amount', title: 'Adjust Amount' }, 
		],
		sub_menu: [],
		columns: [
			{ width:"100px", orderable:false, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:false, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:false, data:"invoice_status", title:"Status" },
			{ width:"100px", orderable:false, data:"doc_no", title:"Invoice No" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"invoice_plan_date", title:"Invoice Plan Date" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Invoice Date" },
			{ width:"100px", orderable:false, data:"doc_no_order", title:"SO Doc No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date_order", title:"SO Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"etd_order", title:"SO ETD" },
			{ width:"100px", orderable:false, data:"doc_ref_no_order", title:"PO Customer" },
			{ width:"150px", orderable:false, data:"bpartner_name", title:"Customer" },
			{ width:"200px", orderable:false, data:"note", title:"Note" },
			{ width:"200px", orderable:false, data:"description", title:"Description" },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"amount", title:"Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"adj_amount", title:"Adj Amount", render: function(data, type, row){ return format_money(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"net_amount", title:"Net Amount", render: function(data, type, row){ return format_money(data); } },
		],
		order: ['id desc'],
	};
	
	function actualization(data) {
		var col = [], row = [], a = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		var format_money2 = "'alias': 'currency', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'autoGroup': true, 'autoUnmask': true";
		col.push("<h3>Sales Order : <br>"+data.doc_no_order+"</h3>");
		col.push("<h3>Business Partner : <br>"+data.bpartner_name+"</h3>");
		col.push("<h3>Invoice Plan Date : <br>"+data.invoice_plan_date+"</h3>");
		col.push( $('<dl class="dl-horizontal">').append(a) ); a = [];
		col.push(BSHelper.Input({ horz:false, type:"text", label:"Actual Invoice No", idname:"doc_no", format: "'casing': 'upper'", value: data.doc_no, required: true }));
		col.push(BSHelper.Input({ horz:false, type:"date", label:"Invoice date", idname:"doc_date", cls:"auto_ymd", format:"{$.session.date_format}", value: data.doc_date, required: true }));
		col.push(BSHelper.Input({ horz:false, type:"date", label:"Received Plan date", idname:"received_plan_date", cls:"auto_ymd", format:"{$.session.date_format}", value: data.received_plan_date, required: true }));
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.find("[data-mask]").inputmask();
		form1.on('submit', function(e){ e.preventDefault(); });
		
		BootstrapDialog.show({
			title: 'Invoice Actualization', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_MEDIUM, message: form1, 
			buttons:[{ 
				cssClass: 'btn-primary', label: 'Submit', hotkey: 13, action: function(dialog) {
					var button = this;
					
					if (form1.validator('validate').has('.has-error').length === 0) {
						button.spin();
						button.disable();
						
						form1.append(BSHelper.Input({ type:"hidden", idname:"id", value:data.id }));
						
						{* console.log(form1.serializeJSON()); return false; *}
						
						$.ajax({ url: $url_module+'_actualization', method: "OPTIONS", async: true, dataType: 'json',	data: form1.serializeJSON(),
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
	
	function adjust_amount(data) {
	
		function calculate_amount(){ 
			$("#net_amount").val( parseFloat($("#amount").val()) + parseFloat($("#adj_amount").val()) );
			$(".auto_ymd").trigger('change');
			form1.validator('update').validator('validate');
		}

		var col = [], row = [], a = [];
		var form1 = BSHelper.Form({ autocomplete:"off" });
		var format_money2 = "'alias': 'currency', 'prefix': '', 'groupSeparator': '{$.session.group_symbol}', 'radixPoint': '{$.session.decimal_symbol}', 'digits': {$.session.number_digit_decimal}, 'negationSymbol': { 'front':'-', 'back':'' }, 'autoGroup': true, 'autoUnmask': true";
		col.push("<h3>Invoice No : <br>"+data.doc_no+"</h3>");
		col.push("<h3>Sales Order : <br>"+data.doc_no_order+"</h3>");
		col.push("<h3>Business Partner : <br>"+data.bpartner_name+"</h3>");
		col.push( $('<dl class="dl-horizontal">').append(a) ); a = [];
		col.push(BSHelper.Input({ horz:false, type:"number", label:"Amount", idname:"amount", style: "text-align: right;", step: ".01", required: false, value: data.amount, placeholder: "0.00", readonly: true, hidden: true }));
		col.push(BSHelper.Input({ horz:false, type:"number", label:"Adjustment Amount", idname:"adj_amount", style: "text-align: right;", step: ".01", required: false, value: data.adj_amount, placeholder: "0.00", }));
		col.push(BSHelper.Input({ horz:false, type:"text", label:"Net Amount", idname:"net_amount", style: "text-align: right;", format: format_money2, required: false, value: data.net_amount, readonly: true, placeholder: "0.00", }));
		row.push(subCol(12, col)); col = [];
		form1.append(subRow(row));
		
		form1.find("[data-mask]").inputmask();
		form1.on('submit', function(e){ e.preventDefault(); });
		calculate_amount();
		
		$(document).on("change", function(e){	if ($(e.target).is("#adj_amount")) calculate_amount(); });
		
		BootstrapDialog.show({
			title: 'Invoice Adjustment Amount', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_MEDIUM, message: form1, 
			buttons:[{ 
				cssClass: 'btn-primary', label: 'Submit', hotkey: 13, action: function(dialog) {
					var button = this;
					
					if (form1.validator('validate').has('.has-error').length === 0) {
						button.spin();
						button.disable();
						
						form1.append(BSHelper.Input({ type:"hidden", idname:"id", value:data.id }));
						
						{* console.log(form1.serializeJSON()); return false; *}

						$.ajax({ url: $url_module+'_adjustment', method: "OPTIONS", async: true, dataType: 'json',	data: form1.serializeJSON(),
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
