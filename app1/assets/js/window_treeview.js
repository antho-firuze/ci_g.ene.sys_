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
	$filter = getURLParameter("filter");

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
		"btn-delete": 	{group:1, id:"btn-delete", title:"Batch Delete", bstyle:"btn-danger", icon:"glyphicon glyphicon-trash"},
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
			$('<li disabled />').append($('<a href="#" data-pageid='+v.pageid+' title="'+v.title+'" id="'+v.id+'" />').html(v.title)).appendTo(dropdown_menu);
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
	
	tableWidth = (DataTable_Init.tableWidth) ? DataTable_Init.tableWidth : '100%';
	var tableData1 = $('<table class="table table-bordered table-hover table-striped" style="width:'+tableWidth+'; table-layout:fixed; word-wrap:break-word; margin:0px !important;" />');
	
	$('div.datagrid').append( tableData1 );
	
	/* Defining Left Button for Datatables */
	var act_menu_container = $('<div class="dropdown" />');
	act_menu_container.append($('<button type="button" class="btn btn-xs action-menu btn-info glyphicon glyphicon-align-justify" title="Menu" name="btn-menu" />'));
	
	var left_column = [
			{ width:"10px", orderable:false, className:"dt-body-center", title:"<center><input type='checkbox' class='head-check'></center>", render:function(data, type, row){ return '<input type="checkbox" class="line-check">'; } },
			{ width:"10px", orderable:false, className:"dt-head-center dt-body-center", title:"", render: function(data, type, row){ return act_menu_container.prop('outerHTML'); } },
	];
	
	/* TREEVIEW START */
	if (DataTable_Init.treeView) {
		var g_dataFull = [];
		left_column.push({ width:"10px", orderable:false, className:"dt-head-center dt-body-center details-control", title:"", render: function(data, type, row){ return ""; } });
	}
	/* TREEVIEW END */

	/* Create order params */
	var $ob = '';
	if (DataTable_Init.order)
		if (DataTable_Init.order.length > 0)
			$ob = '&ob='+DataTable_Init.order.join();
	var url = $url_module+window.location.search+$ob;
	dataTable1 = tableData1.DataTable({ "pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true, "scrollX": true,
		"ajax": {
			"url": url,
			"data": function(d){ return $.extend({}, d, { "q": $q });	},
			"dataFilter": function(data){
				if (data) {
					var json = jQuery.parseJSON( data );
					json.recordsTotal = json.data.total;
					json.recordsFiltered = json.data.total;
					json.data = json.data.rows;
					return JSON.stringify( json ); 
				}
			},
			/* TREEVIEW START */
			"dataSrc": function(d){
				 g_dataFull = d.data;
				 console.log(d.data);
				 var dataParent = []
				 $.each(d.data, function(){
					 // console.log(this.parent_id);
						if(this.parent_id === null){
							 dataParent.push(this);  
						}
				 });
				 // console.log(dataParent);
				 return dataParent;
			}
			/* TREEVIEW END */
		},
		"columns": left_column.concat(DataTable_Init.columns),
		"order": [],
		"fnDrawCallback": function( oSettings ) {
			/* For Adding Tooltip to the "tr body datatables" */
			if (oSettings.aoData.length < 1)
				return;
			
			if (!DataTable_Init.tooltips)
				return;
			
			$.each(tableData1.find('tbody').children('tr'), function(i){
				var data = dataTable1.row( $(this) ).data();
				var title = '';
				$.each(DataTable_Init.columns, function(i, val){
					if (val.render)
						var t = val.render(data[val.data], '', data);
					else 
						var t = data[val.data];
					title += val.title +' : '+ (t ? t : '') +'\n';
				});
				$(this).attr('title', title);
			});
		},
		/* "footerCallback": function ( row, data, start, end, display ) {
			if (typeof DataTable_Init.footerCallback !== 'undefined')
				DataTable_Init.footerCallback( row, data, start, end, display );
		}, */
		/* "footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;
			console.log($( api.column( 4 ).footer() ));
			$( api.column( 4 ).footer() ).html(
					'123456789'
			);
		}, */
	})
	.search($q ? $q : '');

	/* TREEVIEW START */
	
	function format ( tr, d ) {
    var html;
      
    var dataChild = [];
    var hasChildren = false;
		var el_tr = $('<tr />');
    $.each(g_dataFull, function(){
       if(this.parent_id === d.id){
				 
				 $.each($(tr.prop('innerHTML')), function(i){
					 if (i < 3) {
						 if (i == 2)
							el_tr.append( $($(tr.prop('innerHTML'))[i]).removeClass('details-control') ); 
						 else
							el_tr.append( $(tr.prop('innerHTML'))[i] );
					 } else {
						 //el_tr.append( $($(tr.prop('innerHTML'))[i]).text(this.{}) );
					 }
				 });
					/* el_tr
						.data(this)
						.append( $(tr.prop('innerHTML'))[0] )
						.append( $(tr.prop('innerHTML'))[1] )
						.append( $($(tr.prop('innerHTML'))[2]).removeClass('details-control') )
						.append( $('<td />').text(this.code_name) )
						.append( $('<td />').text(this.description) )
						.append( $('<td />').text(this.is_active=='1' ? 'Y' : 'N') )
						.append( $('<td />').text(this.is_sotrx=='1' ? 'Y' : 'N') ); */
         /*  html += 
            '<tr>' +
						$(tr.prop('innerHTML'))[0].outerHTML + 
						$(tr.prop('innerHTML'))[1].outerHTML + 
						$(tr.prop('innerHTML'))[2].outerHTML + 
						'<td>' + $('<div>').text(this.code_name).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.description).html() + '</td>' + 
            '<td>' +  $('<div>').text(this.is_active).html() +'</td>' + 
            '<td>' +  $('<div>').text(this.is_sotrx).html() + '</td>' +
						'</tr>'; */
         
          hasChildren = true;
       }
    });
  
    if(!hasChildren){
        html += '<tr><td>There are no items in this view.</td></tr>';
     
    }
    // return html;
    return el_tr;
	}
	
	tableData1.find('tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = dataTable1.row( tr );
		var td = $(dataTable1.cell(this));
		console.log($($(tr.prop('innerHTML'))[2]).hasClass('details-control'));

		if ( row.child.isShown() ) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			// Open this row
			row.child( format(tr, row.data()) ).show();
			tr.addClass('shown');
		}
	});
	
	/* TREEVIEW END */
	
	/* For parsing URL Parameters */
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		$q = $(this).val();
		$url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		history.pushState({}, '', origin_url +'?'+ $url);
	});		
	
	$('div.dataTables_wrapper').find('div.row:first').insertBefore('div.datagrid').addClass('dataTables_wrapper').addClass('dataTables_filter');
	$('div.dataTables_wrapper').find('div.row:last').insertAfter('div.datagrid').addClass('dataTables_wrapper').addClass('dataTables_paginate');
	$('div.box').css('margin-bottom','10px');
	
	/* Init Checklist for DataTable */
	initCheckList(tableData1, dataTable1);
	/* Init ActionMenu for DataTable */
	initActionMenu(tableData1, dataTable1);
}

/* {* Don't change this code: Init for datatables action menu *} */
function initActionMenu(tableData1, dataTable1)
{
	var data, shown;
	var dropdown_menu = $('<ul class="dropdown-menu" />');
	
	/* Defining Action Menu */
	if (DataTable_Init.act_menu.copy) dropdown_menu.append('<li><a href="#" name="copy"><span class="glyphicon glyphicon-duplicate"></span>Copy</a></li>');
	if (DataTable_Init.act_menu.edit) dropdown_menu.append('<li><a href="#" name="edit"><span class="glyphicon glyphicon-edit"></span>Edit</a></li>');
	if (DataTable_Init.act_menu.delete) dropdown_menu.append('<li><a href="#" name="delete"><span class="glyphicon glyphicon-remove"></span>Delete</a></li>');

	/* Defining Additional Menu */
	var add_menu = [];
	$.each(DataTable_Init.add_menu, function(i){
		v = DataTable_Init.add_menu[i];
		add_menu.push('<li><a href="#" name="add-menu" data-name="'+v.name+'"><span class="glyphicon glyphicon-cog"></span>'+v.title+'</a></li>');
	});
	if (! isempty_arr(add_menu)) {
		dropdown_menu.append('<li role="separator" class="divider"></li>');
		dropdown_menu.append(add_menu);
	}
	
	/* Defining Sub Menu */
	var sub_menu = [];
	$.each(DataTable_Init.sub_menu, function(i){
		v = DataTable_Init.sub_menu[i];
		sub_menu.push('<li><a href="#" name="sub-menu" data-pageid='+v.pageid+' data-subKey="'+v.subKey+'"><span class="glyphicon glyphicon-menu-hamburger"></span>'+v.title+'</a></li>');
	});
	if (! isempty_arr(sub_menu)) {
		dropdown_menu.append('<li role="separator" class="divider"></li>');
		dropdown_menu.append(sub_menu);
	}

	var $menu = dropdown_menu;
	
	$menu
		.appendTo('body')
		.find('a').on('click', function(e){
			select($(this));
			hide();
		});
		
	$(document).click(function() {
		if (shown) hide();
	});
	
	function toggle(e){
		if (shown) 
			hide()
		else 
			show(e);
	}
	
	function show(e){
		var top;
		var pos = $.extend({}, {top: $(e.target).offset().top}, {left: $(e.target).offset().left}, {height: $(e.target)[0].offsetHeight}, {width: $(e.target)[0].offsetWidth});
		if ((pos.top + pos.height + $menu.height()) > window.innerHeight) {
			top = pos.top - pos.height - $menu.height() + 6;
		} else {
			top = pos.top + pos.height;
		}
		$menu
			.css({top: top, left: pos.left, position: 'absolute'})
			.show();
		shown = true;
	}
	
	function hide(){
		$menu.hide();
		shown = false;
	}
		
	function select($el) 
	{
		switch($el.attr('name')){
			case 'copy':
				if (!confirm(lang_confirm_copy)) {
					return false;
				}
				window.location.href = getURLOrigin()+window.location.search+"&action=cpy&id="+data.id;
				break;
			case 'edit':
				window.location.href = getURLOrigin()+window.location.search+"&action=edt&id="+data.id;
				break;
			case 'delete':
				if (!confirm(lang_confirm_delete)) {
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
			case 'add-menu':
				window[$el.attr('data-name')](data);
				break;
			case 'sub-menu':
				/* Set Main Title & code_name to Cookies */
				$pageid = '?pageid='+$pageid+','+$el.attr('data-pageid');
				if ($filter){
					$filter = '&filter='+$filter+','+$el.attr('data-subKey') + '=' + data.id;
				} else {
					$filter = '&filter='+$el.attr('data-subKey') + '=' + data.id;
				}
				var url = $BASE_URL+"systems/x_page"+$pageid+$filter;
				window.location.href = url;
				break;
		}
	}
		
	tableData1.find('tbody').on( 'click', '.action-menu', function (e) {
		e.stopPropagation(); 
		/* get selected record from datatable */
		debugger;
		data = dataTable1.row( $(e.target).closest('tr') ).data();
		if (data == undefined)
			data = $(e.target).closest('tr').data();
		
		toggle(e);
		
    return false;
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
	$bread.unshift({ icon:"fa fa-dashboard", title:"Dashboard", link: "window.location.href = '"+$APPS_LNK+"'" });
	$(".content").before(BSHelper.PageHeader({ 
		bc_list: $bread
	}));

	/* Init for Toolbar */
	initToolbarButton();
	/* Init for DataTable */
	initDataTable();
// });

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
				BootstrapDialog.alert(lang_notif_choose_record);
				return false;
			}
			$.getJSON($url_module, { viewlog:1, pageid:$pageid, id:data[0].id }, function(result){ 
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
				BootstrapDialog.alert(lang_notif_choose_record);
				return false;
			}
			var tblConfirm = BSHelper.Table({
					data: data,	rowno: true, showheader: true, maxrows: 3, isConfirm: true, title: lang_confirm_delete,
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
			window.location.href = getURLOrigin()+window.location.search+"&action=exp";
			break;
		case 'btn-import':
			window.location.href = getURLOrigin()+window.location.search+"&action=imp";
			break;
	}
});

$(window).on('hashchange', function(e){
	history.replaceState ("", document.title, e.originalEvent.oldURL);
});

