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
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $bread = {$.php.json_encode($bread)}, $is_submodule = "{$is_submodule}";
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-process'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"btn-process1" }, ],
		processMenuDisable: [],
	};
	if ("{$is_canimport}" == "0") Toolbar_Init.disableBtn.push('btn-import');
	if ("{$is_canexport}" == "0") Toolbar_Init.disableBtn.push('btn-export');
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		act_menu: { copy: false, edit: true, delete: true },
		add_menu: [
			{ name: 'set_default', title: 'Set As Default' }, 
		],
		sub_menu: [
			{ pageid: 104, subKey: 'parent_id', title: 'Location/Branch', subType: 'hierarchy' },
		],
		order: ['id desc'],
		columns: [
			{ width:"100px", orderable:false, data:"user_name", title:"User" },
			{ width:"250px", orderable:false, data:"code_name", title:"Organization" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_default", title:"Default", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
		],
	};
		
	function set_default(data){
		$.ajax({ url: $url_module, method: "PUT", async: true, dataType: 'json',
			data: JSON.stringify({ set_default:1, user_id:data.user_id, org_id:data.org_id }),
			success: function(data) {
				BootstrapDialog.show({ closable: false, message:data.message, 
					buttons: [{ label: 'OK', hotkey: 13, action: function(dialogRef){ dialogRef.close(); } }],
				});
				dataTable1.ajax.reload( null, false );
			},
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				BootstrapDialog.show({ closable: false, type:'modal-danger', title:'Notification', message:message, 
					buttons: [{ label: 'OK', hotkey: 13, action: function(dialogRef){ dialogRef.close(); } }],
				});
			}
		});
	}
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
