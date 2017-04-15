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
	var $url_module = "{$.php.base_url()~$class~'/'~$method}", $title = "{$title}", $title_desc = "{$title_desc}";
	{* Get Params *}
	var $q = getURLParameter("q"), $id = getURLParameter("id");
	{* Toolbar Init *}
	var Toolbar_Init = {
		toolbar: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-import','btn-process'],
		hiddenBtn: ['btn-copy','btn-message','btn-print','btn-import'],
		processMenu: [{ id:"btn-process1", title:"Process 1" }, { id:"btn-process2", title:"Process 2" }, ],
		processMenuDisable: ['btn-process1'],
	};
	{* Defining Left Button for Datatables *}
	var aLBtn = [];
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-info glyphicon glyphicon-duplicate" title="Copy" name="btn-copy" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-success glyphicon glyphicon-edit" title="Edit" name="btn-edit" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-danger glyphicon glyphicon-trash" title="Delete" name="btn-delete" />');
	{* Defining Right Button for Datatables *}
	var aRBtn = [];
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=31>Role</a></span>');
	var tableData1 = $('<table class="table table-bordered table-hover table-striped" style="table-layout:fixed; word-wrap:break-word; margin:0px !important;" />').appendTo( $('.box-body') ),
	{* Setup DataTables *}
	dataTable1 = tableData1.DataTable({ "pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true, 
		"ajax": {
			"url": $url_module+window.location.search+'&ob=id desc',
			"data": function(d){ return $.extend({}, d, { "q": $q });	},
			"dataFilter": function(data){
				var json = jQuery.parseJSON( data );
				json.recordsTotal = json.data.total;
				json.recordsFiltered = json.data.total;
				json.data = json.data.rows;
				return JSON.stringify( json ); 
			}
		},
		"columns": [
			{ width:"20px", orderable:false, className:"dt-body-center", title:"<center><input type='checkbox' class='head-check'></center>", render:function(data, type, row){ return '<input type="checkbox" class="line-check">'; } },
			{ width:"90px", orderable:false, className:"dt-head-center dt-body-center", title:"Actions", render: function(data, type, row){ return aLBtn.join(""); } },
			{ width:"150px", orderable:false, data:"name", title:"Name" },
			{ width:"150px", orderable:false, data:"title", title:"Title" },
			{ width:"200px", orderable:false, data:"title_desc", title:"Description" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"is_parent", title:"Parent", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"100px", orderable:false, data:"icon", title:"Icon" },
			{ width:"60px", orderable:false, className:"dt-head-center dt-body-center", data:"type", title:"Type", render:function(data, type, row){ return (data=='F') ? 'FORM' : (data=='P') ? 'PROCESS' : (data=='W') ? 'WINDOW' : 'GROUP'; } },
			{ width:"125px", orderable:false, data:"path", title:"Path" },
			{ width:"100px", orderable:false, data:"class", title:"Class" },
			{ width:"120px", orderable:false, data:"method", title:"Method" },
			{ width:"120px", orderable:false, data:"table", title:"Table" },
		],
		"order": []
	})
	.search($q ? $q : '');
	
</script>
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
