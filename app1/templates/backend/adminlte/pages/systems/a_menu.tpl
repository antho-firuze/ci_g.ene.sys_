{var $url_module = $.php.base_url('systems/a_menu')}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div id="toolbar" class="col-lg-12"></div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
			<div class="box box-body table-responsive no-padding"></div>
          <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="{$.const.ASSET_URL}js/form_view.js"></script>
<script>
	{* Section 1: For parsing URL Parameters *}
	var $url_module = "{$url_module}";
	var origin_url = window.location.origin+window.location.pathname;
	var $param = {}, $id, $q;
	{* Start :: Init for Title, Breadcrumb *}
	$(".content").before(BSHelper.PageHeader({ 
		title:"{$window_title}", 
		title_desc:"{$description}", 
		bc_list:[
			{ icon:"fa fa-dashboard", title:"Dashboard", link:"{$.const.APPS_LNK}" },
			{ icon:"", title:"{$window_title}", link:"" },
		]
	}));
	{* End :: Init for Title, Breadcrumb *}
	
	{* Section 2: For building Datatables *}
	var aLBtn = [];
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-info glyphicon glyphicon-duplicate" title="Copy" name="btn-copy" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-success glyphicon glyphicon-edit" title="Edit" name="btn-edit" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-danger glyphicon glyphicon-trash" title="Delete" name="btn-delete" />');
	var aRBtn = [];
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=31>Role</a></span>');
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=32>Org</a></span>');
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=33>Subs</a></span>');
	var tableData1 = $('<table class="table table-bordered table-hover table-striped" style="table-layout:fixed; word-wrap:break-word; margin:0px !important;" />').appendTo( $('.box-body') ),
	dataTable1 = tableData1.DataTable({
		"pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true, 
		"ajax": {
			"url": '{$url_module}'+window.location.search+'&ob=id desc',
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
			{ width:"200px", orderable:false, data:"name", title:"Name" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"45px", orderable:false, className:"dt-head-center dt-body-center", data:"is_parent", title:"Parent", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ width:"100px", orderable:false, data:"icon", title:"Icon" },
			{ width:"110px", orderable:false, data:"url", title:"Table" },
			{ width:"125px", orderable:false, data:"path", title:"Path" },
			{ width:"100px", orderable:false, data:"class", title:"Class" },
			{ width:"110px", orderable:false, data:"method", title:"Method" },
		],
		"order": []
	})
	.search($q ? $q : '');
	
	{* Don't change this code: Re-coding dataTables search method *}
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		$q = $(this).val();
		$url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		history.pushState({}, '', origin_url +'?'+ $url);
	});		
	
	DTHelper.initCheckList(tableData1, dataTable1);
	
	{* This line for changing toolbar button *}
	$('#toolbar').append( setToolbarButton() ).css('margin-bottom','10px');
	$('div.box').css('margin-bottom','10px');
	$('div.dataTables_wrapper').find('div.row:first').insertBefore('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_filter');
	$('div.dataTables_wrapper').find('div.row:last').insertAfter('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_paginate');
	{* $('div.dataTables_wrapper').find('div.dataTables_paginate ul.pagination').before($('<button type="button"><i class="fa fa-info"></i>ii</button>')); *}
	$('div.dataTables_wrapper').find('ul.pagination').before("testing");

	{* AVAILABLE BUTTON LIST ['btn-copy','btn-new','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-process'] *}
	setDisableToolBtn(['btn-copy','btn-message','btn-print','btn-export','btn-import']);
	setHideToolBtn(['btn-copy','btn-message','btn-print','btn-export','btn-import']);
	
	{* Additional Menu on Toolbar Process Button *}
	
	{* ====================================== *}
	
	{* For class aRBtn *}
	tableData1.find('tbody').on( 'click', '.aRBtn', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		var pageid = $(this).data('pageid');
		var url = "{$.php.base_url('systems/x_page?pageid=')}"+pageid+"&user_id="+data.id;
		window.location.href = url;
	});
	
	{* btn-message in Toolbar *}
	$('#btn-message').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-print in Toolbar *}
	$('#btn-print').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-export in Toolbar *}
	$('#btn-export').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-import in Toolbar *}
	$('#btn-import').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
</script>
