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
	
	BSHelper.newGuid = function() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    };
	
	BSHelper.NavigationTabs = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var tab_shelter = $('<div class="nav-tabs-custom" />');
		var tab_header = $('<ul class="nav nav-tabs" />');
		var tab_content =  $('<div class="tab-content" />');

		var i = 1;
		$.each(o.tabList, function(k, v) {
			$('<li class="'+ ((i==1)?'active ':'') +'" />').append($('<a href="#'+ k +'" data-toggle="tab" />').html(v)).appendTo(tab_header);
			$('<div class="'+ ((i==1)?'active ':'') +'tab-pane" id="'+ k +'" />').appendTo(tab_content);
			i++;
		});
		tab_shelter.append(tab_header);
		tab_shelter.append(tab_content);
		
		return tab_shelter;
	};
	
	BSHelper.Accordion = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var id = 'accordion'+BSHelper.newGuid();
		var shelter = $('<div class="panel-group" id="'+id+'" />');

		$.each(o.dataList, function(i){
			var id2 = 'collapse'+BSHelper.newGuid();
			var panel = $('<div class="panel panel-'+o.dataList[i]['paneltype']+'" />');
			panel.append($('<div class="panel-heading"><h4 class="panel-title"><a style="display:table; table-layout:fixed; width:100%;" data-toggle="collapse" data-parent="#'+id+'" href="#'+id2+'"><div style="display:table-cell; width:90%; overflow:hidden; text-overflow:ellipsis">'+o.dataList[i]['title']+'</div><span class="pull-right glyphicon glyphicon-triangle-bottom"></span></a></h4></div>'));
			
			panel.append($('<div id="'+id2+'" class="panel-collapse collapse"><div class="panel-body">'+o.dataList[i]['body']+'</div></div>'));
			shelter.append(panel);
		});
		
		return shelter;
	};
	
	BSHelper.Label = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');

		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		container.find('.control-input').append(o.elcustom);
		return container;
	};
	
	BSHelper.Input = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');
		var el = (o.type == 'textarea') ? 'textarea' : 'input';
		var input = $('<'+el+' />', {class: "form-control", id: o.idname, name: o.idname, type: o.type, placeholder: o.placeholder, value: o.value, autocomplete:"off"}); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');

		if (o.type=='hidden') return input;
		if (o.hidden) { input.attr('style','display:none;'); return input; }
		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (!o.label) { container.find('label').remove(); container.removeClass('form-group'); }
		if (o.required) input.attr('required',''); 
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		if (o.onfocus) input.attr('onfocus',o.onfocus);
		if (o.minlength) input.attr('data-minlength',o.minlength);
		if (o.idmatch) input.attr('data-match','#'+o.idmatch);
		if (o.errormatch) input.attr('data-match-error',o.errormatch);
		container.find('.control-input').append(input).append(help);
		return container;
	};
	
	BSHelper.Button = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var button = $('<button />', {class: "btn", id: o.idname, name: o.idname, type: o.type }).html(o.label); 
		button.addClass(o.cls?o.cls:'btn-primary');

		if (o.disabled) input.attr('disabled','');
		return button;
	};
	
	BSHelper.Checkbox = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input checkbox"></div></div>');
		var input = $('<input>', {id:o.idname, name:o.idname, type:"checkbox"}); 
		var input2 = $('<input>', {id:o.idname, name:o.idname, type:"hidden", class:"checkbox", value:0}); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');

		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		if (parseInt(o.value)) input.prop("checked", true);
		
		container.find('.control-input').append( input.append(input2) ).append(help);
		input.iCheck({ checkboxClass: 'icheckbox_flat-orange', radioClass: 'iradio_flat-orange'	});
		return container;
	};
	
	BSHelper.Combogrid = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		var lblname = o.required ? '&nbsp;<span style="color:red;">'+o.label+' *</span>' : o.label;
		var container = $('<div class="form-group"><label class="control-label" for="'+o.idname+'">'+lblname+'</label><div class="control-input"></div></div>');
		var input = $('<input>', { class: "form-control", id: o.idname, name: o.idname, type: 'text', placeholder: o.placeholder, value: o.value,	autocomplete: "off", "data-url": o.url }); 
		var help = $('<small />', {class:"form-text text-muted help-block with-errors"}).html(o.help ? o.help : '');

		if (o.horz) { container.find('label').addClass(o.lblsize); container.find('.control-input').addClass(o.colsize); }
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		container.find('.control-input').append(input).append(help);
		
		if (o.isLoad){
			input.combogrid({ 
				source: function(term, response){
					$.getJSON( o.url, term, function(data){ response(data.data); });
				}
			});
		}
		/* if (o.isCombogrid){
			var xhr;
			input.combogrid({ 
				source: function(term, response){
					try { xhr.abort(); } catch(e){}
					xhr = $.ajax({ url:o.url, method:"GET",	dataType:"json", data:term,	cache:false,
						success: function(data){
							response(data.data);
						},
						error: function(data, textStatus, error){
							var err = textStatus + ", " + error;
							console.log( "Request Failed: " + err );
						}
					}); 
				} 
			});
		} */
		container.find('.combogrid-container').addClass(o.colsize);
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
		return $('<dt />').html(o.title).add($('<dd />').html(o.value));
	};
	
	BSHelper.TableConfirm = function(options){
		var o = $.extend( {}, BSHelper.Table.defaults, options );
		
		var table = $('<table />', { class: 'table' }),
				thead = $('<thead />'),
				tbody = $('<tbody />'),
				tr = $('<tr />'),
				l = 1,
				c = 1;
				
		if (o.data.length > o.maxrows){
			var _confirm_text = o.confirm_text.replace(/({rows_count})/gi, o.data.length);
			return $('<p />').html(_confirm_text);
		}
		
		// TABLE HEADER
		if (o.showtitle){
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
		return table.append(thead).append(tbody);
	};
	
	BSHelper.Table = function(options){
		var o = $.extend( {}, BSHelper.Table.defaults, options );
		
		var table = $('<table />', { class: 'table' }),
				thead = $('<thead />'),
				tbody = $('<tbody />'),
				tr = $('<tr />'),
				l = 1,
				c = 1;
				
		// TABLE HEADER
		if (o.showtitle){
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
		return table.append(thead).append(tbody);
	};
	
	BSHelper.Table.defaults = { 
		columns: [],
		rowno: false,
		showtitle: true,
		maxrows: 3,
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