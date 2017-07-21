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
<script src="{$.const.TEMPLATE_URL}plugins/accounting/accounting.min.js"></script>
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
	var format_currency = function(money){ return accounting.formatMoney(money, '', {$.session.number_digit_decimal}, "{$.session.group_symbol}", "{$.session.decimal_symbol}") };
	var DataTable_Init = {
		enable: true,
		tableWidth: '110%',
		act_menu: { copy: true, edit: true, delete: true },
		add_menu: [
			{ name: 'update_so_etd', title: 'Update SO ETD' }, 
		],
		{* add_menu: [ *}
			{* { pageid: 127, subKey: 'order_id', title: 'Update ETD' }, *}
		{* ], *}
		sub_menu: [
			{ pageid: 99, subKey: 'order_id', title: 'Order Line', },
			{ pageid: 100, subKey: 'order_id', title: 'Order Plan' },
			{* { pageid: 127, subKey: 'order_id', title: 'Update ETD' }, *}
		],
		columns: [
			{ width:"100px", orderable:false, data:"doc_no", title:"Doc No" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"etd", title:"ETD" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"expected_dt_cust", title:"Expected DT Customer" },
			{ width:"150px", orderable:false, data:"bpartner_name", title:"Customer" },
			{ width:"200px", orderable:false, data:"description", title:"Description" },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"sub_total", title:"Sub Total", render: function(data, type, row){ return format_currency(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"vat_total", title:"VAT Total", render: function(data, type, row){ return format_currency(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"grand_total", title:"Grand Total", render: function(data, type, row){ return format_currency(data); } },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-right", data:"plan_total", title:"Plan Total", render: function(data, type, row){ return format_currency(data); } },
			{* { width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } }, *}
		],
	};
	
	
	{* Update SO ETD *}
	function update_so_etd(data) {
		console.log(data);
		var msg_body = subRow(), col = [], a = [];
		col.push("<h3>Sales Order : "+data.doc_no+"</h3>");
		col.push("<br>");
		a.push(BSHelper.LineDesc({ label:"Doc Date", value: data.doc_date }));
		a.push(BSHelper.LineDesc({ label:"Customer", value: data.bpartner_name }));
		a.push(BSHelper.LineDesc({ label:"Reference No", value: data.doc_ref_no }));
		a.push(BSHelper.LineDesc({ label:"Reference Date", value: data.doc_ref_date }));
		a.push(BSHelper.LineDesc({ label:"Expected DT Customer", value: data.expected_dt_cust }));
		col.push( $('<dl class="dl-horizontal">').append(a) ); a = [];
		{* col.push( "<center><h2><span>"+accounting.formatMoney(sell_price, '', 2, ".", ",")+"/PCS</span></h2></center>" ); *}
		msg_body.append( subCol(12, col ) );
		BootstrapDialog.show({ title: 'Update SO ETD', type: BootstrapDialog.TYPE_DANGER, message: msg_body,
			buttons: [{
				{* icon: 'glyphicon glyphicon-send', *}
				{* cssClass: 'btn-danger', *}
				label: 'Submit',
				action: function(dialog) {
					var button = this;
					button.spin();
					
					$.ajax({ url: '{$.php.base_url('systems/a_loginattempt')}', method: "OPTIONS", async: true, dataType: 'json',
						data: JSON.stringify({ loginattempt:1, id:ids.join() }),
						success: function(data) {
							dialog.close();
							dataTable1.ajax.reload( null, false );
							BootstrapDialog.alert(data.message);
						},
						error: function(data) {
							if (data.status==500){
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
				label: 'Cancel', action: function(dialog) { dialog.close(); }
			}],
			onshown: function(dialog) {
				{**}
			}
		});
		return false;
		
		if (!confirm("{$.php.lang('confirm_rla')}")) {
			return false;
		}
		$.ajax({ url: '{$.php.base_url('systems/a_loginattempt')}', method: "OPTIONS", async: true, dataType: 'json',
			data: JSON.stringify({ loginattempt:1, id:data.id }),
			success: function(data) {
				BootstrapDialog.alert(data.message);
			},
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
			}
		});
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
