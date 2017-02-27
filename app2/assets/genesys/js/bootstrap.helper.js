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
			panel.append($('<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#'+id+'" href="#'+id2+'">'+o.dataList[i]['title']+'<span class="pull-right glyphicon glyphicon-triangle-bottom"></span></a></h4></div>'));
			
			panel.append($('<div id="'+id2+'" class="panel-collapse collapse"><div class="panel-body">'+o.dataList[i]['body']+'</div></div>'));
			shelter.append(panel);
		});
		
		return shelter;
	};
	
	BSHelper.Input = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});
		var help = $('<p />', {class:"help-block"});
		
		var input = $('<input>', {
			class: "form-control", 
			id: o.idname, 
			name: o.idname, 
			type: o.type, 
			placeholder: o.placeholder, 
			value: o.value,
			autocomplete: "off"
		}); 
		if (o.type=='hidden') return input;
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		col.append(input);
		if (o.help) help.html(o.help).appendTo(col);
		
		return fg.append(lbl).append(col);
	};
	
	BSHelper.TextArea = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});
		var help = $('<p />', {class:"help-block"});
		
		var input = $('<textarea />', {
			class: "form-control", 
			id: o.idname, 
			name: o.idname, 
			placeholder: o.placeholder, 
			rows: o.rows
		}).html(o.value); 
		
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		col.append(input);
		if (o.help) help.html(o.help).appendTo(col);
		
		return fg.append(lbl).append(col);
	};
	
	BSHelper.Checkbox = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});
		var help = $('<p />', {class:"help-block"});
		var col_checkbox = $('<div />', {class:"checkbox"});
		
		var input = $('<input>', {id:o.idname, name:o.idname, type:"checkbox"}); 
		var input2 = $('<input>', {id:o.idname, name:o.idname, type:"hidden", value:0}); 
		col.append( col_checkbox.append(lbl).append(input).append(input2) );
		
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		if (parseInt(o.value)) input.prop("checked", true);
		if (o.help) help.html(o.help).appendTo(col);
		
		input.iCheck({ checkboxClass: 'icheckbox_flat-orange', radioClass: 'iradio_flat-orange'	});
		
		return fg.append(lbl).append(col);
	};
	
	BSHelper.Combobox3 = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});
		var help = $('<p />', {class:"help-block"});
		
		var select = $("<select />", { class:"form-control", id:o.idname, name:o.idname });

		//$.getJSON(o.url, { q: '' }, function(data){ 
		$.getJSON(o.url, {}, function(data){ 
			//response(data.data); 
			var i=1;
			$.each(data.data.rows, function(k, v) {
				if (i==1) select.append( $('<option />') );
				select.append($('<option />', {value: k}).html(v['name']));
				i++;
			});
			if (o.required) select.attr('required','');
			if (o.disabled) select.attr('disabled','');
			if (o.readonly) select.attr('readonly','');
			col.append(select);
			
			// select.selectpicker('render');
			
			select.combobox({
				appendId: '_cb',
				menu: '<ul class="dropdown-menu dropdown-menu-right"></ul>'
			});
		});
		return fg.append(lbl).append(col);
	};
	
	BSHelper.Combobox2 = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});

		var input_grp = $('<div />', {class:"input-group combobox-container"});
		var input = $('<input>', {
			class: "form-control", 
			id: o.idname, 
			name: o.idname, 
			type: 'text', 
			placeholder: o.placeholder, 
			autocomplete: "off"
		}); 
		var btn = $('<div />', {class:"input-group-btn"}).append($('<button type="button" class="btn btn-default dropdown-toggle" aria-label="Combobox autofill suggestions" data-toggle="dropdown"><span class="caret"></span></button>'));

		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		col.append( input_grp.append(input).append(btn) );
		if (o.help) help.html(o.help).appendTo(col);

		/* $.getJSON(o.url, {}, function(data){ 
			input.ajaxComboBox(
				data.data.rows,
				{
					lang: 'en',
					db_table: 'nation',
					button_img: template_url+'plugins/ajax-combobox/btn.png'
					//shorten_src: template_url+'plugins/ajax-combobox/btn.png'
				}
			);
		}); */
		
		return fg.append(lbl).append(col);
	};
	
	BSHelper.Combobox = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});
		var help = $('<p />', {class:"help-block"});
		
		var input = $('<input>', {
			class: "form-control", 
			id: o.idname, 
			name: o.idname, 
			type: 'text', 
			placeholder: o.placeholder, 
			value: o.value,
			autocomplete: "off"
		}); 
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		col.append(input);
		if (o.help) help.html(o.help).appendTo(col);
		
		if (o.isCombogrid){
			var xhr;
			input.combogrid({ 
				source: function(term, response){
					try { xhr.abort(); } catch(e){}
					xhr = $.ajax({
						url: o.url,
						method: "GET",
						dataType: "json",
						data: term,
						cache: false,
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
		}
	
		return fg.append(lbl).append(col);
	};
	
	BSHelper.Combobox4 = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});
		var help = $('<p />', {class:"help-block"});
		
		var input = $('<input>', {
			class: "form-control", 
			id: o.idname, 
			name: o.idname, 
			type: 'text', 
			placeholder: o.placeholder, 
			value: o.value,
			autocomplete: "off"
		}); 
		if (o.type=='hidden') return input;
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		col.append(input);
		if (o.help) help.html(o.help).appendTo(col);
		
		$.getJSON(o.url, {}, function(data){ 
			input.ajaxComboBox(data.data.rows);
		});
		
		return fg.append(lbl).append(col);
	};
	
	BSHelper.Combobox5 = function(options){
		var o = $.extend( {}, BSHelper.defaults, options );
		
		var fg = $('<div />', {class:"form-group"});
		var lbl = $('<label />', {class:"control-label "+o.lblsize, for:o.idname}).html(o.label);
		var col = $('<div />', {class:o.colsize});
		var help = $('<p />', {class:"help-block"});
		
		var input = $('<input>', {
			class: "form-control", 
			id: o.idname, 
			name: o.idname, 
			type: 'text', 
			placeholder: o.placeholder, 
			value: o.value,
			autocomplete: "off"
		}); 
		if (o.type=='hidden') return input;
		if (o.required) input.attr('required','');
		if (o.disabled) input.attr('disabled','');
		if (o.readonly) input.attr('readonly','');
		col.append(input);
		if (o.help) help.html(o.help).appendTo(col);
		
		var xhr;
		input.autoComplete({
			minChars: 1,
			delay: 0,
			cache: false,
			source: function(term, response){
				try { xhr.abort(); } catch(e){}
				xhr = $.getJSON(o.url, { q: term }, function(data){ 
				console.log(data.data);
				response(data.data); });
			},
			renderItem: function (item, search){
				search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
				var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
				// return '<div style="height:35px; width:300px; padding-top:7px;" class="autocomplete-suggestion" data-href="' + item['id'] + '" data-val="' + item['name'] + '"><i class="fa fa-circle-o"></i> '+ item['name'].replace(re, "<b>$1</b>") + '</div>';
				return '<div style="height:35px; width:300px; padding-top:7px;" class="autocomplete-suggestion"><i class="fa fa-circle-o"></i> '+ item['name'].replace(re, "<b>$1</b>") + '</div>';
			}
		});
		
		return fg.append(lbl).append(col);
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
		lblsize: "col-sm-3",	
		colsize: "col-sm-9",
		isCombogrid: false
	};
	
	return BSHelper;
	
}));