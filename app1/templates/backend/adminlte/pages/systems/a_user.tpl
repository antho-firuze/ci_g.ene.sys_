{var $url_module = $.php.base_url('systems/a_user')}

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
	
	{* Section 2: For building Datatables *}
	var aLBtn = [];
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-info glyphicon glyphicon-duplicate" title="Copy" name="btn-copy" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-success glyphicon glyphicon-edit" title="Edit" name="btn-edit" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-danger glyphicon glyphicon-trash" title="Delete" name="btn-delete" />');
	var aRBtn = [];
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=31>Role</a></span>');
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=32>Org</a></span>');
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=33>Subs</a></span>');
	var tableData1 = $('<table class="table table-bordered table-hover table-striped" style="width:100%; table-layout:fixed; word-wrap:break-word; margin:0px !important;" />').appendTo( $('.box-body') ),
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
			{ "width": "20px", orderable: false, className: "dt-body-center", "title": "<center><input type='checkbox' class='head-check'></center>" },
			{ "width": "90px", orderable: false, className: "dt-body-center" },
			{ "width": "130px", orderable: false, "data": "name", 		 	 "title": "Name" },
			{ "width": "250px", orderable: false, "data": "email", 		 	 "title": "Email" },
			{ "width": "250px", orderable: false, "data": "description", "title": "Description" },
			{ "width": "40px", orderable: false, className: "dt-body-center", "data": "is_active", "title": "Active" },
			{ "data": "is_online" },
			{ "width": "100px", orderable: false, className: "dt-body-center" },
		],
		"columnDefs": [
			{	"targets": 0,	"defaultContent": '<input type="checkbox" class="line-check">' },
			{	"targets": 1,	"defaultContent": aLBtn.join("") },
			{	"targets": 2,	"render": function(data, type, row){ return data+' ('+((row[6]=='1') ? 'on' : 'off')+')'; } },
			{	"targets": 5,	"render": function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{	"targets": 6, "visible": false },
			{	"targets":-1, "defaultContent": aRBtn.join("&nbsp;-&nbsp;") }
		],
		"order": []
	})
	.search($q ? $q : '');
	
	{* This line for changing toolbar button *}
	$('#toolbar').append( setToolbarButton() ).css('margin-bottom','10px');
	$('div.box').css('margin-bottom','10px');
	$('div.dataTables_wrapper').find('div.row:first').insertBefore('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_filter');
	$('div.dataTables_wrapper').find('div.row:last').insertAfter('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_paginate');

	addProcessMenu('btn-process1', 'User Role');
	addProcessMenu('btn-process2', 'User Organization');
	addProcessMenu('btn-process3', 'User Substitute');

	{* AVAILABLE BUTTON LIST ['btn-copy','btn-new','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-process'] *}
	setDisableToolBtn(['btn-copy','btn-message','btn-print','btn-export','btn-import']);
	setDisableMenuProcess(['btn-process2','btn-process3']);
	setVisibleToolBtn(['btn-copy','btn-message','btn-print','btn-export','btn-import']);
	
	{* Don't change this code: Re-coding dataTables search method *}
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		$q = $(this).val();
		$url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		history.pushState({}, '', origin_url +'?'+ $url);
	});		
	
	DTHelper.initCheckList(tableData1, dataTable1);
	{* =================================================================================== *}
	
	{* For class aRBtn *}
	tableData1.find('tbody').on( 'click', '.aRBtn', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		var pageid = $(this).data('pageid');
		var url = "{$.php.base_url('systems/x_page?pageid=')}"+pageid+"&user_id="+data.id;
		window.location.href = url;
	});
	
	{* btn-copy in DataTable *}
	tableData1.find('tbody').on( 'click', '[name="btn-copy"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		if (!confirm("Create copy this data ?")) {
			return false;
		}
		
		window.location.href = getURLOrigin()+window.location.search+"&edit=3&id="+data.id;
	});
	
	{* btn-edit in DataTable *}
	tableData1.find('tbody').on( 'click', '[name="btn-edit"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		window.location.href = getURLOrigin()+window.location.search+"&edit=1&id="+data.id;
	});
	
	{* btn-delete in DataTable *}
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
	
	{* btn-new in Toolbar *}
	$('#btn-new').click(function(){
		window.location.href = getURLOrigin()+window.location.search+"&edit=2";
	});
	
	{* btn-refresh in Toolbar *}
	$('#btn-refresh').click(function(){
		{* console.log('Debug: Refresh'); *}
		dataTable1.ajax.reload( null, false );
	});
	
	{* btn-delete in Toolbar *}
	$('#btn-delete').click(function(){
		var data = dataTable1.rows('.selected').data();
		var ids = [];
		
		if (data.count() < 1)
			return false;

		var confirm = $('<div />');
		confirm.append( $('<p />').html('Are you sure want to delete this record ?') );
		confirm.append( 
			BSHelper.Table({
				data: data,	rowno: true, showtitle: false, maxrows: 3, 
				columns:[
					{ data:"name"					,title:"Name" },
					{ data:"email"				,title:"Email" },
					{ data:"description"	,title:"Description" },
				]
			})
		);
		
		$.each(data, function(i){	ids[i] = data[i]['id'];	});
		
		{* console.log(ids.join()); return; *}
		BootstrapDialog.show({ title: 'Delete Record/s', type: BootstrapDialog.TYPE_DANGER, message: confirm,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-danger',
				label: '&nbsp;&nbsp;Delete',
				action: function(dialog) {
					if (! form.valid()) return false;
					
					var button = this;
					button.spin();
					
					$.ajax({ url: '{$url_module ~ "?id="}'+ids.join(), method: "DELETE", async: true, dataType: 'json',
						data: form.serializeJSON(),
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
	
	{* btn-process1 in Toolbar *}
	$('#btn-process1').click(function(){
		if ($(this).parent().hasClass('disabled')) return false;
		console.log('Debug: '+$(this).html());
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	$('#btn-process2').click(function(){
		if ($(this).parent().hasClass('disabled')) return false;
		console.log('Debug: '+$(this).html());
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	$('#btn-process3').click(function(){
		if ($(this).parent().hasClass('disabled')) return false;
		console.log('Debug: '+$(this).html());
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	
	
</script>
