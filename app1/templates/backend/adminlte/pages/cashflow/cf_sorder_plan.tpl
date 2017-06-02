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
		sub_menu: [
			{* { pageid: 99, subKey: 'order_id', title: 'Order Line', }, *}
			{* { pageid: 100, subKey: 'order_id', title: 'Order Plan' }, *}
		],
		columns: [
			{ width:"25px", orderable:false, data:"seq", title:"Line" },
			{ width:"100px", orderable:false, data:"doc_date", title:"Doc Date" },
			{ width:"100px", orderable:false, data:"amount", title:"Amount" },
			{ width:"250px", orderable:false, data:"note", title:"Note" },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
