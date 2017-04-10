/*!
 * form_view.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A functions for build Form to View Data
 */
/* 
	$.each(btn, function(k,v){
		if (k=='btn-copy') 
				if (v)
					btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-duplicate" title="Copy" id="btn-copy" />'));
				else
					
		
  }); */
function setToolbarButton(){
	var container = $('<div class="row toolbar_container">'+
											'<div class="col-md-12">'+
												'<div class="btn-toolbar">'+
													'<div class="btn-group btnGroup1" />'+
													'<div class="btn-group btnGroup2" />'+
													'<div class="btn-group btnGroup3" />'+
													'<div class="btn-group btnGroup4" />'+
													'<div class="btn-group btnGroup5" />'+
												'</div>'+
											'</div>'+
										'</div>');
	var btnGroup1 = container.find('.btnGroup1'); 
	var btnGroup2 = container.find('.btnGroup2'); 
	var btnGroup3 = container.find('.btnGroup3'); 
	var btnGroup4 = container.find('.btnGroup4'); 
	var btnGroup5 = container.find('.btnGroup5'); 
	
	btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-plus" title="New" id="btn-new" />'));
	btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-duplicate" title="Copy" id="btn-copy" />'));
	btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-refresh" title="Refresh" id="btn-refresh" />'));
	btnGroup1.append($('<button type="button" class="btn btn-danger glyphicon glyphicon-trash" title="Delete" id="btn-delete" />'));
	btnGroup2.append($('<button type="button" class="btn btn-info glyphicon glyphicon-comment" title="Chat/Message/Attach" id="btn-message" />'));
	btnGroup3.append($('<button type="button" class="btn bg-purple glyphicon glyphicon-print" title="Print" id="btn-print" />'));
	btnGroup3.append($('<button type="button" class="btn btn-warning glyphicon glyphicon-open" title="Export" id="btn-export" />'));
	btnGroup3.append($('<button type="button" class="btn btn-warning glyphicon glyphicon-save" title="Import" id="btn-import" />'));
	btnGroup4.append($('<button type="button" class="btn btn-default fa fa-info fa-lg" style="width:35px; height:35px;" title="Record Info" id="btn-rec-info" />'));
	btnGroup5.append($('<button type="button" class="btn bg-purple glyphicon glyphicon-cog dropdown-toggle" data-toggle="dropdown" title="Process" id="btn-process" /><ul class="dropdown-menu" />'));

	return container;
}

function addProcessMenu(btnId, btnTitle)
{
	var dropdown_menu = $('.btn-toolbar').find('.dropdown-menu'); 
	$('<li disabled />').append($('<a href="#" title="'+btnTitle+'" id="'+btnId+'" />').html(btnTitle)).appendTo(dropdown_menu);
}

function setDisableToolBtn(btn)
{
	if(typeof(btn)==='undefined') btn = [];
	$.each(btn, function(k,v){
		// $('#'+v).addClass('disabled');
		$('#'+v).prop( "disabled", true );
  });
}

function setDisableMenuProcess(btn)
{
	if(typeof(btn)==='undefined') btn = [];
	$.each(btn, function(k,v){
		$('#'+v).parent().addClass('disabled');
  });
}

function setHideToolBtn(btn)
{
	if(typeof(btn)==='undefined') btn = [];
	$.each(btn, function(k,v){
		$('#'+v).css( "display", "none" );
  });
}



/* ========================================= */
/* Default init for dataTables search method */
/* ========================================= */
$( document ).ready(function() {
	/* For parsing URL Parameters */
	var origin_url = window.location.origin+window.location.pathname;
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		$q = $(this).val();
		$url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		history.pushState({}, '', origin_url +'?'+ $url);
	});		
});

/* ==================================== */
/* Default action for Form CRUD Toolbar */
/* ==================================== */
$(document.body).click('button', function(e){
	// console.log($(e.target).attr('id'));
	switch($(e.target).attr('id')){
		case 'btn-new':
			window.location.href = getURLOrigin()+window.location.search+"&edit=2";
			break;
			
		case 'btn-refresh':
			dataTable1.ajax.reload( null, false );
			break;
			
		case 'btn-rec-info':
			var data = dataTable1.rows('.selected').data();
			if (data.count() < 1 || data.count() > 1){
				BootstrapDialog.alert('Please chosed one record !');
				return false;
			}
			$.getJSON($url_module, { rec_info: 1, id: data[0].id }, function(result){ 
				// console.log(data[0]);
				if (!result.status){
					BootstrapDialog.alert(result.message);
				} else {
					var c = [], r = [], a = [];
					a.push(BSHelper.Input({ type:'text', label:'Table', value:result.data.table, readonly:true }));
					c.push(subCol(6, a)); a = [];
					a.push(BSHelper.Input({ type:'text', label:'Record ID', value:result.data.id, readonly:true }));
					c.push(subCol(6, a)); a = [];
					r.push(subRow(c)); c = [];
					if (result.data.created_by_name){
						a.push(BSHelper.Input({ type:'text', label:'Created By', value:result.data.created_by_name, readonly:true }));
						c.push(subCol(6, a)); a = [];
						a.push(BSHelper.Input({ type:'text', label:'Created At', value:result.data.created_at, readonly:true }));
						c.push(subCol(6, a)); a = [];
						r.push(subRow(c)); c = [];
					}
					if (result.data.updated_by_name){
						a.push(BSHelper.Input({ type:'text', label:'Updated By', value:result.data.updated_by_name, readonly:true }));
						c.push(subCol(6, a)); a = [];
						a.push(BSHelper.Input({ type:'text', label:'Updated At', value:result.data.updated_at, readonly:true }));
						c.push(subCol(6, a)); a = [];
						r.push(subRow(c)); c = [];
					}
					var tblConfirm = BSHelper.Table({
							title: r,
							data: data,	rowno: true, showheader: true, maxrows: 3, isConfirm: true,
							columns:[
								{ data:"name"					,title:"Name" },
								{ data:"description"	,title:"Description" },
							],
						});
					BootstrapDialog.alert(tblConfirm);
				}
			});

			break;
			
		case 'btn-delete':
			var data = dataTable1.rows('.selected').data();
			if (data.count() < 1){
				BootstrapDialog.alert('Please chosed the record !');
				return false;
			}
			var tblConfirm = BSHelper.Table({
					data: data,	rowno: true, showheader: true, maxrows: 3, isConfirm: true,
					columns:[
						{ data:"name"					,title:"Name" },
						{ data:"description"	,title:"Description" },
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
						
						$.ajax({ url: $url_module+"?id="+ids.join(), method: "DELETE", async: true, dataType: 'json',
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
				}
			});
			break;
	}
});

/* ==================================== */
/* Default action for Button Action Table */
/* ==================================== */
$(document.body).click('button', function(e){
	/* get selscted record from datatable */
	var data = dataTable1.row( $(e.target).closest('tr') ).data();
	
	switch($(e.target).attr('name')){
		case 'btn-copy':
			if (!confirm("Copy this data ?")) {
				return false;
			}
			window.location.href = getURLOrigin()+window.location.search+"&edit=3&id="+data.id;
			break;
			
		case 'btn-edit':
			window.location.href = getURLOrigin()+window.location.search+"&edit=1&id="+data.id;
			break;
			
		case 'btn-delete':
			if (!confirm("Are you sure want to delete this record ?")) {
				return false;
			}
			$.ajax({ url: $url_module+"?id="+data.id, method: "DELETE", async: true, dataType: 'json',
				success: function(data) {
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
					BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
				}
			});
			break;
	}
});
	
