<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Main content -->
	<section class="content">
		<!-- /.row -->
		<div class="box box-body table-responsive no-padding"></div>
		<!-- /.box -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $table = "{$table}", $title = "{$title}", $title_desc = "{$title_desc}";
	{* Toolbar Init *}
	var Toolbar_Init = {
		enable: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-import','btn-process'],
		hiddenBtn: ['btn-copy','btn-message','btn-print','btn-import'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		aLBtn: { copy: true, edit: true, delete: true },
		aRBtn: [
			{ pageid: 36, subKey: 'role_id', title: 'Menu Access', },
		],
		aRBtn_width: '100px',
		columns: [
			{ width:"130px", orderable:false, data:"code_name", title:"Name" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"is_canexport", title:"Can Export", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"is_canreport", title:"Can Report", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"is_canapproveowndoc", title:"Can Approve", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"is_changelog", title:"Change Log", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
		],
	};

</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
