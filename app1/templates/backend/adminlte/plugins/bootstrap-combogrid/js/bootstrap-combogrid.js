(function($) {

  "use strict";
	
  function Combogrid( elem, options ) {
		var o = options,
				$element     = $(elem),
				$container   = $(template()),
				$target      = $container.find('input[type=hidden]'),
				$button      = $container.find('.dropdown-toggle'),
				$menu  		   = $(template_result()).appendTo('body'),
				
				disabled     = false,
				shown        = false,
				focused      = false,
				selected     = false,
				mousedover   = false,
				suppressKeyPressRepeat = {},
				loading			= false,
				rowData			= {},
				page				 	= o.page,
				ttl_page		 	= 1;
		
		this.o				= o;
		// this._o 			= function(new_o){ $.extend(o, new_o); };
		this._selected = function(state){ selected = state; };
		this._disabled = function(state){ disabled = state; };
		this._listen 	= function(state){ listen(state) };
		this.$element = $element;
		this.$container = $container;
		this.$target 	= $target;
		this.$button 	= $button;
		this.$menu		= $menu;
		this.rowData	= function(){ return rowData; };
		
		this.init();
		
		function template(){
			if (o.style == 'bs3')
				return ''+
					'<div class="combogrid-container">'+
						'<div class="input-group">'+
							'<input type="hidden" />'+
							'<div class="input-group-btn">'+
								'<span class="btn btn-default dropdown-toggle" data-dropdown="dropdown">'+
								'<span class="caret" /></span>'+
							'</div>'+
						'</div>'+
					'</div>';
		}
		
		function template_result(){
			return '<ul class="typeahead-long dropdown-menu dropdown-menu-right"></ul>';
		}
			
		function show(){
			var pos = $.extend({}, $element.position(), {
				height: $element[0].offsetHeight
			});

			$menu
				.insertAfter($element)
				.css({top: pos.top + pos.height, left: pos.left})
				.show();
			
			shown = true;
		}
		
		function hide(){
			// console.log('debug: hide');
			$menu.hide();
			$('.dropdown-menu').off('mousedown', function(e){
				if (e.target.tagName == 'UL') {
					// $element.off('blur');
				}
			});
			shown = false;
			return;
		}

		function blur(){
			focused = false;
			var val = $element.val(), 
					_old = $element.attr('value'), 
					_new = $element.val();
			
			// console.log('selected = '+selected);
			// console.log('val = '+val);
			if ( (!selected && val == '') || (selected && val == '') ) {
				$element
					.attr('value', '')
					.attr('data-'+o.idField, '')
					.attr('data-'+o.textField, '')
					.val('').trigger('change');
				$target.val('').trigger('change');
				selected = false;
				this._selected = false;
				
				if (_old != _new) {	
					if (_new)	
						o.onSelect.call(this, {}); 
				}
			}
			if (!mousedover && shown) {setTimeout(function () { hide(); page = 1; }, 200);}
		}
		
		function toggle(){
			// console.log('debug: toggle');
			if (!disabled){
				if (shown){
					hide();
					$element.focus();
				} else {
					queries();
				}
			}
		}
		
		function queries(){
			// console.log('debug: queries');
			var val = $element.val(),
					term = { q: val, page: page, rows: o.rows };
			
			$.each(o.queryParams, function(k, v){
				term[k] = v;
			});
			setTimeout(function(){ 
				$.getJSON( o.url, term, function(result){ 
					var data = result.data;
					if (Object.keys(data).length > 0){ lookup(data) } 
				});
			}, 100);
		}
	
		/* format data = {total:999, rows:{field1:value1, field2:value2}} */
		function lookup(data){
			var list = '';
			$menu.html('');
			ttl_page = Math.ceil(data.total/o.rows);
			
			if (Object.keys(o.addition).length > 0){
				var addata = o.addition;
				list += '<li class="'+o.item_cls+'" data-'+o.idField+'="'+ addata[o.idField] +'" data-'+o.textField+'="'+ addata[o.textField] +'"><a>'+addata[o.textField]+'</a></li>';
			}
			
			$.each(data.rows, function(k, v) {
				rowData[v[o.idField]] = v;
				list += '<li class="'+o.item_cls+'" data-'+o.idField+'="'+ v[o.idField] +'" data-'+o.textField+'="'+ v[o.textField] +'"><a>'+v[o.textField]+'</a></li>';
			});
			if (Object.keys(data.rows).length > 0) {
				$menu.append(list);
				$menu.find('li').first().addClass('active');
			} else {
				$menu.append('<span style="color:#999;">'+o.emptyMessage+'</span>');
				// $menu.append(o.emptyMessage);
			}
			show();
			$element.focus();
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
			if (!shown) {return;}

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
			var active = $menu.find('.active').removeClass('active'), 
					$next = active.next();

			if (!$next.length) {
				$next = $($menu.find('li')[0]);
			}

			$next.addClass('active');
		}
		
		function prev() {
			var active = $menu.find('.active').removeClass('active'), 
					$prev = active.prev();

			if (!$prev.length) {
				$prev = $menu.find('li').last();
			}

			$prev.addClass('active');
		}
		
		function select() {
			// console.log('debug: select up');
			var id_old = $element.attr('value'),
					id = $menu.find('.active').data(o.idField),
					text = $menu.find('.active').data(o.textField);
			
			if (id_old !== id) {
				$element
					.attr('value', id)
					.attr('data-'+o.idField, id)
					.attr('data-'+o.textField, text)
					.val(text).trigger('change');
				$target.val(id).trigger('change');
				
				if ((id === 0) && (Object.keys(o.addition).length > 0)) 
					o.onSelect.call(this, o.addition);
				else
					o.onSelect.call(this, rowData[id]);
			}
			selected = true;
			return hide();
		}

		function scroll(e){
			// console.log('debug: scroll');
			$element.focus();
			e.stopPropagation();
			e.preventDefault();

			var scrollPercent = (e.currentTarget.scrollTop + $(e.currentTarget).height())/e.currentTarget.scrollHeight*100;
			if ( scrollPercent > 90) {
				var target = e.currentTarget, lastTop;
				
				if (!loading){
					if (page < ttl_page){
						// console.log('debug: loading: true');
						loading = true;
						page++;
						setTimeout(function(){ 
							var val = $element.val(),
									term = { q: val, page: page, rows: o.rows };
							
							$.each(o.queryParams, function(k, v){
								term[k] = v;
							});
							
							$.getJSON( o.url, term, function(result){ 
								var data = result.data;
								var list = '';
								ttl_page = Math.ceil(data.total/o.rows);
								$.each(data.rows, function(k, v) {
									rowData[v[o.idField]] = v;
									list += '<li class="'+o.item_cls+'" data-'+o.idField+'="'+ v[o.idField] +'" data-'+o.textField+'="'+ v[o.textField] +'"><a>'+v[o.textField]+'</a></li>';
								});
								$menu.append(list);
								
								// lastTop = target.scrollTop;
								// console.log('debug: after loading='+target.scrollTop);
								loading = false;
								$element.focus();
							});
						}, 100);
					}
				} 
			}
		}
		
		function keyup(e){
			switch(e.keyCode) {
				case 40: // down arrow
					if (!shown) {toggle();}
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
					if (!shown) {return;}
					select();
					break;

				case 27: // escape
					if (!shown) {return;}
					hide();
					break;

				default:
					queries();
			}

			e.stopPropagation();
			e.preventDefault();
		}
		
		function listen(state){
			// console.log('debug: listen-'+state);
			if (state){
				$element
					.on('focus',    function(){ focused = true; })
					.on('blur',     blur)
					//.focusout(blur)
					.on('keypress', function(e){
						if (suppressKeyPressRepeat) {return;}
						move(e);
					})
					.on('keydown',  function(e){
						suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40,38,9,13,27]);
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
						mousedover = true;
						$menu.find('.active').removeClass('active');
						$(e.currentTarget).addClass('active');
					})
					.on('mouseleave', function(){ 
						mousedover = false; 
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
	
	Combogrid.prototype = {
		constructor: Combogrid,
		version: function(){
			return '1.2.0';
		},
		init: function(){
			// console.log('debug: init');
			if (!this.$element.data('init-combogrid')){
				this.$element.data('init-combogrid', true);
				this.$element.before(this.$container);
				this.$target.before(this.$element);
				this.$target.attr('name', this.$element.attr('name'));
				this.$element.removeAttr('name')
				
				this._listen(true);
				if (this.$element.attr('disabled')!==undefined) { this.disable(true); }
				
				var val = this.$element.val();
				this.setValue(val);
			}
		},
		destroy: function(){
			console.log('debug: destroy');
			if (this.$element.data('init-combogrid')){
				this.$element.data('init-combogrid', false);
				this.$container.before(this.$element);
				this.$container.remove();
				this._listen(false);
			}
		},
		disable: function(state){
			if (state){
				this.$element.prop('disabled', true);
				this.$button.attr('disabled', true);
				this._listen(false);
				this._disabled(true);
			} else {
				this.$element.prop('disabled', false);
				this.$button.attr('disabled', false);
				this._listen(true);
				this._disabled(false);
			}
		},
		getValue: function(field){
			// console.log('debug: getValue');
			var val;
			field = (field === undefined) ? 'id' : field;
			
			/* For anticipate custom additional row */
			if (this.rowData()[this.$element.attr('value')] === undefined)
				return;
			
			if (this.$element.attr('value'))
				return ((val = this.rowData()[this.$element.attr('value')][field]) === undefined) ? false : val;
		},
		setValue: function(val){
			// console.log('debug: setValue');
			if (this.$element.data('init-combogrid')===false){ return; }
			var o 			 = this.o,
					$element = this.$element,
					$target  = this.$target,
					selected = this._selected;
					
			if (!val || val < 0) {
				$element
					.attr('value', '')
					.attr('data-'+o.idField, '')
					.attr('data-'+o.textField, '')
					.val('').trigger('change');
				$target.val('').trigger('change');
				return;
			}
			
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
						selected(true);
					} 
				});
			}, 100);
		},
	}
	/* 
	({key1:val1, key2:val2 key3:{subkey1:subval1, subkey2:subval2}})
	('function', {field1:val1})
	('function', 'params')
	('function')
	*/
  $.fn.combogrid = function(option) {
		if (typeof option === 'string') {
			var $this = $(this),
					inst = $this.data('combogrid');
			
			if (!inst) { return this; }
			if ($.inArray(option, ["getValue", "version"]) !== -1) {
				return inst[option].apply(inst, Array.prototype.slice.call(arguments, 1));
			}	else {
				inst[option].apply(inst, Array.prototype.slice.call(arguments, 1));
				return this;
			}
		}
		
		return this.each(function() {
			var $this = $(this),
					inst = $this.data('combogrid'),
					options = ((typeof option === 'object') ? option : {});
			if (!inst) {
				$this.data('combogrid', new Combogrid(this, $.extend({}, $.fn.combogrid.defaults, options)) );
					// console.log($this.data('combogrid'));
			} else {
				if (typeof option === 'object') {
					$this.data('combogrid', new Combogrid(this, $.extend(inst.o, options)) );
					// console.log($this.data('combogrid'));
				} 
			}
		});
  };
	
  $.fn.combogrid.defaults = {
    source: function(term, response){},
		onSelect: function(rowData){},
    style: 'bs3',
		menu_type: 'normal', // iscroll (infinite scroll), normal
		emptyMessage: '<center><b>No results were found</b></center>',
		colorBack: '#dd4b39',
		colorText: '#000000',
    page: 1,
    rows: 50,
    idField: 'id',
    textField: 'name',
		queryParams: {},
		item_cls: '',
		addition: {},
  };
	
}(jQuery));