{var $url_module = $.php.base_url('systems/a_user')}
{var $url_loginattempt = $.php.base_url('systems/a_loginattempt')}

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
<script src="{$.const.ASSET_URL}js/window_view.js"></script>
<script>
	var $url_module = "{$url_module}", $title = "{$title}", $title_desc = "{$title_desc}";
	{* Get Params *}
	var $q = getURLParameter("q"), $id = getURLParameter("id");
	{* Toolbar Init *}
	var Toolbar_Init = {
		toolbar: true,
		toolbarBtn: ['btn-new','btn-copy','btn-refresh','btn-delete','btn-message','btn-print','btn-export','btn-import','btn-viewlog','btn-process'],
		disableBtn: ['btn-copy','btn-message','btn-print','btn-import'],
		hiddenBtn: ['btn-copy','btn-message','btn-print','btn-import'],
		processMenu: [{ id:"btn-process1", title:"Reset Login Attempt" }, { id:"btn-process2", title:"Process #2" }, ],
		processMenuDisable: ['btn-process2'],
	};
	{* Defining Left Button for Datatables *}
	var aLBtn = [];
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-info glyphicon glyphicon-duplicate" title="Copy" name="btn-copy" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-success glyphicon glyphicon-edit" title="Edit" name="btn-edit" />');
	aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs btn-danger glyphicon glyphicon-trash" title="Delete" name="btn-delete" />');
	{* Defining Right Button for Datatables *}
	var aRBtn = [];
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=31>Role</a></span>');
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=32>Org</a></span>');
	aRBtn.push('<span><a href="#" class="aRBtn" data-pageid=33>Subs</a></span>');
	{* Setup DataTables *}
	var tableData1 = $('<table class="table table-bordered table-hover table-striped" style="width:100%; table-layout:fixed; word-wrap:break-word; margin:0px !important;" />').appendTo( $('.box-body') ),
	dataTable1 = tableData1.DataTable({ "pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true, 
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
			{ width:"130px", orderable:false, data:"name", title:"Name", render:function(data, type, row){ return data+' ('+((row[6]=='1') ? 'on' : 'off')+')'; } },
			{ width:"150px", orderable:false, data:"email", title:"Email" },
			{ width:"250px", orderable:false, data:"description", title:"Description" },
			{ width:"40px", orderable:false, className:"dt-head-center dt-body-center", data:"is_active", title:"Active", render:function(data, type, row){ return (data=='1') ? 'Y' : 'N'; } },
			{ data:"is_online", "visible":false },
			{ width:"100px", orderable:false, className:"dt-head-center dt-body-center", title:"Sub Menu", render:function(data, type, row){ return aRBtn.join("&nbsp;-&nbsp;"); } },
		],
		"order": []
	})
	.search($q ? $q : '');
	
	{* For class aRBtn *}
	tableData1.find('tbody').on( 'click', '.aRBtn', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		var pageid = $(this).data('pageid');
		var url = "{$.php.base_url('systems/x_page?pageid=')}"+pageid+"&user_id="+data.id;
		window.location.href = url;
	});
	
	{* btn-process1 in Toolbar *}
	$(document.body).click('button', function(e){
		switch($(e.target).attr('id')){
			case 'btn-process1':
				var data = dataTable1.rows('.selected').data();
				
				if (data.count() < 1){
					BootstrapDialog.alert('Please chosed the record !');
					return false;
				}
				var ids = [];
				$.each(data, function(i){	ids[i] = data[i]['id'];	});

				var tblConfirm = BSHelper.Table({ data: data,	rowno: true, showheader: true, maxrows: 3, isConfirm: true, title: "<h4>Are you sure want to process this selected user/s ?</h4>" });
				BootstrapDialog.show({ title: 'Reset Login Attempt', type: BootstrapDialog.TYPE_DANGER, message: tblConfirm,
					buttons: [{
						icon: 'glyphicon glyphicon-send',
						cssClass: 'btn-danger',
						label: '&nbsp;&nbsp;Delete',
						action: function(dialog) {
							var button = this;
							button.spin();
							
							$.ajax({ url: '{$url_module}', method: "OPTIONS", async: true, dataType: 'json',
								data: JSON.stringify({ loginattempt:1, id:ids.join() }),
								success: function(data) {
									dialog.close();
									dataTable1.ajax.reload( null, false );
									BootstrapDialog.alert(data.message);
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
				break;
		}
	});	
	
</script>
