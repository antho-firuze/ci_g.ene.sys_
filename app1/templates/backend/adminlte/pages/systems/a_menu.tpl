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
	{* Get Params *}
	var $q = getURLParameter("q"), $id = getURLParameter("id");
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
		aRBtn: [],
		aRBtn_width: '100px',
		order: ['grp', 'is_parent desc', 'line_no'],
		columns: [
			{ width:"150px", orderable:false, data:"name", title:"Name" },
			{ width:"150px", orderable:false, data:"title", title:"Title" },
			{ width:"200px", orderable:false, data:"title_desc", title:"Description" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"is_parent", title:"Parent", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"line_no", title:"Line", render:function(data, type, row){ return '<input type="number" class="line_no" style="width:50px; text-align:center;" value="'+data+'">'; } },
			{ width:"100px", orderable:false, data:"icon", title:"Icon" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Type", render:function(data, type, row){ return (data=='F') ? 'FORM' : (data=='P') ? 'PROCESS' : (data=='W') ? 'WINDOW' : 'GROUP'; } },
			{ width:"125px", orderable:false, data:"path", title:"Path" },
			{ width:"100px", orderable:false, data:"class", title:"Class" },
			{ width:"120px", orderable:false, data:"method", title:"Method" },
			{ width:"120px", orderable:false, data:"table", title:"Table" },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
<script>

	$('.dataTables_wrapper').find('tbody').on('keypress', '.line_no', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
	{* $('.line_no').on('keypress', function(e){ *}
		console.log($(this).val());
	});
	
</script>
