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
			seq: 0,
		}
		var o = $.extend( {}, default_opts, options );
		var link = o.link ? '<a href="'+o.link+'" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>' : '<div class="small-box-footer">&nbsp;</div>';
		var num = o.seq ? '<div class="pull-right"><span data-toggle="tooltip" class="badge bg-yellow" data-original-title="Number #'+o.seq+'">'+o.seq+'</span></div>' : '';
		return $('<div class="col-lg-3 col-xs-6">'+
								'<div class="small-box '+o.color+'" data-toggle="tooltip" data-placement="bottom" id="'+(o.idname ? o.idname : '')+'" title="'+(o.tooltip ? o.tooltip : '')+'">'+
									num+
									'<div class="inner">'+
										'<div class="val"><h3><span>'+o.value+'</span></h3></div>'+
										'<div class="title"><p style="white-space: nowrap;"><span>'+o.title+'</span></p></div>'+
									'</div>'+ 
									'<div class="icon"><i class="'+o.icon+'"></i></div>'+
									link +
								'</div>'+
							'</div>');
	}
									/* 
									'<div class="inner">'+
										'<h3><span>'+o.value+'</span></h3>'+
										'<p style="white-space: nowrap;">'+o.title+'</p>'+
									'</div>'+
									'<div class="inner">'+
										'<div class="val"><h3><span>'+o.value+'</span></h3></div>'+
										'<div class="title"><p style="white-space: nowrap;"><span>'+o.title+'</span></p></div>'+
									'</div>'+ 
									*/
	
	BSHelper.Alert = function(options){
		var default_opts = {
			type: '',	// danger, info, warning, success
			title: '',
			description: '',
			icon: '',
		}
		var o = $.extend( {}, default_opts, options );
		switch (o.type){
		case 'info':
			o.icon = '<i class="icon fa fa-info"></i>';
			break;
		case 'warning':
			o.icon = '<i class="icon fa fa-warning"></i>';
			break;
		case 'success':
			o.icon = '<i class="icon fa fa-check"></i>';
			break;
		case 'danger':
			o.icon = '<i class="icon fa fa-ban"></i>';
			break;
		default:
			o.icon = '<i class="icon fa fa-info"></i>';
			break;
		}
		
		return $('<div class="alert alert-'+o.type+' alert-dismissable">'+
								(o.closable ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' : '')+
								'<h4>'+o.icon+o.title+'</h4>'+
								'<p>'+o.description+'</p>'+
							'</div>');
	}
	
	BSHelper.Callout = function(options){
		var default_opts = {
			type: '',	// danger, info, warning, success
			title: '',
			description: '',
			icon: '',
		}
		var o = $.extend( {}, default_opts, options );
		switch (o.type){
		case 'info':
			o.icon = '<i class="icon fa fa-info"></i>';
			break;
		case 'warning':
			o.icon = '<i class="icon fa fa-warning"></i>';
			break;
		case 'success':
			o.icon = '<i class="icon fa fa-check"></i>';
			break;
		case 'danger':
			o.icon = '<i class="icon fa fa-ban"></i>';
			break;
		default:
			o.icon = '<i class="icon fa fa-info"></i>';
			break;
		}
		
		return $('<div class="callout callout-'+o.type+'">'+
								(o.title ? '<h4>'+o.title+'</h4>' : '')+
								'<p>'+o.description+'</p>'+
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
			autocomplete: 'off',
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
			icon: '',
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
		if (o.title) box_header.append( [$('<i class="'+(o.icon ? o.icon : '')+'" />'), $('<h3 class="box-title" />').html(o.title)] );
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
	*	BSHelper.Stacked({ title:"", dataList:[{ title:"",  :"" }, { title:"", link:"" }] }); 
	*					 
	*/
	BSHelper.Stacked = function(options){
		var default_opts = {
			cls: '',
			bc_list: [],	// [{icon:"", title:"", link:""}, {icon:"", title:"", link:""}]
		}
		var o = $.extend( {}, default_opts, options );
		var container = $('<div class="stacked" />');
		container.append('<ul class="nav nav-stacked nav-stacked-link" />');
		if (o.title)
			container.find('ul').append( $('<li class="header">'+o.title+'</li>') );
		
		$.each(o.dataList, function(i) {
			var link = o.dataList[i]['link'];
			var title = o.dataList[i]['title'];
			var content = o.dataList[i]['content'];
			var active = o.dataList[i]['active'] ? ' active' : '';
			container.find('ul').append( $('<li class="item'+active+'"><a href="javascript:void(0);">'+title+'</a></li>') );
		});
		
		return container;
	};
	
	/* 
	*	BSHelper.Pills({ title:"", dataList:[{ title:"", value:"" }, { title:"", value:"" }] }); 
	*					 
	*/
	BSHelper.Pills = function(options){
		var default_opts = {
			cls: '',
			bc_list: [],	// [{icon:"", title:"", link:""}, {icon:"", title:"", link:""}]
		}
		var o = $.extend( {}, default_opts, options );
		var container = $('<div class="stacked" />');
		container.append('<ul class="nav nav-pills nav-stacked" />');
		if (o.title)
			container.find('ul').append( $('<li class="header">'+o.title+'</li>') );
		
		$.each(o.dataList, function(i) {
			var title = o.dataList[i]['title'];
			var value = ' <span class="pull-right text-green">'+o.dataList[i]['value']+'</span>';
			var active = o.dataList[i]['active'] ? ' class="active"' : '';
			var idname = o.dataList[i]['idname'] ? ' id="'+o.dataList[i]['idname']+'"' : '';
			container.find('ul').append( $('<li'+idname+active+'><a href="javascript:void(0);">'+title+value+'</a></li>') );
		});
		
		return container;
	};
	
	/* 
	*	BSHelper.List({ title:"", dataList:[{ title:"", value:"" }, { title:"", value:"" }] }); 
	*					 
	*/
	BSHelper.List = function(options){
		var default_opts = {
			cls: '',
			title: '',
			title_right: '',
			bc_list: [],	// [{icon:"", title:"", link:""}, {icon:"", title:"", link:""}]
		}
		var o = $.extend( {}, default_opts, options );
		var container = $('<div class="stacked" />');
		container.append('<ul class="products-list product-list-in-box" />');
		
		var title_right = o.title_right ? ' <span class="pull-right">'+o.title_right+'</span>' : '';
			
		if (o.title)
			container.find('ul').append( $('<li class="header" style="border-bottom: 1px solid #ddd; color: #777; margin-bottom: 10px; padding: 5px 10px; text-transform: uppercase;">'+o.title+title_right+'</li>') );
		
		$.each(o.dataList, function(i) {
			var title = o.dataList[i]['title'];
			var value = o.dataList[i]['value'] ? ' <span class="pull-right text-green">'+o.dataList[i]['value']+'</span>' : '';
			if (i < 5)
				container.find('ul').append( $('<li class="item">'+title+'<a href="javascript:void(0);">'+value+'</a></li>') );
			else 
				container.find('ul').append( $('<li class="item">'+title+'<a href="javascript:void(0);">'+value+'</a></li>').hide() );
		});

		if (o.dataList.length > 5) {
			container.find('ul').append( $('<li class="footer" style="border-top: 1px solid #ddd; color: #777; margin-bottom: 10px; padding-top: 5px;"><span class="pull-right"><a href="javascript:void(0);" class="view-more">view more</a></span></li>') );
			container.find('ul li a.view-more').on("click", function(){
				container.find('ul li').show();
				$(this).parent().parent().hide();
			});
		}
		return container;
	};
	
	/* 
	*	BSHelper.SmartWizard({dataList:[ title:"", idname:"", content:"" ]}); 
	*	BSHelper.SmartWizard({dataList:[ title:"", idname:"", content:function(){ return ""; } ]}); 
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
	
	BSHelper.Multiselect = function(options){
		var default_opts = {
			type: '',	// danger, info, warning, success
			title: '',
			description: '',
			icon: '',
		}
		var o = $.extend( {}, BSHelper.defaults, options );
		var lbllink = o.label_link ? '<a href="'+o.label_link+'">'+o.label+'</a>' : o.label;
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+lbllink+' *</span>' : lbllink;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');
		var input = $('<select />', {class:"form-control", id:o.idname, name:(o.name ? o.name : o.idname), value:o.value}); 
		var input2 = $('<input />', {class:"multiselect", type:"hidden", id:o.idname, name:(o.name ? o.name : o.idname), value:''}); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');
		
		input.attr('multiple','multiple');		
		input.attr('multiselect','');
		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (!o.label) { container.find('label').remove(); /* container.removeClass('form-group'); */ }
		if (o.required) input.attr('required',''); 
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		if (o.onfocus) input.attr('onfocus',o.onfocus);
		if (o.onchange) input.attr('onchange',o.onchange);
		if (o.cls) input.addClass(o.cls);
		if (o.style && o.style != 'bs3') input.attr('style', o.style);
		if (o.role) input.attr('data-role', o.role);
		if (o.hidden) { input.closest(".form-group").css("display", "none"); }
		if (o.url) input.attr('url',o.url);
		container.find('.control-input').append(input).append(input2).append(help);
		
		if (o.remote && o.remote != 'undefined') {
			$.getJSON(o.url, {}, function(result){ 
				if (!isempty_obj(result.data.rows)) { 
					input.empty();
					$.each(result.data.rows, function(i, item) {
						input.append('<option value="' + item.id + '">' + item.code_name + '</option>');
					});
					
					if (o.build || o.build == undefined){
						if (jQuery().multiselect){
							input.multiselect({
								includeSelectAllOption: true,
								enableFiltering: true,
								filterBehavior: "text",
								enableCaseInsensitiveFiltering: true,
								maxHeight: 200,
								onChange: function(element, checked) {
									// console.log(input.val());
									if (o.onChange) window[o.onChange](input.val());
								},
								onSelectAll: function() {
									// console.log(input.val());
									if (o.onChange) window[o.onChange](input.val());
								},
								onDeselectAll: function() {
									// console.log(input.val());
									if (o.onChange) window[o.onChange](input.val());
								}
							});
							if (o.value) input.multiselect('select', o.value.replace(/\s+/g, '').split(','));
						} else {
							if (o.value) input.val(o.value.replace(/\s+/g, '').split(','));
						}
					} else {
						if (o.value) input.val(o.value.replace(/\s+/g, '').split(','));
					}
				}
			});
		}
		return container;
	};
	
	BSHelper.Input = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lbllink = o.label_link ? '<a href="'+o.label_link+'">'+o.label+'</a>' : o.label;
		// var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+lbllink+' *</span>' : lbllink;
		// var lblname = o.label ? '&nbsp;<span style="color:'+(o.required ? 'red' : 'black')+';vertical-align:-webkit-baseline-middle;white-space:nowrap;">'+o.label+(o.required ? ' *' : '')+'</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" style="white-space: nowrap;" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');
		var el = (o.type == 'textarea') ? 'textarea' : ((o.type == 'select') ? 'select' : 'input');
		var input = $('<'+el+' />', {class:"form-control", id:o.idname, name:o.idname, value:o.value}); 
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
			case 'select':
				input.attr('multiple','multiple');		
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
				if (o.rows) input.attr('rows', o.rows);
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
		if (o.style && o.style != 'bs3') input.attr('style', o.style);
		// if (o.type == 'select') {
			// container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label></div>');
			// input = $('<'+el+' />', {id:o.idname, name:o.idname, value:o.value});
			// input.attr('style',"width:100%; padding:0; border:0px;");
		// } 
		if (o.role) input.attr('data-role', o.role);
		
		if (thetype.toLowerCase() == 'date') 
			container.find('.control-input').append(input).append(input2).append(help);
		//else if (thetype.toLowerCase() == 'select') 
			//container.append(input).append(help);
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
	
	BSHelper.GroupButton = function(options){
		var btnGrp = $('<div class="btn-group" data-toggle="btn-toggle" />');
		if (options.cls) btnGrp.addClass(options.cls);
		$.each(options.list, function(k,v){
			var btn = $('<button/>', { class:"btn", type:"button", id: v.id, title: v.title });
			btn.html(v.text);
			if (v.active) btn.addClass('active');
			btnGrp.append(btn);
		});
		return btnGrp;
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
		// var input = $('<input>', { class: "form-control", id: o.idname, name: o.idname, type: 'text', placeholder: placeholder, value: o.value,	autocomplete: "off" }); 
		var input = $('<input>', { class: "form-control", id: o.idname, name: o.idname, type: 'text', placeholder: placeholder, value: o.value }); 
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
		// var input = $('<input />', { class: "form-control", id: o.idname, name: o.idname, type: 'text', placeholder: placeholder, value: o.value,	autocomplete: "off" }); 
		var input = $('<input />', { class: "form-control", id: o.idname, name: o.idname, type: 'text', placeholder: placeholder, value: o.value }); 
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
		rows: 3,
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