{var $url_module = $.php.base_url('systems/a_menu')}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {$title}
        <small>{$short_desc}</small>
      </h1>
			<!--
      <ol class="breadcrumb">
        <li><a href="{$home_link}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">System Management</a></li>
        <li class="active">User</li>
      </ol>
			-->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            {* <div class="box-header"> *}
              {* <h3 class="box-title">Users</h3> *}
            {* </div> *}
            <!-- /.box-header -->
            <div class="box-body">
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
		'<button type="button" class="btn btn-xs btn-success glyphicon glyphicon-edit" title="Edit" name="btn-edit" />';
	var tableData1 = $('<table class="table table-bordered table-hover" />').appendTo( $('.box-body') ),
	dataTable1 = tableData1.DataTable({
		"pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true,
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
			{ "width": "3%", orderable: false, className: "dt-body-center", "title": "<input type='checkbox' class='head-check'>" },
			{ "width": "7%", orderable: false, className: "dt-body-center" },
			{ "data": "name", 		 	 "title": "Name" },
			{ "data": "description", "title": "Description", orderable: false },
		],
		"columnDefs": [
			{	"targets": 0,	"defaultContent": '<input type="checkbox" class="line-check">' },
			{	"targets": 1,	"defaultContent": setCustomLeftButton	}
		],
		"order": [[ 2, 'asc' ]]
	})
	.search($q ? $q : '');
	
	{* This line for changing toolbar button *}
	var toolbar_row = $('<div class="row"><div class="col-md-12"></div></div>');
	var toolbar_col = toolbar_row.find('.col-md-12').append(
		setToolbarButton([
			'btn-copy', 	 'btn-new', 	'btn-refresh', 'btn-delete', 
			'btn-message', 'btn-print', 'btn-export',  'btn-import', 
			'btn-process', 'btn-process-doc-act', 'btn-process-a-pros'
		])
	);
	$('div.dataTables_wrapper').find('div.row:first').before(toolbar_row);
	
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
		form.append(BSHelper.Input({ type:"text", label:"Name", idname:"name", readonly:false, required: true, placeholder:"string(60)" }));
		form.append(BSHelper.TextArea({ label:"Description", idname:"description", placeholder:"string(2000)" }));
		form.append(BSHelper.TextArea({ label:"Icon", idname:"icon", placeholder:"string(2000)" }));
		form.append(BSHelper.TextArea({ label:"Table", idname:"url", placeholder:"string(2000)" }));
		form.append(BSHelper.TextArea({ label:"Path", idname:"path", placeholder:"string(2000)" }));
		form.append(BSHelper.Checkbox({ label:"Is Active", idname:"is_active" }));
		form.append(BSHelper.Checkbox({ label:"Is Parent", idname:"is_parent" }));
		form.append(BSHelper.Combobox({ label:"Parent", idname:"parent_id", url:"{$.php.base_url('systems/a_menu')}", required: false, isCombogrid: true, placeholder:"typed or choose" }));
		return form;
	}
	
	{* btn-edit in DataTable on click *}
	tableData1.find('tbody').on( 'click', '[name="btn-edit"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		{* line for check permission *}
		
		form = createForm1();
		form.xform('load', data);  
		BootstrapDialog.show({ title: 'Update Record', message: form,
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
				form.validate({ ignore:'' });
				form.find('#name').focus();
			}
		});
	});
	
	{* btn-role in DataTable on click *}
	tableData1.find('tbody').on( 'click', '[name="btn-role"]', function(){
		var data = dataTable1.row( $(this).parents('tr') ).data();
		console.log($(this).attr('title'));
    });
	
	{* btn-org in DataTable on click *}
	tableData1.find('tbody').on( 'click', '[name="btn-org"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		console.log($(this).attr('title'));
    });
	
	{* btn-subs in DataTable on click *}
	tableData1.find('tbody').on( 'click', '[name="btn-subs"]', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		console.log($(this).attr('title'));
    });
	
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
		
		if (data.count() < 1)
			return false;

		var confirm = $('<div />');
		confirm.append( $('<p />').html('Are you sure want to delete this record ?') );
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
		console.log('Debug: Chat/Message/Attach');
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-print in Toolbar on click *}
	$('#btn-print').click(function(){
		console.log('Debug: Print');
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-export in Toolbar on click *}
	$('#btn-export').click(function(){
		console.log('Debug: Export');
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-import in Toolbar on click *}
	$('#btn-import').click(function(){
		console.log('Debug: Import');
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	{* btn-process-doc-act in Toolbar on click *}
	$('#btn-process-doc-act').click(function(){
		console.log('Debug: Document Action');
		{* dataTable1.ajax.reload( null, false ); *}
	});
	
	
	
</script>
