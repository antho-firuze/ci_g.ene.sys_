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
		$.each(Toolbar_Init.processMenuHidden, function(k,v){
			$('#'+v).css( "display", "none" );
		});
	}
}

function initCheckList(tableData1, dataTable1){
	/* {* Don't change this code: Init for iCheck Plugin *} */
	var iCounter=0;
	var head_cb = tableData1.find('input[type="checkbox"].head-check');
	head_cb.iCheck({ checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue' });
	
	dataTable1.on( 'draw.dt', function () {
		var count_rows = dataTable1.rows().data().length;
		var line_cb = tableData1.find('input[type="checkbox"].line-check');
		line_cb.iCheck({ checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue' });
		line_cb.on('ifChecked', function(){
			// console.log("Debug: Line-Check (True)");
			if (iCounter==0) dataTable1.rows().deselect();
			dataTable1.row( $(this).parents('tr') ).select();
			iCounter++;
			
			if (count_rows==iCounter) { head_cb.data("clicks", true).iCheck('check'); }
		});
		line_cb.on('ifUnchecked', function(){
			dataTable1.row( $(this).parents('tr') ).deselect();
			iCounter--;
			
			if (count_rows!=iCounter) { head_cb.data("clicks", false).iCheck('uncheck'); }
		});
	} );

	/* {* Don't change this code: Init for btn-check *} */
	head_cb.on('ifClicked', function(){
		// console.log("Debug: Head-Check (ifClicked)");
		var clicks = head_cb.data('clicks');
		if (clicks) {
			dataTable1.rows().deselect();
			/* {* tableData1.find('tr[role="row"]').removeClass("selected"); *} */
			tableData1.find('input[type="checkbox"]').iCheck("uncheck");
		} else {
			dataTable1.rows().select();
			/* {* tableData1.find('tr[role="row"]').addClass("selected"); *} */
			tableData1.find('input[type="checkbox"]').iCheck("check");
		}
		head_cb.data("clicks", !clicks);
	});
	
	/* {* Don't change this code: This is for (Checked & Unchecked) or (Selected & Unselected) on DataTable *} */
	tableData1.find('tbody').on( 'click', 'tr', function () {
		var count_rows = dataTable1.rows().data().length;
		var count_selected = dataTable1.rows('.selected').data().length;
		
		if (count_selected !== count_rows) {
			
			if (count_selected <= 1){ 
				tableData1.find('input[type="checkbox"]').iCheck("uncheck");
				dataTable1.row($(this)).select();
			}
			
			if (count_selected > 1) {
				var selected = $(this).hasClass('selected');
				if (selected)
					tableData1.find('.selected input[type="checkbox"]').iCheck("check");
				else
					$(this).find('input[type="checkbox"]').iCheck("uncheck");
			}	
				
			$('#btn-check').data("clicks", false).removeClass("glyphicon-check").addClass('glyphicon-unchecked');
		} 
		
		if (count_selected == count_rows) {
			$(this).find('input[type="checkbox"]').iCheck("check");
			$('#btn-check').data("clicks", true).removeClass("glyphicon-unchecked").addClass('glyphicon-check');
		}
	});
};

/* ========================================= */
/* Default init for Header									 */
/* ========================================= */
// $( document ).ready(function() {
	/* Start :: Init for Title, Breadcrumb */
	if (typeof($is_submodule) == 'undefined') $is_submodule = false;
	if ($is_submodule) {
		var $mainpageid = getURLParameter("mainpageid"); 
		var $code_name = $.cookie('code_name'+$mainpageid);
		var $maintitle = $.cookie('maintitle'+$mainpageid);
		var breadcrumb = [
				{ icon:"fa fa-dashboard", title:"Dashboard", link: $APPS_LNK },
				{ icon:"", title: $maintitle, link:"javascript:history.back()" },
				{ icon:"", title: $title, link:"" },
			];
		$title = $title + ': ' + $code_name;
	} else {
		var breadcrumb = [
				{ icon:"fa fa-dashboard", title:"Dashboard", link: $APPS_LNK },
				{ icon:"", title: $title, link:"" },
			];
	}
	
	$(".content").before(BSHelper.PageHeader({ 
		title: $title, 
		title_desc: $title_desc, 
		bc_list: breadcrumb
	}));

	/* Init for Toolbar Button */
	initToolbarButton();
	
	$.cookie('table', $table);
// });

/* ========================================= */
/* Default init for dataTables  */
/* ========================================= */
// $( document ).ready(function() {
	
	/* For parsing URL Parameters */
	var origin_url = window.location.origin+window.location.pathname;
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		$q = $(this).val();
		$url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		history.pushState({}, '', origin_url +'?'+ $url);
	});		
	
	// DTHelper.initCheckList(tableData1, dataTable1);
	initCheckList(tableData1, dataTable1);
	
	$('div.dataTables_wrapper').find('div.row:first').insertBefore('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_filter');
	$('div.dataTables_wrapper').find('div.row:last').insertAfter('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_paginate');
	$('div.box').css('margin-bottom','10px');
	
	/* For Right Button if Exists */
	tableData1.find('tbody').on( 'click', '.aRBtn', function () {
		var data = dataTable1.row( $(this).parents('tr') ).data();
		
		/* Set Main Title & code_name to Cookies */
		$.cookie('maintitle'+$pageid, $title);
		$.cookie('code_name'+$pageid, data.code_name);
		
		var pageid = $(this).data('pageid');
		var key 	 = $(this).data('key');
		var url = $BASE_URL+"systems/x_page?pageid="+pageid+"&mainpageid="+$pageid+"&key="+key+"&val="+data.id;
		window.location.href = url;
	});
	
// });

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
			/* Set Main Title & code_name to Cookies */
			var $pageid = getURLParameter("pageid");
			$.cookie('title'+$pageid, $title);
			window.location.href = getURLOrigin()+window.location.search+"&action=exp";
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
	
