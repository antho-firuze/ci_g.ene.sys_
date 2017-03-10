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
	var setCustomLeftButton = ''+
		'<button type="button" style="margin-right:5px;" class="btn btn-xs btn-success glyphicon glyphicon-edit" title="Edit" name="btn-edit" />' +
		'<button type="button" style="margin-right:5px;" class="btn btn-xs btn-danger glyphicon glyphicon-trash" title="Delete" name="btn-delete" />' +
		'<button type="button" style="margin-right:5px;" class="btn btn-xs btn-success glyphicon glyphicon-eye-open" title="View" name="btn-view" />'; 
		{* '<button type="button" style="margin-right:5px;" class="btn btn-xs btn-default glyphicon glyphicon-chevron-right" title="Detail" name="btn-detail" />'; *}
	var setCustomRightButton = ''+
		'<button type="button" class="btn btn-xs btn-default glyphicon glyphicon-th-list" title="Role" name="btn-role" />' +
		'<button type="button" class="btn btn-xs btn-default glyphicon glyphicon-leaf" title="Organization" name="btn-org" />' +
		'<button type="button" class="btn btn-xs btn-default glyphicon glyphicon-flag" title="User Substitute" name="btn-subs" />';
	var tableData1 = $('<table class="table table-bordered table-hover table-striped" style="width:100%; table-layout:fixed; word-wrap:break-word; margin:0px !important;" />').appendTo( $('.box-body') ),
	dataTable1 = tableData1.DataTable({
		"pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true, 
		"sAutoWidth": false, "bAutoWidth": false, "autoWidth": false,
		"ajax": {
			"url": '{$url_module}'+window.location.search,
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
			{ "width": "130px", "data": "name", 		 	 "title": "Name" },
			{ "width": "250px", "data": "email", 		 	 "title": "Email" },
			{ "width": "250px", "data": "description", "title": "Description", orderable: false },
			{* { "width": "9%", orderable: false, className: "dt-body-center" }, *}
		],
		"columnDefs": [
			{	"targets": 0,	"defaultContent": '<input type="checkbox" class="line-check">' },
			{	"targets": 1,	"defaultContent": setCustomLeftButton	},
			{* {	"targets":-1, "defaultContent": setCustomRightButton} *}
		],
		"order": [[ 2, 'asc' ]]
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
	
	{* Don't change this code: Re-coding dataTables search method *}
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		$q = $(this).val();
		$url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		history.pushState({}, '', origin_url +'?'+ $url);
	});		
	
	DTHelper.initCheckList(tableData1, dataTable1);
	
	{* From this line, the code can be change *}
	{* ====================================== *}
	var form = $('<form />', { class: 'form-horizontal', autocomplete: 'off' });
	function createForm1(){
		form.html('');
		form.append(BSHelper.Input({ type:"text", label:"User Name", idname:"name", readonly:false, required: true, placeholder:"string(60)" }));
		form.append(BSHelper.TextArea({ label:"Description", idname:"description", placeholder:"string(2000)" }));
		form.append(BSHelper.Input({ type:"email", label:"Email", idname:"email", required: true, placeholder:"string(255)" }));
		form.append(BSHelper.Checkbox({ label:"Is Active", idname:"is_active" }));
		form.append(BSHelper.Checkbox({ label:"Is Full BP Access", idname:"is_fullbpaccess" }));
		form.append(BSHelper.Combobox({ label:"Supervisor", idname:"supervisor_id", url:"{$.php.base_url('systems/a_user')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		return form;
	}
	
	function createForm2(){
		form.html('');
		form.append(BSHelper.Input({ type:"password", label:"Password (New)", idname:"password_new", placeholder:"string(min3-max80)", help:"Fill this column, if you want to reset the password !" }));
		form.append(BSHelper.Input({ type:"password", label:"Password (Confirm)", idname:"password_confirm", placeholder:"string(min3-max80)" }));
		return form;
	}
	
	function createForm3(){
		form.html('');
		form.append(BSHelper.Input({ type:"password", label:"Password (New)", idname:"password_new", placeholder:"string(min3-max80)", help:"Fill this column, if you want to reset the password !" }));
		form.append(BSHelper.Input({ type:"password", label:"Password (Confirm)", idname:"password_confirm", placeholder:"string(min3-max80)" }));
		return form;
	}
	
	{* btn-edit in DataTable on click *}
	tableData1.find('tbody').on( 'click', '[name="btn-edit"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		{* line for check permission *}
		
		form = createForm1();
		form.xform('load', data);  
		BootstrapDialog.show({ title: 'Update Record', type: BootstrapDialog.TYPE_PRIMARY, message: form,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-primary',
				label: '&nbsp;&nbsp;Save',
				action: function(dialog) {
					if (! form.valid()) return false;
					
					var button = this;
					button.spin();
					
					$.ajax({ url: '{$url_module ~ "?id="}'+data.id, method: "PUT", async: true, dataType: 'json',
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
				form.validate({ ignore:'', rules:{ password_confirm:{ equalTo: "#password_new" }} });
				form.find('#name').focus();
			}
		});
	});
	
	tableData1.find('tbody').on( 'click', '[name="btn-delete"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		{* line for check permission *}
		
		var ids = [];
		
		{* if (data.count() < 1)
			return false; *}

		{* $('#btn-delete').click(); *}
		console.log(data); return false;
		var confirm = $('<div />');
		confirm.append( $('<p />').html('Are you sure want to delete this record ?') );
		confirm.append( $("<table class='table'><thead></thead><tbody><tr><td></td></tr></tbody></table>") );
		tr = confirm.find('tr');
		tr.append( $('<td />').html() );
		confirm.append( 
			BSHelper.TableConfirm({
				data: data,	rowno: true, showtitle: false, maxrows: 3, 
				columns:[
					{ data:"name"					,title:"Name" },
					{ data:"email"				,title:"Email" },
					{ data:"description"	,title:"Description" },
				]
			})
		);
		
		console.log(data); return false;
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
	
	{* btn-detail in DataTable on click *}
	tableData1.find('tbody').on( 'click', '[name="btn-detail"]', function(){
		var data = dataTable1.row( $(this).parents('tr') ).data(),
				tr = $(this).closest('tr'),
				row = dataTable1.row( tr ),
				photo_url = '{$.php.base_url()~$user_photo_path}'+data.photo_file,
				tabs = { 
					["tab1-" + data.id]: 'Details',
					["tab2-" + data.id]: 'Document Log' 
				},
				tabs_detail = BSHelper.NavigationTabs({ tabList: tabs });
		
		var tab1_row = $('<div class="row" />');
		$('<div class="col-md-2" />').append(
			$('<img class="profile-user-img img-responsive img-circle" src="'+ photo_url +'" alt="User picture">')
		).appendTo(tab1_row);
		$('<div class="col-md-5" />').append(
			$('<dl class="dl-horizontal" />')
			.append(BSHelper.LineDesc({ title:'<h4>Personal Info</h4>' }))
			.append(BSHelper.LineDesc({ title:'Email', value:data.email }))
			.append(BSHelper.LineDesc({ title:'Supervisor', value:data.supervisor_name }))
			.append(BSHelper.LineDesc({ title:'Default Role', value:data.role_name }))
			.append(BSHelper.LineDesc({ title:'Default Organization', value:data.org_name }))
			.append(BSHelper.LineDesc({ title:'Full BP Access', value:data.is_fullbpaccess, reference:['Nope :(','Yes!'] }))
		).appendTo(tab1_row);
		$('<div class="col-md-5" />').append(
			$('<dl class="dl-horizontal" />')
			.append(BSHelper.LineDesc({ title:'<h4>Others Info</h4>' }))
			.append(BSHelper.LineDesc({ title:'ID', value:data.id }))
			.append(BSHelper.LineDesc({ title:'IP Address', value:data.ip_address }))
			.append(BSHelper.LineDesc({ title:'Online', value:data.is_online, reference:['Nope :(','Yes!'] }))
			.append(BSHelper.LineDesc({ title:'Active', value:data.is_active, reference:['Nope :(','Yes!'] }))
			.append(BSHelper.LineDesc({ title:'Last Login', value:format_to_datetime(data.last_login) }))
		).appendTo(tab1_row);
		tabs_detail.find('#tab1-'+data.id).append(tab1_row);
		
		var tab2_row = $('<div class="row" />');
		$('<div class="col-md-4" />').append(
			$('<dl class="dl-horizontal" />')
			.append(BSHelper.LineDesc({ title:'<h4>Created Info</h4>' }))
			.append(BSHelper.LineDesc({ title:'Created By', value:data._created_by }))
			.append(BSHelper.LineDesc({ title:'At Time', value:data.created_at }))
		).appendTo(tab2_row);
		$('<div class="col-md-4" />').append(
			$('<dl class="dl-horizontal" />')
			.append(BSHelper.LineDesc({ title:'<h4>Updated Info</h4>' }))
			.append(BSHelper.LineDesc({ title:'Updated By', value:data._updated_by }))
			.append(BSHelper.LineDesc({ title:'At Time', value:data.updated_at }))
		).appendTo(tab2_row);
		if (parseInt(data.is_deleted))
			$('<div class="col-md-4" />').append(
				$('<dl class="dl-horizontal" />')
				.append(BSHelper.LineDesc({ title:'<h4>Deleted Info</h4>' }))
				.append(BSHelper.LineDesc({ title:'Deleted By', value:data._deleted_by }))
				.append(BSHelper.LineDesc({ title:'At Time', value:data.deleted_at }))
			).appendTo(tab2_row);
		else
			$('<div class="col-md-3" />').append(
				$('<dl class="dl-horizontal" />')
				.append(BSHelper.LineDesc({ title:'<h4>Deleted Info</h4>' }))
				.append(BSHelper.LineDesc({ title:'NO DATA !' }))
			).appendTo(tab2_row);
		tabs_detail.find('#tab2-'+data.id).append(tab2_row); 
		
		$(this).hasClass('glyphicon-chevron-right') 
			? $(this).removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down')
			: $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
		
		if (row.child.isShown()){
			tr.removeClass('details');
			row.child.hide();
		}	else {
			tr.addClass('details');
			row.child( tabs_detail ).show();
		}
	});
	
	{* btn-role in DataTable on click *}
	{* tableData1.find('tbody').on( 'click', '[name="btn-role"]', function(){
		var data = dataTable1.row( $(this).parents('tr') ).data();
		console.log($(this).attr('title'));
    }); *}
	
	{* btn-org in DataTable on click *}
	{* tableData1.find('tbody').on( 'click', '[name="btn-org"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		console.log($(this).attr('title'));
    }); *}
	
	{* btn-subs in DataTable on click *}
	{* tableData1.find('tbody').on( 'click', '[name="btn-subs"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		console.log($(this).attr('title'));
    }); *}
	
	{* btn-copy in Toolbar on click *}
	$('#btn-copy').click(function(){
		console.log('Debug: Copy');
		{* line for check permission *}
	});
	
	{* btn-new in Toolbar on click *}
	$('#btn-new').click(function(){
		console.log('Debug: New');
		
		{* line for check permission *}
		
		form = createForm1();
		BootstrapDialog.show({ title: 'Insert Record', message: form,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-primary',
				label: '&nbsp;&nbsp;Save',
				action: function(dialog) {
					if (! form.valid()) return false;
					
					var button = this;
					button.spin();
					
					$.ajax({ url: '{$url_module}', method: "POST", async: true, dataType: 'json',
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
				form.validate({ ignore:'' });
				
				form.find('#name').focus();
			} 
		});
	});
	
	{* btn-refresh in Toolbar on click *}
	$('#btn-refresh').click(function(){
		console.log('Debug: Refresh');
		dataTable1.ajax.reload( null, false );
	});
	
	{* btn-delete in Toolbar on click *}
	$('#btn-delete').click(function(){
		console.log('Debug: Delete');
		
		{* line for check permission *}
		
		var data = dataTable1.rows('.selected').data();
		var ids = [];
		
		{* console.log(data); return false; *}
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
	
	{* btn-message in Toolbar on click *}
	$('#btn-message').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-print in Toolbar on click *}
	$('#btn-print').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-export in Toolbar on click *}
	$('#btn-export').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-import in Toolbar on click *}
	$('#btn-import').click(function(){
		console.log('Debug: '+$(this).attr('title'));
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-process1 in Toolbar on click *}
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
