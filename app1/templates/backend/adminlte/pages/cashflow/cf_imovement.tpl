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
		disableBtn: ['btn-copy','btn-message','btn-print','btn-process'],
		hiddenBtn: ['btn-copy','btn-message'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	{* DataTable Init *}
	var DataTable_Init = {
		enable: true,
		tableWidth: '125%',
		act_menu: { copy: false, edit: true, delete: true },
		sub_menu: [
			{ pageid: 190, subKey: 'movement_id', title: 'Inbound Line', },
		],
		order: ['id desc'],
		columns: [
			{ width:"100px", orderable:false, data:"org_name", title:"From Org Name" },
			{ width:"100px", orderable:false, data:"orgtrx_name", title:"From OrgTrx Name" },
			{ width:"100px", orderable:false, data:"doc_no", title:"Outbound No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"delivery_date", title:"Delivery Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"received_date", title:"Received Date" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
		],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
