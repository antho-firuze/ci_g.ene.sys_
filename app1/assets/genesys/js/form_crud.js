/*!
 * form_crud.js v1.0.0
 * Copyright 2016, Ahmad Firuze
 *
 * Freely distributable under the MIT license.
 * Portions of G.ENE.SYS Ultimate - Manufacturing Systems
 *
 * A functions for build CRUD Form
 */
/* 
	$.each(btn, function(k,v){
		if (k=='btn-copy') 
				if (v)
					btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-duplicate" title="Copy" id="btn-copy" />'));
				else
					
		
  }); */
function setToolbarButton(){
	var container = $('<div class="row"><div class="col-md-12"><div class="btn-toolbar"><div class="btn-group btnGroup1" /><div class="btn-group btnGroup2" /><div class="btn-group btnGroup3" /><div class="btn-group btnGroup4" /></div></div></div>');
	var btnGroup1 = container.find('.btnGroup1'); 
	var btnGroup2 = container.find('.btnGroup2'); 
	var btnGroup3 = container.find('.btnGroup3'); 
	var btnGroup4 = container.find('.btnGroup4'); 
	
	btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-duplicate" title="Copy" id="btn-copy" />'));
	btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-plus" title="New" id="btn-new" />'));
	btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-refresh" title="Refresh" id="btn-refresh" />'));
	btnGroup1.append($('<button type="button" class="btn btn-danger glyphicon glyphicon-trash" title="Delete" id="btn-delete" />'));
	btnGroup2.append($('<button type="button" class="btn btn-info glyphicon glyphicon-comment" title="Chat/Message/Attach" id="btn-message" />'));
	btnGroup3.append($('<button type="button" class="btn bg-purple glyphicon glyphicon-print" title="Print" id="btn-print" />'));
	btnGroup3.append($('<button type="button" class="btn btn-warning glyphicon glyphicon-open" title="Export" id="btn-export" />'));
	btnGroup3.append($('<button type="button" class="btn btn-warning glyphicon glyphicon-save" title="Import" id="btn-import" />'));
	btnGroup4.append($('<button type="button" class="btn bg-purple glyphicon glyphicon-cog dropdown-toggle" data-toggle="dropdown" title="Process" id="btn-process" /><ul class="dropdown-menu" />'));

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
/* function setToolbarButton(btn){
	if(typeof(btn)==='undefined') btn = [];
	var container = $('<div class="row"><div class="col-md-12"><div class="btn-toolbar"><div class="btn-group btnGroup1" /><div class="btn-group btnGroup2" /><div class="btn-group btnGroup3" /><div class="btn-group btnGroup4" /></div></div></div>');
	var btnGroup1 = container.find('.btnGroup1'); 
	var btnGroup2 = container.find('.btnGroup2'); 
	var btnGroup3 = container.find('.btnGroup3'); 
	var btnGroup4 = container.find('.btnGroup4'); 
	
	if ($.inArray('btn-copy', btn)>=0)
		btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-duplicate" title="Copy" id="btn-copy" />'));
	if ($.inArray('btn-new', btn)>=0)
		btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-plus" title="New" id="btn-new" />'));
	if ($.inArray('btn-refresh', btn)>=0)
		btnGroup1.append($('<button type="button" class="btn btn-success glyphicon glyphicon-refresh" title="Refresh" id="btn-refresh" />'));
	if ($.inArray('btn-delete', btn)>=0)
		btnGroup1.append($('<button type="button" class="btn btn-danger glyphicon glyphicon-trash" title="Delete" id="btn-delete" />'));
	
	if ($.inArray('btn-message', btn)>=0)
		btnGroup2.append($('<button type="button" class="btn btn-info glyphicon glyphicon-comment" title="Chat/Message/Attach" id="btn-message" />'));
	
	if ($.inArray('btn-print', btn)>=0)
		btnGroup3.append($('<button type="button" class="btn bg-purple glyphicon glyphicon-print" title="Print" id="btn-print" />'));
	if ($.inArray('btn-export', btn)>=0)
		btnGroup3.append($('<button type="button" class="btn btn-warning glyphicon glyphicon-open" title="Export" id="btn-export" />'));
	if ($.inArray('btn-import', btn)>=0)
		btnGroup3.append($('<button type="button" class="btn btn-warning glyphicon glyphicon-save" title="Import" id="btn-import" />'));
	
	if ($.inArray('btn-process', btn)>=0)
		btnGroup4.append($('<button type="button" class="btn bg-purple glyphicon glyphicon-cog dropdown-toggle" data-toggle="dropdown" title="Process" /><ul class="dropdown-menu" />'));

	return container;
} */

