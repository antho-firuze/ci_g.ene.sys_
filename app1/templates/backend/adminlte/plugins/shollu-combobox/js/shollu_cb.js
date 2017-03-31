(function($) {

  "use strict";
	
  function Shollu_CB( elem, options ) {
		var o = options,
			$element     = $(elem),
			$container   = $(template()),
			$target      = $container.find('input[type=hidden]'),
			$button      = $container.find('.shollu_cb.dropdown-toggle'),
			$menu  		   = $(template_result()).appendTo('body'),
			focused      = false,
			selected     = false,
			$mousedover   = false,
			$suppressKeyPressRepeat = {},
			$loading			 = false,
			$rowData			 = {},
			$tot_page		 = 0;
		
		this.o				= o;
		this.destroy 	= function(){ destroy(); };
		this.version 	= function(){ return version(); };
		this.getValue = function(field){ return getValue(field); };
		this.setValue = function(val){ setValue(val); };
		this.disabled = function(state){ disabled(state); };
		
		init();
		
		function init(){
			// console.log('debug: init');
			if (!$element.data('init-shollu_cb')){
				$element.data('init-shollu_cb', true);
				$element.before($container);
				$target.before($element);
				$target.attr('name', $element.attr('name'));
				$element.removeAttr('name')
				
				o.disable = ($element.attr('disabled') === undefined) ? false : true;
				disabled(o.disable); 
			}
		}
		
		function destroy(){
			// console.log('debug: destroy');
			if ($element.data('init-shollu_cb')){
				$element.data('init-shollu_cb', false);
				$container.before($element);
				$container.remove();
				listen(false);
			}
		}
		
		function version(){
			// console.log('debug: version');
			return '1.0.0';
		}
		
		function template(){
			if (o.style == 'bs3')
				return ''+
					'<div class="shollu_cb-container">'+
						'<div class="input-group">'+
							'<input type="hidden" />'+
							'<div class="input-group-btn">'+
								'<span class="btn btn-default shollu_cb dropdown-toggle" data-dropdown="dropdown">'+
								'<span class="caret" /></span>'+
							'</div>'+
						'</div>'+
					'</div>';
		}
		
		function template_result(){
			return '<ul class="typeahead-long dropdown-menu dropdown-menu-right"></ul>';
		}
		
		function disabled(state){
			// console.log('disabled:'+state);
			$element.prop('disabled', state);
			$button.attr('disabled', state);
			if (state) $button.addClass('disabled'); else $button.removeClass('disabled');
			o.disable = state;
			listen(state?false:true);
		}
		
		function show(){
			var pos = $.extend({}, $element.position(), {	height: $element[0].offsetHeight });

			$menu
				.insertAfter($element)
				.css({top: pos.top + pos.height, left: pos.left})
				.show();
			
			o.shown = true;
		}
		
		function hide(){
			// console.log('debug: hide');
			$menu.hide();
			$('.dropdown-menu').off('mousedown', function(e){
				if (e.target.tagName == 'UL') {
					$element.off('blur');
				}
			});
			o.shown = false;
			return;
		}

		function blur(){
			// console.log('debug: blur');
			focused = false;
			select();
			/* var val = $element.val(), 
					_old = $element.attr('value'), 
					_new = $element.val();
			
			if ( (!$selected && val == '') || ($selected && val == '') ) {
				$element
					.attr('value', '')
					.attr('data-'+o.idField, '')
					.attr('data-'+o.textField, '')
					.val('').trigger('change');
				$target.val('').trigger('change');
				selected = false;
				
				if (_old != _new) {	
					if (_new)	
						o.onSelect.call(this, {}); 
				}
			} */
			if (!$mousedover && o.shown) { setTimeout(function(){ hide(); o.page = 1; }, 200); }
		}
		
		function toggle(){
			// console.log('toggle:'+o.disable);
			// o.disable = ($element.attr('disabled') === undefined) ? false : true;
			if (shown) hide();
			if (!o.disable){
				if (o.shown){
					hide();
					$element.focus();
				} else {
					queries();
				}
			}
		}
		
		function queries(){
			// console.log('debug: queries');
			if (o.remote){
				var val = $element.val();
				var params = {q:val, page:o.page, rows:o.rows};
				
				$.each(o.queryParams, function(k, v){	params[k] = v; });
				setTimeout(function(){ 
					$.getJSON( o.url, params, function(result){ 
						var data = result.data;
						if (Object.keys(data).length > 0){ lookup(data) } 
					});
				}, 100);
			} else {
				lookup(o.rows);
			}
		}
		
		/* 
		* remote
		*	data = {total:3, rows:[{value:1, text:"One"},{value:2, text:"Two"}{value:3, text:"Three"}]} 
		*
		*	local
		* data = [{value:1, text:"One"},{value:2, text:"Two"}{value:3, text:"Three"}]
		*/
		function lookup(data){
			var list = [];
			var rows = data;
			
			if (o.page == 1)
				$menu.html('');
			
			if (Object.keys(o.addition).length > 0){
				var v = o.addition[o.idField];
				var t = o.addition[o.textField];
				list.push($('<li class="'+o.item_cls+'" data-'+o.idField+'="'+v+'" data-'+o.textField+'="'+t+'"><a>'+t+'</a></li>'));
				$rowData[v] = o.addition;
			}
			
			if (o.remote) {
				rows = data.rows;
				$tot_page = Math.ceil(data.total/o.rows);
			} 
			
			if (Object.keys(rows).length > 0) {
				$.each(rows, function(i) {
					var v = rows[i][o.idField];
					var t = rows[i][o.textField];
					list.push( $('<li class="'+o.item_cls+'" data-'+o.idField+'="'+v+'" data-'+o.textField+'="'+t+'"><a>'+t+'</a></li>') );
					$rowData[v] = rows[i]; /* 1:{value:1, text:"One"}, 2:{value:2, text:"Two"} */
				});
				$menu.append(list);
				// $menu.find('li').first().addClass('active');
			} else {
				$menu.append('<span style="color:#999;">'+o.emptyMessage+'</span>');
			}
			
			/* insert to object o, for permanent storage & can be accessed on other function */
			o.rowData = $rowData;
			show();
			$element.focus();
		}
		
		function select(){
			// console.log('debug: select up');
			/* Searching by text */
			/* var text_new = $element.val();
			if (text_new){
				$.each($rowData, function(i){
					var id = o.rowData[i][o.idField];
					var text = o.rowData[i][o.textField];
					
					console.log(text+'=='+text_new);
					
					if (text == text_new){
						console.log('sameee');
						$element
							.attr('value', id)
							.attr('data-'+o.idField, id)
							.attr('data-'+o.textField, text)
							.val(text);
						$target.val(id);
						o.onSelect.call(this, o.rowData[i]);
						return;
					}
				});
				
			} */
			
			/* Searching by id */
			var id_old = $element.attr('value'),
					id = $menu.find('.active').data(o.idField),
					text = $menu.find('.active').data(o.textField);
			
			if (id === undefined) { return hide(); }
			
			if (id_old !== id) {
				$element
					.attr('value', id)
					.attr('data-'+o.idField, id)
					.attr('data-'+o.textField, text)
					.val(text).trigger('change');
				$target.val(id).trigger('change');
				o.onSelect.call(this, o.rowData[id]);
			}
			selected = true;
			return hide();
		}

		function getValue(field){
			return 'test';
		}
		
		function setValue(val){
			if ($element.data('init-shollu_cb')===false){ return; }
					
			if (!val || val < 0) {
				$element
					.attr('value', '')
					.attr('data-'+o.idField, '')
					.attr('data-'+o.textField, '')
					.val('').trigger('change');
				$target.val('').trigger('change');
				return;
			}
			
			if (o.remote) {
				setTimeout(function(){ 
					$.getJSON( o.url, {id: val}, function(data){ 
						var row = data.data.rows[0];
						if (typeof row !== 'undefined'){
							var id = row[o.idField],
									text = row[o.textField];
							$element
								.attr('value', id)
								.attr('data-'+o.idField, id)
								.attr('data-'+o.textField, text)
								.val(text).trigger('change');
							$target.val(id).trigger('change');
							selected = true;
						} 
					});
				}, 100);
			} else {
				
			}
		}
		
		function scroll(e){
			// console.log('debug: scroll');
			$element.focus();
			e.stopPropagation();
			e.preventDefault();

			var ct = e.currentTarget;
			var scrollPercent = (ct.scrollTop + $(ct).height())/ct.scrollHeight*100;
			if ( scrollPercent > 90) {
				if (!$loading){
					if (o.page < $tot_page){
						// console.log('debug: $loading: true');
						$loading = true;
						o.page++;
						
						if (o.remote) {
							var val = $element.val();
							var params = {q:val, page:o.page, rows:o.rows};
						
							$.each(o.queryParams, function(k, v){ params[k] = v; });
							setTimeout(function(){ 
								$.getJSON( o.url, params, function(result){ 
									var data = result.data;
									if (Object.keys(data).length > 0){ lookup(data) } 
									$loading = false;
								});
							}, 100);
						}
					}
				} 
			}
		}
		
		function fixMenuScroll(){
			// console.log('debug: fixMenuScroll');
			var active = $menu.find('.active');
			if(active.length){
				var top = active.position().top;
				var bottom = top + active.height();
				var scrollTop = $menu.scrollTop();
				var menuHeight = $menu.height();
				if(bottom > menuHeight){
						$menu.scrollTop(scrollTop + bottom - menuHeight);
				} else if(top < 0){
						$menu.scrollTop(scrollTop + top);
				}
			}
		}
		
		function move(e){
			if (!o.shown) {return;}

			switch(e.keyCode) {
			case 9: // tab
			case 13: // enter
			case 27: // escape
				e.preventDefault();
				break;

			case 38: // up arrow
				e.preventDefault();
				prev();
				fixMenuScroll();
				break;

			case 40: // down arrow
				e.preventDefault();
				next();
				fixMenuScroll();
				break;
			}

			e.stopPropagation();
		}
		
		function next() {
			var active = $menu.find('.active').removeClass('active'), $next = active.next();

			if (!$next.length) { $next = $($menu.find('li')[0]); }
			$next.addClass('active');
		}
		
		function prev() {
			var active = $menu.find('.active').removeClass('active'), $prev = active.prev();

			if (!$prev.length) { $prev = $menu.find('li').last();	}
			$prev.addClass('active');
		}
		
		function keyup(e){
			// console.log('debug: keyup');
			switch(e.keyCode) {
			case 40: // down arrow
				if (!o.shown) {toggle();}
				break;
			case 39: // right arrow
			case 38: // up arrow
			case 37: // left arrow
			case 36: // home
			case 35: // end
			case 16: // shift
			case 17: // ctrl
			case 18: // alt
				break;

			case 9: // tab
			case 13: // enter
				if (!o.shown) {return;}
				select();
				break;

			case 27: // escape
				if (!o.shown) {return;}
				hide();
				break;

			default:
				queries();
			}

			e.stopPropagation();
			e.preventDefault();
		}
		
		function listen(state){
			// console.log('listen-'+state);
			if (state){
				// console.log('listen:'+state);
				$element
					.on('focus',    function(){ focused = true; })
					.on('blur',     blur)
					.focusout(blur)
					// .focusout(focusout)
					.on('keypress', function(e){
						if ($suppressKeyPressRepeat) {return;}
						move(e);
					})
					.on('keydown',  function(e){
						$suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40,38,9,13,27]);
						move(e);
					})
					.on('keyup',    keyup)
					.on('dblclick', toggle);
			
				$menu
					.on('click', function(e){
						$element.focus();
						e.stopPropagation();
						e.preventDefault();
						select();
					})
					.on('mouseenter', 'li', function(e){
						$mousedover = true;
						$menu.find('.active').removeClass('active');
						$(e.currentTarget).addClass('active');
					})
					.on('mouseleave', function(){ 
						$mousedover = false; 
					})
					.scroll( scroll );

				$button
					.on('click', toggle);
					
			} else {
				$element.off('blur focusout focus keydown keyup keypress dblclick');
				$menu.off('click mouseenter mouseleave scroll');
				$button.off('click');
			}
		}
		
	};
	
	Shollu_CB.prototype = {
		constructor: Shollu_CB,
		/* init: function(){
			console.log('debug: init');
			this.init();
		}, */
		version: function(){
			// console.log('debug: version');
			return this.version();
		},
		destroy: function(){
			// console.log('debug: destroy');
			this.destroy();
		},
		disable: function(state){
			// console.log('debug: disable');
			this.disabled(state);
		},
		getValue: function(field){
			// console.log('debug: getValue');
			return this.getValue();
		},
		setValue: function(val){
			// console.log('debug: setValue');
			this.setValue(val);
		},
	}
	/* 
	({key1:val1, key2:val2 key3:{subkey1:subval1, subkey2:subval2}})
	('function', {field1:val1})
	('function', 'params')
	('function')
	*/
  $.fn.shollu_cb = function(option) {
		if (typeof option === 'string') {
			var $this = $(this),
					inst = $this.data('shollu_cb');
			
			if (!inst) { return this; }
			if ($.inArray(option, ["getValue", "version", "setValue", "disable", "destroy"]) !== -1) {
				return inst[option].apply(inst, Array.prototype.slice.call(arguments, 1));
			}
			// console.log(inst);
			/* if ($.inArray(option, ["getValue", "version"]) !== -1) {
				return inst[option].apply(inst, Array.prototype.slice.call(arguments, 1));
			}	else {	
				// ["setValue", "disable", "destroy"]
				inst[option].apply(inst, Array.prototype.slice.call(arguments, 1));
				return this;
			} */
		}
		
		return this.each(function() {
			var $this = $(this),
					inst = $this.data('shollu_cb'),
					options = ((typeof option === 'object') ? option : {});
			if (!inst) {
				$this.data('shollu_cb', new Shollu_CB(this, $.extend({}, $.fn.shollu_cb.defaults, options)) );
					// console.log($this.data('shollu_cb'));
			} else {
				if (typeof option === 'object') {
					$this.data('shollu_cb', new Shollu_CB(this, $.extend(inst.o, options)) );
					// console.log($this.data('shollu_cb'));
				} 
			}
		});
  };
	
  $.fn.shollu_cb.defaults = {
    // source: function(term, response){},
		onSelect: function(rowData){},
    style: 'bs3',
		menu_type: 'normal', // iscroll (infinite scroll), normal
		emptyMessage: '<center><b>No results were found</b></center>',
		// colorBack: '#dd4b39',
		// colorText: '#000000',
    page: 1,
    rows: 50,
    idField: 'value',
    textField: 'text',
		// queryParams: {},
		item_cls: '',
		addition: {},
		remote: false,
  };
	
}(jQuery));