/*!
 * form_view.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A functions for build Form to View Data
 */
function setToolbarBtn(btnList)
{
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
	var buttons = {
		"btn-new": 			{group:1, id:"btn-new", title:"New", bstyle:"btn-success", icon:"glyphicon glyphicon-plus"},
		"btn-copy": 		{group:1, id:"btn-copy", title:"Copy", bstyle:"btn-success", icon:"glyphicon glyphicon-duplicate"},
		"btn-refresh": 	{group:1, id:"btn-refresh", title:"Refresh", bstyle:"btn-success", icon:"glyphicon glyphicon-refresh"},
		"btn-delete": 	{group:1, id:"btn-delete", title:"Delete", bstyle:"btn-danger", icon:"glyphicon glyphicon-trash"},
		"btn-message": 	{group:2, id:"btn-message", title:"Chat/Message/Attach", bstyle:"btn-info", icon:"glyphicon glyphicon-comment"},
		"btn-print": 		{group:3, id:"btn-print", title:"Print", bstyle:"bg-purple", icon:"glyphicon glyphicon-print"},
		"btn-export": 	{group:3, id:"btn-export", title:"Export", bstyle:"btn-warning", icon:"glyphicon glyphicon-save"},
		"btn-import": 	{group:3, id:"btn-import", title:"Import", bstyle:"btn-warning", icon:"glyphicon glyphicon-open"},
		"btn-viewlog": 	{group:4, id:"btn-viewlog", title:"Record Info", bstyle:"btn-default", icon:"fa fa-info fa-lg", style:"width:35px; height:35px;"},
		"btn-process": 	{group:5, id:"btn-process", title:"Process", bstyle:"bg-purple", icon:"glyphicon glyphicon-cog dropdown-toggle", data_toggle:"dropdown"},
	};
	$.each(btnList, function(k,v){
		var btn = $('<button/>', { type:"button", id:buttons[v].id, title:buttons[v].title, 'class':'btn '+buttons[v].bstyle+' '+buttons[v].icon, style:buttons[v].style, 'data-toggle':buttons[v].data_toggle });
		container.find('.btnGroup'+buttons[v].group).append(btn); 
  });
	
	return container;
}

function initToolbarButton()
{
	
	if (!Toolbar_Init.toolbar)
		return false;
	
	var toolbarBtn = setToolbarBtn(Toolbar_Init.toolbarBtn);
	
	$('.content').find('div:first').before( toolbarBtn.css('margin-bottom','10px') );
	
	$.each(Toolbar_Init.disableBtn, function(k,v){
		$('#'+v).prop( "disabled", true );
  });
	$.each(Toolbar_Init.hiddenBtn, function(k,v){
		$('#'+v).css( "display", "none" );
  });
	
	/* Init for Process Menu Button */
	if (Toolbar_Init.processMenu.length > 0){
		var dropdown_menu = $('<ul class="dropdown-menu" />').insertAfter(toolbarBtn.find('#btn-process'));
		$.each(Toolbar_Init.processMenu, function(k,v){
			$('<li disabled />').append($('<a href="#" title="'+v.title+'" id="'+v.id+'" />').html(v.title)).appendTo(dropdown_menu);
		});
		$.each(Toolbar_Init.processMenuDisable, function(k,v){
			$('#'+v).parent().addClass('disabled');
		});
	}
}

/* ========================================= */
/* Default init for Header									 */
/* ========================================= */
$( document ).ready(function() {
	/* Start :: Init for Title, Breadcrumb */
	$( document ).ready(function() {
		$(".content").before(BSHelper.PageHeader({ 
			title: $title, 
			title_desc: $title_desc, 
			bc_list:[
				{ icon:"fa fa-dashboard", title:"Dashboard", link: $APPS_LNK },
				{ icon:"", title: $title, link:"" },
			]
		}));
	});

	/* Init for Toolbar Button */
	initToolbarButton();

});

/* ========================================= */
/* Default init for dataTables  */
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
	
	DTHelper.initCheckList(tableData1, dataTable1);
	
	$('div.dataTables_wrapper').find('div.row:first').insertBefore('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_filter');
	$('div.dataTables_wrapper').find('div.row:last').insertAfter('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_paginate');
	$('div.box').css('margin-bottom','10px');
	
});

/* ==================================== */
/* Default action for Form CRUD Toolbar */
/* ==================================== */
$(document.body).click('button', function(e){
	// console.log($(e.target).attr('id'));
	switch($(e.target).attr('id')){
		case 'btn-new':
			window.location.href = getURLOrigin()+window.location.search+"&action=new";
			break;
			
		case 'btn-refresh':
			dataTable1.ajax.reload( null, false );
			break;
			
		case 'btn-viewlog':
			var data = dataTable1.rows('.selected').data();
			if (data.count() < 1 || data.count() > 1){
				BootstrapDialog.alert('Please chosed one record !');
				return false;
			}
			$.getJSON($url_module, { viewlog:1, id:data[0].id }, function(result){ 
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
		case 'btn-export':
			window.location.href = getURLOrigin()+window.location.search+"&export=1";
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
			window.location.href = getURLOrigin()+window.location.search+"&action=cpy&id="+data.id;
			break;
			
		case 'btn-edit':
			window.location.href = getURLOrigin()+window.location.search+"&action=edt&id="+data.id;
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
	
