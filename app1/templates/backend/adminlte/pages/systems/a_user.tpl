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
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)};
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-import'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Batch Reset Login Attempt" }, ],
		processMenuDisable: [],
	};
	if ("{$is_canimport}" == "0") Toolbar_Init.disableBtn.push('btn-import');
	if ("{$is_canexport}" == "0") Toolbar_Init.disableBtn.push('btn-export');
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		width: '120%',
		act_menu: { copy: true, edit: true, delete: true },
		add_menu: [
			{ name: 'reset_login_attempt', title: 'Reset Login Attempt' }, 
			{ name: 'create_api_key', title: 'Create API Key' }, 
		],
		sub_menu: [
			{ pageid: 31, subKey: 'user_id', title: 'Role Access', },
			{ pageid: 32, subKey: 'user_id', title: 'Organization' },
			{ pageid: 33, subKey: 'user_id', title: 'Substitute' },
		],
		order: ['is_online desc'],
		columns: [
			{ width:"130px", orderable:true, data:"name", title:"Name", render:function(data, type, row){ return ( row.is_online == '1' ? '<i class="fa fa-circle text-green" title="Online"></i>' : row.is_online == '2' ? '<i class="fa fa-circle text-gray" title="Idle"></i>' : '<i class="fa fa-circle text-red" title="Offline"></i>' )+' '+data; } },
			{ width:"150px", orderable:true, data:"email", title:"Email" },
			{ width:"250px", orderable:true, data:"description", title:"Description" },
			{ width:"250px", orderable:true, data:"api_token", title:"API Key" },
			{ width:"40px", orderable:true, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
		],
	};
	
	function reset_login_attempt(data) {
		if (!confirm("{$.php.lang('confirm_rla')}")) {
			return false;
		}
		$.ajax({ url: '{$.php.base_url('systems/a_user_reset_login_attempt')}', method: "OPTIONS", async: true, dataType: 'json',
			data: JSON.stringify({ id:data.id }),
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
	
	function create_api_key(data) {
		if (!confirm("{$.php.lang('confirm_create_api_key')}")) {
			return false;
		}
		$.ajax({ url: '{$.php.base_url('systems/a_user_create_api_key')}', method: "OPTIONS", async: true, dataType: 'json',
			data: JSON.stringify({ id:data.id }),
			success: function(data) {
				BootstrapDialog.alert(data.message);
				dataTable1.ajax.reload( null, false );
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
	
	{* btn-process1 in Toolbar *}
	$(document.body).click('button', function(e){
		{* switch($(e.target).attr('id')){ *}
		if ($(e.target).attr('id') == 'btn-process1'){
			var data = dataTable1.rows('.selected').data();
			
			if (data.count() < 1){
				BootstrapDialog.alert('Please chosed the record !');
				return false;
			}
			var ids = [];
			$.each(data, function(i){	ids[i] = data[i]['id'];	});

			var tblConfirm = BSHelper.Table({ data: data,	rowno: true, showheader: true, maxrows: 3, isConfirm: true, title: "<h4>Are you sure want to process this selected user/s ?</h4>" });
			BootstrapDialog.show({ title: 'Reset Login Attempt', type: BootstrapDialog.TYPE_DANGER, message: tblConfirm,
				buttons: [{
					icon: 'glyphicon glyphicon-send',
					cssClass: 'btn-danger',
					label: '&nbsp;&nbsp;Delete',
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
						label: 'Close',
						action: function(dialog) { dialog.close(); }
				}],
				onshown: function(dialog) {
					{**}
				}
			});
		}
	});	

</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
