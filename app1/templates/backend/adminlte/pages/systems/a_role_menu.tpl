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
		processMenu: [{ id:"btn-process1", pageid: 45, title:"Copy Menu From Role..." }, ],
		processMenuDisable: [],
	};
	if ("{$is_canimport}" == "0") Toolbar_Init.disableBtn.push('btn-import');
	if ("{$is_canexport}" == "0") Toolbar_Init.disableBtn.push('btn-export');
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		act_menu: { copy: false, edit: true, delete: true },
		sub_menu: [],
		order: ['id desc'],
		columns: [
			{ width:"150px", orderable:false, data:"code_name", title:"Menu" },
			{ width:"55px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Type", render:function(data, type, row){ return (data=='F') ? 'FORM' : (data=='P') ? 'PROCESS' : (data=='W') ? 'WINDOW' : 'GROUP'; } },
			{ width:"150px", orderable:false, data:"parent_name", title:"Parent Name" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Allow", 
				render:function(data, type, row){ 
					if (row.type == 'W'){
						switch(row.permit_window){ 
							case '1':return 'Create';break; 
							case '2':return 'Edit';break; 
							case '3':return 'Delete';break; 
							case '4':return 'Create & Edit';break; 
							case '5':return 'Create & Delete';break; 
							case '6':return 'Edit & Delete';break; 
							case '7':return 'Can All';break; 
							default:return 'Not Allow'; 
						}; 
					} else if (row.type == 'F'){
						switch(row.permit_form){ 
							case '1':return 'Execute';break; 
							default:return 'Not Allow'; 
						}; 
					} else if (row.type == 'P'){
						switch(row.permit_process){ 
							case '1':return 'Execute';break; 
							default:return 'Not Allow'; 
						}; 
					} else {
						return ''
					}
				} 
			},
		],
	};
	{* btn-process1 in Toolbar *}
	$(document.body).click('button', function(e){
		switch($(e.target).attr('id')){
			case 'btn-process1':
				if (!confirm("All Menu in this Role will be replaced, Are you sure ?")) {
					return false;
				}
				var $pageid = getURLParameter("pageid"), $filter = getURLParameter("filter");
				$pageid = "?pageid="+$pageid+","+$(e.target).attr("data-pageid");
				$filter = $filter ? "&filter="+$filter : "";
				window.location.href = getURLOrigin()+$pageid+$filter+"&action=prc";
				break;
		}
	});	
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
