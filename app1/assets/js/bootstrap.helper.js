(function (root, factory) {

    "use strict";

    // CommonJS module is defined
    if (typeof module !== 'undefined' && module.exports) {
        var isNode = (typeof process !== "undefined");
        var isElectron = isNode && ('electron' in process.versions);
        if (isElectron) {
            root.BSHelper = factory(root.jQuery);
        } else {
            module.exports = factory(require('jquery'), require('bootstrap'));
        }
    }
    // AMD module is defined
    else if (typeof define === "function" && define.amd) {
        define("bootstrap-helper", ["jquery", "bootstrap"], function ($) {
            return factory($);
        });
    } else {
        // planted over the root!
        root.BSHelper = factory(root.jQuery);
    }

}(this, function ($) {

    "use strict";
	
	var BSHelper = {};
	
	BSHelper.version = '1.0.0';
	
	BSHelper.newGuid = function(){
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
			var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	};

	BSHelper.WidgetBox3 = function(options){
		var default_opts = {
			color: '',
			title: '',
			value: 0,
			icon: '',
			link: '',
		}
		var o = $.extend( {}, default_opts, options );
		var link = o.link ? '<a href="'+o.link+'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>' : '<div class="small-box-footer">&nbsp;</div>';
		return $('<div class="col-lg-3 col-xs-6">'+
								'<div class="small-box '+o.color+'">'+
									'<div class="inner"><h3>'+o.value+'</h3><p style="white-space: nowrap;">'+o.title+'</p></div>'+
									'<div class="icon"><i class="'+o.icon+'"></i></div>'+
									link +
								'</div>'+
							'</div>');
	}
	
	BSHelper.PageHeader = function(options){
		var default_opts = {
			cls: '',
			bc_list: [],	// [{icon:"", title:"", link:""}, {icon:"", title:"", link:""}]
		}
		var o = $.extend( {}, default_opts, options );
		var header = $('<section class="content-header" />');
		
		var t = o.bc_list[o.bc_list.length-1];
		
		var title_desc = t.title_desc ? $('<small />').html(t.title_desc) : $('<small />');
		header.append( $('<h1 />').html(t.title).append(title_desc) );
		
		var countlist = o.bc_list.length;
		if (countlist > 0) {
			var ol = $('<ol class="breadcrumb" />');
			$.each(o.bc_list, function(j){
				var link 	= o.bc_list[j]['link'];
				var icon 	= o.bc_list[j]['icon'];
				var title = icon ? '<i class="'+icon+'" />&nbsp;'+o.bc_list[j]['title'] : o.bc_list[j]['title'];
				var li = $('<li />');
				if (j == (countlist-1)) {
					li.addClass('active').html(title);
				} else {
					li.append( $('<a href="#" onclick="'+link+'; return false;" />').html(title) );
				}
				ol.append(li);
			});
			ol.appendTo(header);
		}
		return header;
	}
	
	BSHelper.Form = function(options){
		var default_opts = {
			cls: '',
			autocomplete: 'on',
			action: '',
			enctype: 'application/x-www-form-urlencoded', // application/x-www-form-urlencoded, multipart/form-data, text/plain
			method: 'get',	// get, post
			idname: '',
			target: '_blank',	// _blank, _self, _parent, _top
			novalidate: true,
		}
		var o = $.extend( {}, default_opts, options );
		var form = $('<form />');
		form.attr('autocomplete', o.autocomplete);
		form.attr('enctype', o.enctype);
		form.attr('target', o.target);
		form.attr('method', o.method);
		form.attr('novalidate', o.novalidate);
		if (o.cls) form.addClass(o.cls);
		if (o.action) form.attr('action', o.action);
		if (o.idname) { form.attr('id', o.idname); form.attr('name', o.idname); }
		return form;
	};
	
	BSHelper.Box = function(options){
		var default_opts = {
			cls: '',
			title: '',
			idname: '',
			header: false,
			footer: false,
			type: 'default', // default, primary, info, warning, success, danger
			toolbtn: [],
		}
		var o = $.extend( {}, default_opts, options );
		var box = $('<div class="box">'+
									'<div class="box-body"></div>'+
								'</div>');
		var box_header = $('<div class="box-header" />');
		var box_footer = $('<div class="box-footer" />');
		var box_body = box.find('.box-body');
		
		
		if (o.header) box_header.insertBefore(box_body);
		if (o.title) box_header.append($('<h3 class="box-title" />').html(o.title));
		var toolb = [];
		$.each(o.toolbtn, function(i, val){
			if (val == 'min')
				toolb.push($('<button type="button" class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>'));
			if (val == 'rem'){
				toolb.push("&nbsp;");
				toolb.push($('<button type="button" class="btn btn-info btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>'));
			}
		});
		if (toolb) 
			box_header.append($('<div class="pull-right box-tools">').append(toolb));
		if (o.footer) box_footer.insertAfter(box_body);
		if (o.cls) box.addClass(o.cls);
		if (o.idname) { box.attr('id', o.idname); box.attr('name', o.idname); }
		switch (o.type){
		case 'primary':
			box.addClass('box-primary');
			break;
		case 'info':
			box.addClass('box-info');
			break;
		case 'warning':
			box.addClass('box-warning');
			break;
		case 'success':
			box.addClass('box-success');
			break;
		case 'danger':
			box.addClass('box-danger');
			break;
		default:
			break;
		}
		return box;
	};
	
	/* 
	*	BSHelper.Tabs({dataList:[ title:"", idname:"", content:"" ]}); 
	*	BSHelper.Tabs({dataList:[ title:"", idname:"", content:function(){ return ""; } ]}); 
	*					 
	*/
	BSHelper.SmartWizard = function(options){
		var default_opts = {
			cls: '',
			bc_list: [],	// [{icon:"", title:"", link:""}, {icon:"", title:"", link:""}]
		}
		var o = $.extend( {}, default_opts, options );
		var container = $('<div class="smartwizard"><ul></ul><div></div></div>');
		var header = container.find('ul');
		var body = container.find('div');

		var n = 1;
		$.each(o.dataList, function(i) {
			var idname = o.dataList[i]['idname'];
			var step = 'Step '+n;
			var title = '<br /><small>'+o.dataList[i]['title']+'</small>';
			var content = o.dataList[i]['content'];
			header.append( $('<li><a href="#'+idname+'">'+step+title+'</a></li>') );
			body.append( $('<div id="'+idname+'" />').html(content) );
			n++;
		});
		
		return container;
	};
	
	/* 
	*	BSHelper.Tabs({dataList:[ title:"", idname:"", content:"" ]}); 
	*	BSHelper.Tabs({dataList:[ title:"", idname:"", content:function(){ return ""; } ]}); 
	*					 
	*/
	BSHelper.Tabs = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var container = $('<div class="nav-tabs-custom"><ul class="nav nav-tabs"></ul><div class="tab-content"></div></div>');
		var header = container.find('ul.nav-tabs');
		var body = container.find('.tab-content');

		var n = 1;
		$.each(o.dataList, function(i) {
			var active = (n==1)?'active':'';
			var idname = o.dataList[i]['idname'];
			var title = o.dataList[i]['title'];
			var content = o.dataList[i]['content'];
			$('<li class="'+active+'"><a href="#'+idname+'" data-toggle="tab">'+title+'</a></li>').appendTo(header);
			$('<div class="'+active+' tab-pane" id="'+idname+'" />').html(content).appendTo(body);
			n++;
		});
		
		return container;
	};
	
	/* 
	*	BSHelper.Accordion({dataList:[ title:"", paneltype:"", content:"" ]}); 
	*	BSHelper.Accordion({dataList:[ title:"", paneltype:"", content:function(){ return ""; } ]}); 
	*	 
	*	options: dataList 
	*					 
	*/
	BSHelper.Accordion = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var id = 'accordion'+BSHelper.newGuid();
		var container = $('<div class="panel-group" id="'+id+'" />');

		$.each(o.dataList, function(i){
			var id2 = 'collapse'+BSHelper.newGuid();
			var title = o.dataList[i]['title'];
			var paneltype = o.dataList[i]['paneltype'];
			var content = o.dataList[i]['content'];
			var panel = $('<div class="panel panel-'+paneltype+'" />');
			
			panel.append( $('<div class="panel-heading" />')
				.append( $('<h4 class="panel-title" />')
					.append( $('<a style="display:table; table-layout:fixed; width:100%;" data-toggle="collapse" data-parent="#'+id+'" href="#'+id2+'" />')
						.append( $('<div style="display:table-cell; width:90%; overflow:hidden; text-overflow:ellipsis" />')
							.html(title) )
						.append( $('<span class="pull-right glyphicon glyphicon-triangle-bottom"></span>') ) ) ) );
			panel.append( $('<div id="'+id2+'" class="panel-collapse collapse" />')
				.append( $('<div class="panel-body" />')
					.html(content) ) );
					
			container.append(panel)
		});
		
		return container;
	};
	
	BSHelper.Label = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		// var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var lblname = o.label ? '&nbsp;<span style="color:'+(o.required ? 'red' : 'black')+';vertical-align:-webkit-baseline-middle;white-space:nowrap;">'+o.label+(o.required ? ' *' : '')+'</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');

		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		container.find('.control-input').append(o.elcustom);
		return container;
	};
	
	BSHelper.Input = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		// var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var lblname = o.label ? '&nbsp;<span style="color:'+(o.required ? 'red' : 'black')+';vertical-align:-webkit-baseline-middle;white-space:nowrap;">'+o.label+(o.required ? ' *' : '')+'</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');
		var el = (o.type == 'textarea') ? 'textarea' : 'input';
		var input = $('<'+el+' />', {class: "form-control", id:o.idname, name:o.idname, value:o.value}); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');

		/* type=textarea => el=textarea,type='' */
		/* type=text,email,url,number,hidden => el=input,type=type */
		/* type=date => el=input,type=text */
		/* type=time => el=input,type=text */
		/* type=datetime => el=input,type=text */
		var thetype = o.type;
		switch (thetype.toLowerCase()){
			case 'hidden':
				input.attr('type',o.type);
				return input;
				break;
			case 'text':
				input.attr('placeholder',(o.placeholder) ? o.placeholder : 'string(60)');
				input.attr('type',o.type);
				if (o.format) input.attr('data-inputmask',o.format);
				if (o.pattern) input.attr('pattern',o.pattern);
				input.attr('data-mask','');
				break;
			case 'number':
				if (o.step) input.attr('step',o.step);		
				if (o.min) input.attr('min',o.min);		
				if (o.max) input.attr('max',o.max);		
				input.attr('placeholder',(o.placeholder) ? o.placeholder : 'number');
				input.attr('type',o.type);
				break;
			case 'email':
			case 'password':
			case 'url':
			case 'color':
			case 'month':
			case 'datetime-local': 
				input.attr('type',o.type);
				break;
			case 'date':
				var input2 = $('<'+el+' />', {id:o.idname, name:o.idname, value:o.value}); 
				input2.attr('type','hidden');
				
				input.attr('type','text');
				input.removeAttr('name');
				if (o.min) input.attr('min',o.min);		// format yyyy-mm-dd
				if (o.max) input.attr('max',o.max);		// format yyyy-mm-dd
				if (o.format) {
					input.attr('data-format',o.format);
					input.attr('data-inputmask',"'alias':'"+o.format+"'");
				}
				input.attr('data-mask','');
				break;
			case 'textarea':
				input.attr('placeholder',(o.placeholder) ? o.placeholder : 'string(2000)');
				break;
			case 'time':
			case 'datetime':
			default:
				break;
		}
		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (!o.label) { container.find('label').remove(); /* container.removeClass('form-group'); */ }
		if (o.required) input.attr('required',''); 
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		if (o.onfocus) input.attr('onfocus',o.onfocus);
		if (o.onchange) input.attr('onchange',o.onchange);
		if (o.minlength) input.attr('data-minlength',o.minlength);
		if (o.idmatch) input.attr('data-match','#'+o.idmatch);
		if (o.errormatch) input.attr('data-match-error',o.errormatch);
		if (o.cls) input.addClass(o.cls);
		if (o.style) input.attr('style', o.style);
		if (o.role) input.attr('data-role', o.role);
		
		if (thetype.toLowerCase() == 'date') 
			container.find('.control-input').append(input).append(input2).append(help);
		else
			container.find('.control-input').append(input).append(help);
		
		// if (o.hidden) { input.attr('style','display:none;'); return input; }
		if (o.hidden) { input.closest(".form-group").css("display", "none"); }
		
		return container;
	};
	
	BSHelper.Button = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var button = $('<button />', {class: "btn", id: o.idname, name: o.idname, type: o.type }).html(o.label); 
		button.addClass(o.cls?o.cls:'btn-primary');

		if (o.disabled) button.attr('disabled','');
		if (o.style) button.attr('style', o.style);
		if (o.onclick) button.attr('onclick',o.onclick);
		return button;
	};
	
	BSHelper.Checkbox = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input checkbox"></div></div>');
		var input = $('<input>', {id:o.idname, name:o.idname, type:"checkbox", class:"checkbox"}); 
		var input2 = $('<input>', {id:o.idname, name:o.idname, type:"hidden", class:"checkbox", value:0}); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');

		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		if (parseInt(o.value)) input.prop("checked", true);
		
		container.find('.control-input').append(input).append(input2).append(help);
		// input.iCheck({ checkboxClass: 'icheckbox_flat-orange', radioClass: 'iradio_flat-orange'	});
		return container;
	};

	/* 
	*		Sample: 
	*		BSHelper.Combogrid({ horz:false, label:"Role", idname:"role_id", textField:"code_name", url:"{$.php.base_url('systems/a_user_role')}", isLoad:true });
	*/
	BSHelper.Combogrid = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lbllink = o.label_link ? '<a href="'+o.label_link+'">'+o.label+'</a>' : o.label;
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+lbllink+' *</span>' : lbllink;
		var placeholder = o.placeholder ? o.placeholder : "typed or choose";
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');
		var input = $('<input>', { class: "form-control", id: o.idname, name: o.idname, type: 'text', placeholder: placeholder, value: o.value,	autocomplete: "off" }); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');

		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (o.url) input.attr('data-url',o.url);
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		container.find('.control-input').append(input).append(help);
		
		input.shollu_cg({ 
			url: o.url,
			idField: o.idField ? o.idField : 'id',
			textField: o.textField ? o.textField : 'name',
			emptyMessage: o.emptyMessage ? o.emptyMessage : '<center><b>No results were found</b></center>',
			remote: o.remote,
			addition: o.addition,
			list: o.list,
		});
		
		return container;
	};
	
	/* 
	*		Sample: 
	*		BSHelper.Combobox({ horz:false, label:"Role", idname:"role_id", list:{ "1":"One", "2":"Two" } });
	*		BSHelper.Combobox({ horz:false, label:"Role", idname:"role_id", 
	*			list:[ 
	*				{ id:"1", name:"One", default:true },
	*				{ id:"2", name:"Two" },
	*			] 
	*		});
	*/
	BSHelper.Combobox = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lbllink = o.label_link ? '<a href="'+o.label_link+'">'+o.label+'</a>' : o.label;
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+lbllink+' *</span>' : lbllink;
		var placeholder = o.placeholder ? o.placeholder : "typed or choose";
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');
		var input = $('<input />', { class: "form-control", id: o.idname, name: o.idname, type: 'text', placeholder: placeholder, value: o.value,	autocomplete: "off" }); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');

		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (o.url) input.attr('data-url',o.url);
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		container.find('.control-input').append(input).append(help);
		
		if (o.hidden) { input.closest(".form-group").css("display", "none"); }
		
		input.shollu_cb({
			url: o.url,
			idField: o.idField ? o.idField : 'id',
			textField: o.textField ? o.textField : 'name',
			emptyMessage: o.emptyMessage ? o.emptyMessage : '<center><b>No results were found</b></center>',
			remote: o.remote ? true : false,
			addition: o.addition,
			list: o.list,
		});
		
		return container;
	};
	
	BSHelper.LineDesc = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		if(typeof(o.reference)==='undefined') {
			if ($.isNumeric(o.value)) {
				var val = parseInt(o.value);
				if (val <= 1){
					o.value = parseInt(o.value)?'Yes':'No';
				}
			} else {
				if(typeof(o.value)==='undefined')
					o.value = '';
				else
					o.value = o.value?o.value:'N/A';
			}
		} else {
			if ($.isNumeric(o.value)) {
				var val = parseInt(o.value);
				if (val <= 1){
					o.value = o.reference[val];
				} else {
					$.each(o.reference, function(k, v) {
						if (k == val)
							o.value = v;
					});
				}
			} else {
				if(typeof(o.value)==='undefined')
					o.value = '';
				else
					o.value = o.value?o.value:'N/A';
			}
		}
		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		return $('<dt />').html(o.label).add($('<dd />').html(o.value));
	};
	
	BSHelper.Table = function(options){
		var o = $.extend( {}, BSHelper.Table.defaults, options );
		
		var container = $('<div><p></p><table class="table"><thead></thead><tbody></tbody></table></div>'),
				table = container.find('table'),
				thead = container.find('thead'),
				tbody = container.find('tbody'),
				l = 1,
				c = 1,
				confirm_text = o.confirm_text.replace(/({rows_count})/gi, o.data.length);
		
		if (o.title){
			container.find('p').append(o.title);
		}
		if (o.isConfirm){
			if (o.data.length > o.maxrows){
				table.remove();
				return container.append($('<p />').html(confirm_text));
			}
		}
		
		if (Object.keys(o.columns).length == 0) {
			table.remove();
			return container.append($('<p />').html(confirm_text));
		}
					
		// TABLE HEADER
		if (o.showheader){
			var tr = $('<tr />');
			$.each(o.columns, function(j){
				if (c==1){ if (o.rowno){ tr.append( $('<th />').html('#') ); } }
				tr.append( $('<th />').html(o.columns[j]['title']) );
				c++;
			});
			tr.appendTo(thead);
		}
		
		// TABLE DETAIL
		$.each(o.data, function(i){
			var tr = $('<tr />'),
					c  = 1;
			$.each(o.columns, function(j){
				var col = o.columns[j]['data'];
				if (c==1){ if (o.rowno){ tr.append( $('<th />').html(i+1) ); } }
				tr.append( $('<td />').html(o.data[i][col]) );
				c++;
			});
			tr.appendTo(tbody);
		});
		return container;
	};
	
	BSHelper.Table.defaults = { 
		columns: [],
		rowno: false,
		showtitle: true,
		maxrows: 3,
		title: '<h4>Are you sure want to delete ?</h4>',
		confirm_text: '<strong>{rows_count}</strong> rows selected.',
	};
	
	BSHelper.defaults = {
		style: "bs3",
		type: "text",
		label: "",
		idname: BSHelper.newGuid(),
		placeholder: "",
		help: "",
		rows: 1,
		required: false,
		disabled: false,
		readonly: false,
		horz: false, 					// for horizontal-form
		lblsize: "col-sm-3",	
		colsize: "col-sm-9",
		isCombogrid: false
	};
	
	return BSHelper;
	
}));