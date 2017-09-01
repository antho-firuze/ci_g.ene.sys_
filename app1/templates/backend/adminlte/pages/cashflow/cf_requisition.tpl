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
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		tableWidth: '125%',
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [
			{ pageid: 109, subKey: 'requisition_id', title: 'Requisition Line', },
		],
		columns: [
			{ width:"100px", orderable:false, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:false, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:false, data:"doc_no", title:"Doc No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"eta", title:"ETA" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"eta_status", title:"ETA STATUS" },
			{ width:"100px", orderable:false, data:"doc_no_request", title:"Req Doc No" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date_request", title:"Req Doc Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"eta_request", title:"Req ETA" },
			{ width:"100px", orderable:false, data:"bpartner_name", title:"Customer" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
		],
		order: ['id desc'],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
