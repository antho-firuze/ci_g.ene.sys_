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
		act_menu: { copy: true, edit: true, delete: true },
		sub_menu: [
			{ pageid: 108, subKey: 'request_id', title: 'Request Line', },
		],
		columns: [
			{ width:"100px", orderable:false, data:"org_name", title:"Org Name" },
			{ width:"100px", orderable:false, data:"orgtrx_name", title:"Org Trx Name" },
			{ width:"100px", orderable:false, data:"bpartner_name", title:"Business Partner" },
			{ width:"100px", orderable:false, data:"residence", title:"Residence" },
			{ width:"100px", orderable:false, data:"doc_no", title:"Request No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date", title:"Request Date" },
			{ width:"100px", orderable:false, data:"doc_no_order", title:"SO No" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"doc_date_order", title:"SO Date" },
			{ width:"50px", orderable:false, className:"dt-head-center dt-body-center", data:"eta", title:"Request ETA" },
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"estimate_late", title:"Awating Requisition (Days)", 
				render: function(data, type, row){ 
					if ( parseInt(data) > 0 && parseInt(data) <= 7 ) 
						return $("<span>").addClass('label label-warning').text(data).prop('outerHTML');
					else if ( parseInt(data) > 7 ) 
						return $("<span>").addClass('label label-danger').text(data).prop('outerHTML'); 
					else 
						return $("<span>").addClass('label label-success').text(data).prop('outerHTML'); 
				},
			},
			{ width:"50px", orderable:true, className:"dt-head-center dt-body-center", data:"late", title:"Exceed ETA (Days)", 
				render: function(data, type, row){ 
					if ( parseInt(data) > 0 && parseInt(data) <= 7 ) 
						return $("<span>").addClass('label label-warning').text(data).prop('outerHTML');
					else if ( parseInt(data) > 7 ) 
						return $("<span>").addClass('label label-danger').text(data).prop('outerHTML'); 
					else 
						return $("<span>").addClass('label label-success').text(data).prop('outerHTML'); 
				},
			},
			{ width:"100px", orderable:false, data:"request_type_name", title:"Request Purposes" },
			{ width:"100px", orderable:false, data:"category_name", title:"Category" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
		],
		order: ['id desc'],
	};
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
