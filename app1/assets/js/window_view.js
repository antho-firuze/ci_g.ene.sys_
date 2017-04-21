/*!
 * form_view.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A functions for build Form to View Data
 */
/* Get Params */
var $q = getURLParameter("q"), 
	$id = getURLParameter("id"), 
	$pageid = getURLParameter("pageid"), 
	$pageid = getURLParameter("pageid"), 
	$key = getURLParameter("key"), 
	$val = getURLParameter("val");
var origin_url = window.location.origin+window.location.pathname;
var dataTable1;

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
		"btn-export": 	{group:3, id:"btn-export", title:"Export", bstyle:"btn-warning", icon:"glyphicon glyphicon-save"},
		"btn-print": 		{group:3, id:"btn-print", title:"Print", bstyle:"bg-purple", icon:"glyphicon glyphicon-print"},
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
	/* Get variable Toolbar_Init */
	if (!Toolbar_Init.enable)
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

function initDataTable()
{
	/* Get variable DataTable_Init */
	if (!DataTable_Init.enable)
		return false;
	
	var tableData1 = $('<table class="table table-bordered table-hover table-striped" style="width:100%; table-layout:fixed; word-wrap:break-word; margin:0px !important;" />');
	
	$('.box-body').append( tableData1 );
	
	/* Defining Left Button for Datatables */
	var aLBtn = [];
	if (DataTable_Init.aLBtn.copy) aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs aLBtn btn-info glyphicon glyphicon-duplicate" title="Copy" name="btn-copy" />');
	if (DataTable_Init.aLBtn.edit) aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs aLBtn btn-success glyphicon glyphicon-edit" title="Edit" name="btn-edit" />');
	if (DataTable_Init.aLBtn.delete) aLBtn.push('<button type="button" style="margin-right:5px;" class="btn btn-xs aLBtn btn-danger glyphicon glyphicon-trash" title="Delete" name="btn-delete" />');
	/* Defining Right Button for Datatables */
	var aRBtn = [];
	$.each(DataTable_Init.aRBtn, function(i){
		v = DataTable_Init.aRBtn[i];
		aRBtn.push('<span><a href="#" class="aRBtn" data-pageid='+v.pageid+' data-key="'+v.key+'">'+v.title+'</a></span>');
	});
	/* Setup DataTables */
	var right_column = [];
	var left_column = [
			{ width:"20px", orderable:false, className:"dt-body-center", title:"<center><input type='checkbox' class='head-check'></center>", render:function(data, type, row){ return '<input type="checkbox" class="line-check">'; } },
			{ width:"90px", orderable:false, className:"dt-head-center dt-body-center", title:"Actions", render: function(data, type, row){ return aLBtn.join(""); } },
	];
	if (aRBtn.length > 0) {
		right_column = [
				{ width: DataTable_Init.aRBtn_width, orderable:false, className:"dt-head-center dt-body-center", title:"Sub Menu", render:function(data, type, row){ return aRBtn.join("&nbsp;-&nbsp;"); } }
		];
	}
	/* Create order params */
	var $ob = '';
	if (DataTable_Init.order.length > 0)
		$ob = '&ob='+DataTable_Init.order.join();
	/* Switching url on submodule is true */
	var url = DataTable_Init.submodule ? 
		$url_module+window.location.search+"&"+$key+"="+$val+$ob :
		$url_module+window.location.search+$ob;
	dataTable1 = tableData1.DataTable({ "pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true, "scrollX": true,
		"ajax": {
			"url": url,
			"data": function(d){ return $.extend({}, d, { "q": $q });	},
			"dataFilter": function(data){
				var json = jQuery.parseJSON( data );
				json.recordsTotal = json.data.total;
				json.recordsFiltered = json.data.total;
				json.data = json.data.rows;
				return JSON.stringify( json ); 
			}
		},
		"columns": left_column.concat(DataTable_Init.columns).concat(right_column),
		"order": []
	})
	.search($q ? $q : '');

	/* For parsing URL Parameters */
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		$q = $(this).val();
		$url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		history.pushState({}, '', origin_url +'?'+ $url);
	});		
	
	$('div.dataTables_wrapper').find('div.row:first').insertBefore('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_filter');
	$('div.dataTables_wrapper').find('div.row:last').insertAfter('div.box-body').addClass('dataTables_wrapper').addClass('dataTables_paginate');
	$('div.box').css('margin-bottom','10px');
	
	/* Init Checklist for DataTable */
	initCheckList(tableData1, dataTable1);
	/* For Left Button if Exists */
	tableData1.find('tbody').on( 'click', '.aLBtn', function (e) {
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
		
}

/* {* Don't change this code: Init for datatables checklist *} */
function initCheckList(tableData1, dataTable1){
	var datatables_scroll = $('.dataTables_wrapper').has('.dataTables_scroll');
	tableDataHead = datatables_scroll.length ? $('.dataTables_scrollHead') : tableData1;
	var head_cb = tableDataHead.find('thead input[type="checkbox"].head-check');
	
	dataTable1.on('draw.dt', function(){
		// console.log('draw.dt3');
		var count_rows = dataTable1.rows().data().length;
		var line_cb = tableData1.find('tbody input[type="checkbox"].line-check');

		tableDataHead.find('thead').on('click', 'tr', function(e){
			if ($(e.target).is("input[type='checkbox']")) {
				// console.log("Debug: Head-Check Clicked");
				var clicked = head_cb.prop('checked');
				line_cb.prop("checked", clicked);
				if (clicked) 
					dataTable1.rows().select();
				else
					dataTable1.rows().deselect();
			} else {
				// console.log("Debug: Head Clicked");
				/* Prepare for sorting datatables */
			}
		});
		
		line_cb.on('click', function(e){
			// console.log("Debug: Line-Check Clicked");
			var count_selected = dataTable1.rows('.selected').data().length;
			var count_checked = tableData1.find('tbody input[type="checkbox"]:checked').length;
			if (count_checked == 1 && count_selected == 1)
				dataTable1.rows().deselect();
			
			var clicked = $(this).prop('checked');
			if (clicked) 
				dataTable1.row( $(this).parent().parent() ).select();
			else
				dataTable1.row( $(this).parent().parent() ).deselect();
			
			count_selected = dataTable1.rows('.selected').data().length;
			head_cb.prop("checked", count_selected == count_rows ? true : false);
			e.stopPropagation();
		});
		
		tableData1.find('tbody').on('click', 'tr', function (e) {
			// console.log("Debug: table->tr clicked");
			var count_selected = dataTable1.rows('.selected').data().length;
			if (count_selected > 1){
				var selected = $(this).hasClass('selected');
				if (selected)
					$(this).parent().find('.selected input[type="checkbox"]').prop("checked", true);
				else 
					$(this).find('input[type="checkbox"]').prop("checked", false);
				
				head_cb.prop("checked", count_selected == count_rows ? true : false);
			} else {
				$(this).parent().find('input[type="checkbox"]').prop("checked", false);
				head_cb.prop("checked", false);
			}
		});
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

	/* Init for Toolbar */
	initToolbarButton();
	/* Init for DataTable */
	initDataTable();
// });

/* ========================================= */
/* Default init for dataTables  */
/* ========================================= */
// $( document ).ready(function() {
	
	
// });

	// DTHelper.initCheckList_iCheck(tableData1, dataTable1);
	// initCheckList_iCheck(tableData1, dataTable1);
	
/* ==================================== */
/* Default action for Form CRUD Toolbar */
/* ==================================== */
// $(document.body).click('button', function(e){
$('.toolbar_container').click('button', function(e){
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

