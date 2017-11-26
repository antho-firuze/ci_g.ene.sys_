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
	$filter = getURLParameter("filter"),
	$title = getURLParameter("title"),
	$method = $url_module.split('/')[4];

var origin_url = window.location.origin+window.location.pathname;
var dataTable1;

/* pushing url to browser address */
origin_url = $pageid ? URI(origin_url).addSearch('pageid', $pageid) : origin_url;
origin_url = $filter ? URI(origin_url).addSearch('filter', $filter) : origin_url;
origin_url = $q ? URI(origin_url).addSearch('q', $q) : origin_url;
origin_url = $id ? URI(origin_url).addSearch('id', $id) : origin_url;
origin_url = $title ? URI(origin_url).addSearch('title', $title) : origin_url;
history.replaceState ("", document.title, origin_url);

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
													'<div class="btn-group btnGroup6" />'+
												'</div>'+
											'</div>'+
										'</div>');
	var buttons = {
		"btn-new": 			{group:1, id:"btn-new", title:"New (Press Insert)", bstyle:"btn-success", icon:"glyphicon glyphicon-plus"},
		"btn-copy": 		{group:1, id:"btn-copy", title:"Copy", bstyle:"btn-success", icon:"glyphicon glyphicon-duplicate"},
		"btn-refresh": 	{group:1, id:"btn-refresh", title:"Clear Sorting & Refresh", bstyle:"btn-success", icon:"glyphicon glyphicon-refresh"},
		"btn-delete": 	{group:1, id:"btn-delete", title:"Batch Delete", bstyle:"btn-danger", icon:"glyphicon glyphicon-trash"},
		"btn-message": 	{group:2, id:"btn-message", title:"Chat/Message/Attach", bstyle:"btn-info", icon:"glyphicon glyphicon-comment"},
		"btn-export": 	{group:3, id:"btn-export", title:"Export", bstyle:"btn-warning", icon:"glyphicon glyphicon-save"},
		"btn-print": 		{group:3, id:"btn-print", title:"Print", bstyle:"bg-purple", icon:"glyphicon glyphicon-print"},
		"btn-import": 	{group:3, id:"btn-import", title:"Import", bstyle:"btn-warning", icon:"glyphicon glyphicon-open"},
		"btn-viewlog": 	{group:4, id:"btn-viewlog", title:"Record Info", bstyle:"btn-default", icon:"fa fa-info fa-lg", style:"width:35px; height:35px;"},
		"btn-filter": 	{group:5, id:"btn-filter", title:"Filter", bstyle:"btn-success", icon:"fa fa-filter fa-lg", style:"width:35px; height:35px;"},
		"btn-sort": 		{group:5, id:"btn-sort", title:"Sort", bstyle:"btn-success", icon:"fa fa-sort-amount-asc fa-lg", style:"width:35px; height:35px;"},
		"btn-process": 	{group:6, id:"btn-process", title:"Process", bstyle:"bg-purple", icon:"glyphicon glyphicon-cog dropdown-toggle", data_toggle:"dropdown"},
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
			// $('<li disabled />').append($('<a href="#" data-pageid='+v.pageid+' title="'+v.title+'" id="'+v.id+'" />').html(v.title)).appendTo(dropdown_menu);
			$('<li disabled />').append($('<a href="#" data-tag="btn-process" data-name="'+v.name+'" title="'+v.title+'" />').html(v.title)).appendTo(dropdown_menu);
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
	var url = $url_module;
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
	var tableColumns;
	if (DataTable_Init.showColumnMenu == false)
		tableColumns = DataTable_Init.columns;
	else 
		tableColumns = left_column.concat(DataTable_Init.columns);

	var fixedColumn;
	if (! isempty_obj(DataTable_Init.fixedColumn))
		fixedColumn = DataTable_Init.fixedColumns;
	else 
		fixedColumn = {};

	/* Create datatable params */
	/* param order by */
	var $ob = get('ob_'+$method);
	if ($ob && $ob !== 'null') {
		url = URI(url).addSearch('ob', $ob);
		store('ob_'+$method, $ob);
		$("#btn-sort").addClass("active");
	} else if (DataTable_Init.order && DataTable_Init.order.length > 0 && $ob !== 'null') {
		$ob = DataTable_Init.order.join();
		url = URI(url).addSearch('ob', $ob);
		// store('ob_'+$method, $ob);
	} else {
		remove('ob_'+$method);
		$("#btn-sort").removeClass("active");
	}
	/* param rows length */
	var $rows = get('rows_'+$method);
	if (!$rows && $rows === null) {
		if (DataTable_Init.rows && DataTable_Init.rows !== undefined) {
			$rows = DataTable_Init.rows;
		} else {
			$rows = 10;
		}
	}
	/* param filter */
	if ($filter) {
		url = URI(url).addSearch('filter', $filter);
	}
	/* param filter */
	var $sfilter = get('sfilter_'+$method);
	if ($sfilter && $sfilter !== null) {
		url = URI(url).addSearch('sfilter', $sfilter);
		store('sfilter_'+$method, $sfilter);
		$("#btn-filter").addClass("active");
	} else {
		url = URI(url).removeSearch('sfilter');
		remove('sfilter_'+$method);
		$("#btn-filter").removeClass("active");
	}
	
	dataTable1 = tableData1.DataTable({ "pagingType": 'full_numbers', "processing": true, "serverSide": true, "select": true, "scrollX": true, "iDisplayLength": DataTable_Init.length ? DataTable_Init.length : 10,
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
			}
		},
		"pageLength": $rows,
		"columns": tableColumns,
		// "createdRow": (DataTable_Init.createdRow != 'undefined' && DataTable_Init.createdRow ? DataTable_Init.createdRow : ''),
		"createdRow": DataTable_Init.createdRow,
		"order": [],
		"scrollCollapse": true,
		"fixedColumns": { leftColumns: 1 },
		"fnDrawCallback": function( oSettings ) {
			/* For adding sorting status on header table */
			update_header_by_sort_field();

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

	$('.table thead th').unbind('click.DT');
	$('.table thead th').click(function(){
		var columns = dataTable1.settings().init().columns;
		var field = columns[$(this).index()].data;
		var $ob = get('ob_'+$method);		
	
		if ($(this).hasClass('sorting_asc')) {
			$ob = enumerate_sort($ob, field, 'DESC');
		} else if ($(this).hasClass('sorting_desc')) {
			$ob = enumerate_sort($ob, field, '');
		} else {
			$ob = enumerate_sort($ob, field, 'ASC');
		}
		
		if ($ob && $ob !== 'null') {
			url = URI(url).setSearch('ob', $ob);
			store('ob_'+$method, $ob);
			dataTable1.ajax.url( url ).load();
			$("#btn-sort").addClass("active");
			// dataTable1.order([$(this).index(), 'ASC']).draw();
		}	else {
			url = URI(url).setSearch('ob', $ob);
			remove('ob_'+$method);
			dataTable1.ajax.url( url ).load();
			$("#btn-sort").removeClass("active");
		}
	});
	
	function update_header_by_sort_field() {
		var columns = dataTable1.settings().init().columns;
		var sort_dir = { "ASC":"sorting_asc", "DESC":"sorting_desc" };
		var sql = get('ob_'+$method);
		// var sql = "orgtrx_name ASC, bpartner_name DESC";
		var sort_field_exists;
		if (sql && sql !== 'null') {
			$.each(sql.split(', '), function(i, v){
				sort_field_exists = v.split(' ');
				$.each(sort_field_exists, function(j, v){
					if (j==0){
						$.each(columns, function(y, z){
							if (z.data == sort_field_exists[0]) {
								$('.table thead th').eq(y).addClass(sort_dir[sort_field_exists[1]]);
							}
						});
					}
				});
			});
		}
		$('.table thead th').focusout();
	}
	
	function enumerate_sort(sql, field, direction){
		// var sql = "orgtrx_name ASC, bpartner_name DESC";
		var sort_result = [], sort_field_exists, flag_del = -1;
		if (!sql || sql === 'null')
			return [field, direction].join(' ');
		
		if (sql.indexOf(field) >= 0) {
			$.each(sql.split(', '), function(i, v){
				sort_field_exists = v.split(' ');
				$.each(sort_field_exists, function(j, v){
					if (j==0){
						if (sort_field_exists[0] == field) {
							if ($.inArray(direction, ['ASC','DESC']) === -1)
								flag_del = i;
							else
								sort_field_exists[1] = direction;
						}		
					}
				});
				sort_result.push(sort_field_exists.join(' '));
				if (flag_del !== -1) {
					sort_result.splice(flag_del, 1);
					flag_del = -1;
				}
			});
			return sort_result.join(', ');
		} else {
			return sql + ', ' + ([field, direction].join(' '));
		}
	}
	
	/* For parsing URL Parameters */
	$('.dataTables_filter input[type="search"]').unbind().keyup(function() {
		// console.log('Datatables parsing URL Parameter for search/filter.');
		$q = $(this).val();
		// $url = insertParam('q', $q);
		dataTable1.ajax.reload( null, false );
		
		origin_url = $q ? URI(origin_url).setSearch('q', $q) : URI(origin_url).removeSearch('q');
		history.pushState({}, '', origin_url);
		// history.pushState({}, '', origin_url +'?'+ $url);
	});		
	
	$('.dataTables_length select').bind().change(function() {
		// console.log('Datatables parsing URL Parameter for search/filter.');
		$rows = $(this).val();
		store('rows_'+$method, $rows);
	});		
	
	$('div.dataTables_wrapper').find('div.row:first').insertBefore('div.datagrid').addClass('dataTables_wrapper').addClass('dataTables_filter');
	if (DataTable_Init.showFilter == false) {
		$('div.dataTables_wrapper.dataTables_filter').css('display', 'none');
	}
	$('div.dataTables_wrapper').find('div.row:last').insertAfter('div.datagrid').addClass('dataTables_wrapper').addClass('dataTables_paginate');
	if (DataTable_Init.showPaginate == false) {
		$('div.dataTables_wrapper.dataTables_paginate').css('display', 'none');
	}
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
		sub_menu.push('<li><a href="#" name="sub-menu" data-pageid='+v.pageid+' data-subKey="'+v.subKey+'" data-subType="'+v.subType+'"><span class="glyphicon glyphicon-menu-hamburger"></span>'+v.title+'</a></li>');
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
				/* BUG::Show the history double */
				// window.location.href = getURLOrigin()+window.location.search+"&action=cpy&id="+data.id;
				
				/* Fix the history double issue */
				window.location.replace(getURLOrigin()+window.location.search+"&action=cpy&id="+data.id);
				break;
			case 'edit':
				/* BUG::Show the history double */
				// window.location.href = getURLOrigin()+window.location.search+"&action=edt&id="+data.id;
				
				/* Fix the history double issue */
				window.location.replace(getURLOrigin()+window.location.search+"&action=edt&id="+data.id);
				break;
			case 'delete':
				if (!confirm(lang_confirm_delete)) {
					return false;
				}
				var $xdel = getURLParameter("xdel") ? "&xdel=1" : "";
				$.ajax({ url: $url_module+"?id="+data.id+$xdel, method: "DELETE", async: true, dataType: 'json',
					success: function(data) {
						dataTable1.ajax.reload( null, false );
						BootstrapDialog.alert(data.message);
					},
					error: function(data) {
						if (data.status >= 500){
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
				var subKey = $el.attr('data-subKey');
				var subType = $el.attr('data-subType');
				if ($filter){
					var fils = {};
					$.each($filter.split(','), function(i, v){
						fils[v.split('=')[0]] = v.split('=')[1];
					});
					var subs = {};
					/* Sub Detail Method : hierarchy or masterdetail */
					if (subType == 'hierarchy') {
						/* if using hierarchial, used only [subKey: 'parent_id'] */
						$.each(subKey.split(","), function(i, v){
							subs[v] = data.id;
						});
					} else {
						$.each(subKey.split(","), function(i, v){
							if (fils[v])
								subs[v] = fils[v];
							else
								subs[v] = data.id;
						});
					}
				} else {
					var subs = {};
					$.each(subKey.split(","), function(i, v){
						subs[v] = data.id;
					});
				}
				$filter = '&filter='+$.map(subs, function(i, v){return v+'='+i;}).join(',');
				var url = $BASE_URL+"systems/x_page"+$pageid+$filter;
				/* BUG::Show the history double */
				// window.location.href = url;
				
				/* Fix the history double issue */
				window.location.replace(url);
				break;
		}
	}
		
	tableData1.find('tbody').on( 'click', '.action-menu', function (e) {
		e.stopPropagation(); 
		/* get selected record from datatable */
		data = dataTable1.row( $(e.target).closest('tr') ).data();
		
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
				// console.log($(e.target));
				// console.log($(e.target).is("th.sorting"));
				// if ($(e.target).is("th")) {
		// dataTable1.fnSort([]);
			// console.log(dataTable1.state.loaded());
					// console.log("wooow");
					// e.stopPropagation();
					// e.preventDefault();
					// return false;
				// }
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
	// console.log($bread);
	// console.log($bread.length);
	$(document).prop('title', $HEAD_TITLE+' > '+$bread[$bread.length-1].title);
	$bread.unshift({ icon:"fa fa-dashboard", title:"Dashboard", link: "window.location.replace('"+$APPS_LNK+"')" });
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
	// console.log($(e.target).is('a'));
	if ($(e.target).is('a') && $(e.target).attr('data-tag') == 'btn-process'){
		// console.log($(e.target));
		// console.log($(e.target).attr('data-name'));
		var data = {};
		if ($filter){
			$.each($filter.split(','), function(i, v){
				data[v.split('=')[0]] = v.split('=')[1];
			});
		}
		window[$(e.target).attr('data-name')](data);
	}
	// console.log($(e.target).attr('id'));
	switch($(e.target).attr('id')){
		case 'btn-new':
			window.location.href = getURLOrigin()+window.location.search+"&action=new";
			break;
			
		case 'btn-refresh':
			if (dataTable1.order().length > 0)
				dataTable1.order([]).draw();
			else
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
						
						var $xdel = getURLParameter("xdel") ? "&xdel=1" : "";
						$.ajax({ url: $url_module+"?id="+ids.join()+$xdel, method: "DELETE", async: true, dataType: 'json',
							success: function(data) {
								dialog.close();
								dataTable1.ajax.reload( null, false );
								BootstrapDialog.alert(data.message);
							},
							error: function(data) {
								if (data.status >= 500){
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
						label: 'Cancel',
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
		case 'btn-filter':
			// if (! $.isFunction(window['func_filter'])) {
				// BootstrapDialog.alert("Database Filter is not defined !");
				// return false;
			// }	
			// window['func_filter'](data);
			if (typeof(Filter_Fields) === 'undefined') {
				BootstrapDialog.alert("Database Filter is not defined !");
				return false;
			}
			
			var col = [], row = [];
			var form1 = BSHelper.Form({ autocomplete:"off" });
			col.push($('<div id="builder" />'));
			row.push(subCol(12, col));
			form1.append(subRow(row));
			form1.on('submit', function(e){ e.preventDefault(); });
			
			var options = {
				allow_empty: true,
				sort_filters: true,
				plugins: {
					'bt-tooltip-errors': { delay: 100 },
					'sortable': null,
					'filter-description': { mode: 'bootbox' },
					// {* 'bt-selectpicker': null, *}
					'unique-filter': null,
					// {* 'bt-checkbox': { color: 'primary' }, *}
					// {* 'invert': null, *}
					// {* 'not-group': null *}
				},
				operators: [
					{ type: 'equal', optgroup: 'basic' },
					{ type: 'not_equal', optgroup: 'basic' },
					{ type: 'in', optgroup: 'basic' },
					{ type: 'not_in', optgroup: 'basic' },
					{ type: 'less', optgroup: 'numbers' },
					{ type: 'less_or_equal', optgroup: 'numbers' },
					{ type: 'greater', optgroup: 'numbers' },
					{ type: 'greater_or_equal', optgroup: 'numbers' },
					{ type: 'between', optgroup: 'numbers' },
					{ type: 'not_between', optgroup: 'numbers' },
					{ type: 'begins_with', optgroup: 'strings' },
					{ type: 'not_begins_with', optgroup: 'strings' },
					{ type: 'contains', optgroup: 'strings' },
					{ type: 'not_contains', optgroup: 'strings' },
					{ type: 'ends_with', optgroup: 'strings' },
					{ type: 'not_ends_with', optgroup: 'strings' },
					{ type: 'is_empty' },
					{ type: 'is_not_empty' },
					{ type: 'is_null' },
					{ type: 'is_not_null' }
				],
				filters: Filter_Fields,
			};

			form1.find('#builder').queryBuilder(options);
			var $method = $url_module.split('/')[4];
			var $sfilter = get('sfilter_'+$method);
			if ($sfilter && typeof($sfilter) !== null)
				form1.find('#builder').queryBuilder('setRulesFromSQL', $sfilter);

			BootstrapDialog.show({ title: 'Filter Records', type: BootstrapDialog.TYPE_SUCCESS, size: BootstrapDialog.SIZE_WIDE, message: form1,
				buttons: [{
					icon: 'glyphicon glyphicon-send',
					cssClass: 'btn-success',
					label: '&nbsp;&nbsp;Submit',
					action: function(dialog) {
						var button = this;
						button.spin();
						
						var res = form1.find('#builder').queryBuilder('getSQL', false, false);
						if (res.sql) {
							store('sfilter_'+$method, res.sql);
							var url = URI(dataTable1.ajax.url()).removeSearch('sfilter').addSearch('sfilter', res.sql);
							$("#btn-filter").addClass("active");
						}	else {
							remove('sfilter_'+$method);
							var url = URI(dataTable1.ajax.url()).removeSearch('sfilter');
							$("#btn-filter").removeClass("active");
						}
						dataTable1.ajax.url( url ).load();
						dialog.close();
					}
				}, {
						label: 'Cancel',
						action: function(dialog) { dialog.close(); }
				}],
				onshown: function(dialog) {
				}
			}); 
			break;
		case 'btn-sort':
			// if (! $.isFunction(window['func_sort'])) {
				// BootstrapDialog.alert("Database Sorting is not defined !");
				// return false;
			// }	
			// window['func_sort'](data);
			if (typeof(Sorting_Fields) === 'undefined') {
				BootstrapDialog.alert("Database Sorting is not defined !");
				return false;
			}
			
			$.each(Sorting_Fields, function(i, v){
				Sorting_Fields[i]['unique'] = true;
			});
			
			var col = [], row = [];
			var form1 = BSHelper.Form({ autocomplete:"off" });
			col.push($('<div id="builder" />'));
			row.push(subCol(12, col));
			form1.append(subRow(row));
			form1.on('submit', function(e){ e.preventDefault(); });
			
			var options = {
				conditions: ['AND'],
				allow_empty: true,
				allow_groups: false,
				plugins: {
					'bt-tooltip-errors': { delay: 100 },
					'unique-filter': null,
				},
				operators: [
					{ type: 'asc' },
					{ type: 'desc' }
				],
				filters: Sorting_Fields,
			};

			form1.find('#builder').queryBuilder(options);
			var $method = $url_module.split('/')[4];
			var $ob = get('ob_'+$method);
			if ($ob && typeof($ob) !== null) {
				var rules = [];
				$.each($ob.split(', '), function(k, v){
					rules.push({ "id":v.split(' ')[0], "operator":v.split(' ')[1].toLowerCase() }); 
				});
				form1.find('#builder').queryBuilder('setRules', { "condition":"AND", "rules":rules });
			}

			BootstrapDialog.show({ title: 'Sorting Records', type: BootstrapDialog.TYPE_SUCCESS, message: form1,
				buttons: [{
					icon: 'glyphicon glyphicon-send',
					cssClass: 'btn-success',
					label: '&nbsp;&nbsp;Submit',
					action: function(dialog) {
						var button = this;
						button.spin();
						
						var res = form1.find('#builder').queryBuilder('getSQL', false, false);
						if (res.sql) {
							store('ob_'+$method, res.sql.split(' AND').join());
							var url = URI(dataTable1.ajax.url()).removeSearch('ob').addSearch('ob', res.sql.split(' AND').join());
							$("#btn-sort").addClass("active");
						}	else {
							remove('ob_'+$method);
							var url = URI(dataTable1.ajax.url()).removeSearch('ob');
							$("#btn-sort").removeClass("active");
						}
						dataTable1.ajax.url( url ).load();
						dialog.close();
					}
				}, {
						label: 'Cancel',
						action: function(dialog) { dialog.close(); }
				}],
				onshown: function(dialog) {
				}
			}); 
			break;
	}
});

/* Tricky for removing hash-tags(#), while any link added '#' to the URL. Ex: Calling BootstrapDialog, etc. */
$(window).on('hashchange', function(e){
	// var hash = location.hash.replace(/^#/, '');
	// var hash = location.href.indexOf('#');
	// console.log(hash);
	// console.log('url-hash-change');
	// console.log(document.title);
	// console.log(e.originalEvent.oldURL);
	history.replaceState ("", document.title, e.originalEvent.oldURL);
	// if (hash >= -1)
		// window.history.back();
});

/* This class is for auto conversion from dmy to ymd */
$(".auto_ymd").on('change', function(){
	$('input[name="'+$(this).attr('id')+'"]').val( datetime_db_format($(this).val(), $(this).attr('data-format')) );
});

$(window).on('keyup', function(e){
	/* Insert */
	if (e.keyCode == 45) {
		$("#btn-new").trigger('click');
	}
});
