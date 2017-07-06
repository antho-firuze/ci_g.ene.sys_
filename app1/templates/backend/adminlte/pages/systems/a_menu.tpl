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
		disableBtn: ['btn-copy','btn-message','btn-process'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	if ("{$is_canimport}" == "0") Toolbar_Init.disableBtn.push('btn-import');
	if ("{$is_canexport}" == "0") Toolbar_Init.disableBtn.push('btn-export');
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [],
		order: ['grp', 'is_parent desc', 'is_submodule', 'line_no'],
		columns: [
			{ width:"150px", orderable:false, data:"code_name", title:"Name" },
			{ width:"200px", orderable:false, data:"title_desc", title:"Description" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"is_parent", title:"Parent", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"line_no", title:"Line", render:function(data, type, row){ return '<input type="number" class="line_no" style="width:50px; text-align:center;" value="'+data+'">'; } },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"is_submodule", title:"Sub", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{* { width:"100px", orderable:false, data:"icon", title:"Icon" }, *}
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Type", render:function(data, type, row){ return (data=='F') ? 'FORM' : (data=='P') ? 'PROCESS' : (data=='W') ? 'WINDOW' : 'GROUP'; } },
			{ width:"150px", orderable:false, data:"parent_name", title:"Parent" },
			{ width:"125px", orderable:false, data:"path", title:"Path" },
			{ width:"100px", orderable:false, data:"class", title:"Class" },
			{ width:"120px", orderable:false, data:"method", title:"Method" },
			{ width:"120px", orderable:false, data:"table", title:"Table" },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
<script>

	$('.dataTables_wrapper').find('tbody').on('keypress keyup', '.line_no', function (e) {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		var newLine = parseInt($(this).val());
		
		{* TAB || ESC *}
		if (e.keyCode == 9 || e.keyCode == 27){	
			console.log(data.line_no);
			$(this).val(data.line_no);
			return false;
		}
		
		if (e.keyCode == 13 && e.type == 'keypress'){
			if (data.line_no == newLine)
				return false;
				
			$.extend(data, { 'newline':newLine });
			$.ajax({ method: 'PUT', url: $url_module, data: JSON.stringify(data), dataType: 'json',
				success: function(data){
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
		}
	});
	
</script>
