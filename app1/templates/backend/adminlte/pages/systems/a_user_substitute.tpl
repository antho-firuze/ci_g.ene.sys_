{var $url_module = $.php.base_url('systems/a_user_substitute')}
{var $url_module_main = $.php.base_url('systems/a_user')}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {$window_title}
        <small>{$description}</small>
      </h1>
    </section>

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
<script>
	{* Section 1: For parsing URL Parameters *}
	var origin_url = window.location.origin+window.location.pathname;
	var $param = {}, $id, $q;
	
	{* Set master key info to Page Title *}
	var user_id = getURLParameter("user_id");
	$.getJSON('{$url_module_main}', { "id": (user_id==null)?-1:user_id }, function(result){ 
		if (!isempty_obj(result.data.rows)) {
			var code_name = ": "+result.data.rows[0].code_name;
			$('.content-header').find('h1').find('small').before(code_name);
		}
	});

	{* Section 2: For building Datatables *}
	var aLBtn = [];
	{* aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-info glyphicon glyphicon-duplicate" title="Copy" name="btn-copy" />'); *}
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
			"url": '{$url_module}'+window.location.search+"&user_id="+user_id+"&ob=id desc",
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
			{ width:"250px", orderable:false, data:"code_name", title:"Substitute" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
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

	{* AVAILABLE BUTTON LIST ['btn-copy','btn-new','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-process'] *}
	setDisableToolBtn(['btn-copy','btn-message','btn-print','btn-export','btn-import']);
	setVisibleToolBtn(['btn-copy','btn-message','btn-print','btn-export','btn-import']);
	
	{* Additional Menu on Toolbar Process Button *}

	{* =================================================================================== *}
	
	{* For class aLBtn : btn-copy in DataTable *}
	tableData1.find('tbody').on( 'click', '[name="btn-copy"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		if (!confirm("Copy this data ?")) {
			return false;
		}
		
		window.location.href = getURLOrigin()+window.location.search+"&edit=3&id="+data.id;
	});
	
	{* For class aLBtn : btn-edit in DataTable *}
	tableData1.find('tbody').on( 'click', '[name="btn-edit"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		window.location.href = getURLOrigin()+window.location.search+"&edit=1&id="+data.id;
	});
	
	{* For class aLBtn : btn-delete in DataTable *}
	tableData1.find('tbody').on( 'click', '[name="btn-delete"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		if (!confirm("Are you sure want to delete this record ?")) {
			return false;
		}
		
		$.ajax({ url: '{$url_module ~ "?id="}'+data.id, method: "DELETE", async: true, dataType: 'json',
			success: function(data) {
				dataTable1.ajax.reload( null, false );
				Lobibox.notify('info', { msg: data.message });
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
	});
	
	{* For class aRBtn *}
	tableData1.find('tbody').on( 'click', '.aRBtn', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		var pageid = $(this).data('pageid');
		var url = "{$.php.base_url('systems/x_page?pageid=')}"+pageid+"&user_id="+data.id;
		window.location.href = url;
	});
	
	{* btn-new in Toolbar *}
	$('#btn-new').click(function(){
		window.location.href = getURLOrigin()+window.location.search+"&edit=2";
	});
	
	{* btn-refresh in Toolbar *}
	$('#btn-refresh').click(function(){
		dataTable1.ajax.reload( null, false );
	});
	
	{* btn-delete in Toolbar *}
	$('#btn-delete').click(function(){
		var data = dataTable1.rows('.selected').data();
		
		if (data.count() < 1)
			return false;

		var tblConfirm = BSHelper.Table({
				data: data,	rowno: true, showheader: true, maxrows: 3, isConfirm: true,
				columns:[
					{ data:"code_name"					,title:"Name" },
				],
			});
			
		var ids = [];
		$.each(data, function(i){	ids[i] = data[i]['id'];	});
		BootstrapDialog.show({ title: 'Delete Record/s', type: BootstrapDialog.TYPE_DANGER, message: tblConfirm,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-danger',
				label: '&nbsp;&nbsp;Delete',
				action: function(dialog) {
					var button = this;
					button.spin();
					
					$.ajax({ url: '{$url_module ~ "?id="}'+ids.join(), method: "DELETE", async: true, dataType: 'json',
						success: function(data) {
							dialog.close();
							dataTable1.ajax.reload( null, false );
							Lobibox.notify('info', { msg: data.message });
						},
						error: function(data) {
							if (data.status==500){
								var message = data.statusText;
							} else {
								var error = JSON.parse(data.responseText);
								var message = error.message;
							}
							button.stopSpin();
							dialog.enableButtons(true);
							dialog.setClosable(true);
							BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
						}
					});
				}
			}, {
					label: 'Close',
					action: function(dialog) { dialog.close(); }
			}],
			onshown: function(dialog) {
				{**}
			}
		});
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
