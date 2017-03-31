(function($) {

  "use strict";
	
	var PLUGIN_NAME = 'shollu_cg',
      PLUGIN_VERSION = '1.0.1',
      PLUGIN_OPTIONS = {
      };	
			
  var Shollu_CG = function ( elem, options ) {
		var 
		o = options,
		$element     = $(elem),
		$container   = $(template()),
		$target      = $container.find('input[type=hidden]'),
		$button      = $container.find('.dropdown-toggle'),
		$menu  		   = $(template_result()).appendTo('body'),
		
		focused      = false,
		selected     = false,
		mousedover   = false,
		suppressKeyPressRepeat = {},
		loading			= false,
		rowData			= {},
		tot_page		 	= 1;
		
		this.name 		= PLUGIN_NAME;
		this.version 	= PLUGIN_VERSION;
		
		//Expose public methods
		this.o				= o;
		this.destroy 	= function(){ destroy(); };
		this.getValue = function(field){ return getValue(field); };
		this.setValue = function(val){ setValue(val); };
		this.disabled = function(state){ disabled(state); };
		this.listen 	= function(state){ listen(state); };
		
		this.container = $container;
		this.element = $element;
		this.target = $target;
		this.init = function(){ return init(); };
		
		init();
		
		function template(){
			if (o.style == 'bs3')
				return ''+
					'<div class="shollu_cg-container">'+
						'<div class="input-group">'+
							'<input type="hidden" />'+
							'<div class="input-group-btn">'+
								'<span class="btn btn-default dropdown-toggle" data-dropdown="dropdown">'+
								'<span class="caret" /></span>'+
							'</div>'+
						'</div>'+
					'</div>';
		}
		
		function init(){
			// console.log('debug: init');
			if (!$element.data('init-shollu_cg')){
				$element.data('init-shollu_cg', true);
				$element.before($container);
				$target.before($element);
				
				$target.attr('name', $element.attr('name'));
				$element.removeAttr('name')
				
				o.disable = ($element.attr('disabled') === undefined) ? false : true;
				disabled(o.disable); 
				
				var val = $element.val();
				setValue(val);
			}
			return this;
		}
		
		function destroy(){
			// console.log('debug: destroy');
			if ($element.data('init-shollu_cg')){
				$element.data('init-shollu_cg', false);
				
				// console.log($container);
				// $('div').remove('.shollu_cg-container');
				$container.before($element);
				// $target.detach();
				$container.remove();
				
				listen(false);
			}
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
			var pos = $.extend({}, $element.position(), {
				height: $element[0].offsetHeight
			});

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
					// $element.off('blur');
				}
			});
			o.shown = false;
			return;
		}

		function blur(){
			focused = false;
			select();
			console.log('mousedover:'+mousedover);
			console.log('o.shown:'+o.shown);
			if (!mousedover && o.shown) {setTimeout(function () { hide(); o.page = 1; }, 200);}
		}
		
		function toggle(){
			// console.log('debug: toggle');
			if (o.shown) hide();
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
			var val = $element.val();
			var term = { q: val, page: o.page, rows: o.rows };
			
			$.each(o.queryParams, function(k, v){ term[k] = v; });
			setTimeout(function(){ 
				$.getJSON( o.url, term, function(result){ 
					var data = result.data;
					if (Object.keys(data).length > 0){ lookup(data) } 
				});
			}, 100);
		}
	
		/* format data = {total:999, rows:{field1:value1, field2:value2}} */
		function lookup(data){
			var list = [];
			var rows = data;
			
			if (o.page == 1)
				$menu.html('');
			
			// console.log('addition:'+Object.keys(o.addition).length);
			if (Object.keys(o.addition).length > 0){
				var v = o.addition[o.idField];
				var t = o.addition[o.textField];
				list.push($('<li class="'+o.item_cls+'" data-'+o.idField+'="'+v+'" data-'+o.textField+'="'+t+'"><a>'+t+'</a></li>'));
				rowData[v] = o.addition;
			}
			
			if (o.remote) {
				rows = data.rows;
				tot_page = Math.ceil(data.total/o.rows);
			} 
			
			if (Object.keys(rows).length > 0) {
				$.each(rows, function(i) {
					var v = rows[i][o.idField];
					var t = rows[i][o.textField];
					list.push( $('<li class="'+o.item_cls+'" data-'+o.idField+'="'+v+'" data-'+o.textField+'="'+t+'"><a>'+t+'</a></li>') );
					rowData[v] = rows[i]; /* 1:{value:1, text:"One"}, 2:{value:2, text:"Two"} */
				});
				$menu.append(list);
				// $menu.find('li').first().addClass('active');
			} else {
				$menu.append('<span style="color:#999;">'+o.emptyMessage+'</span>');
			}
			
			/* insert to object o, for permanent storage & can be accessed on other function */
			o.rowData = rowData;
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
			// console.log('debug: getValue');
			var val;
			field = (field === undefined) ? o.idField : field;
			
			/* For anticipate custom additional row */
			val = $element.attr('value')===undefined ? '' : $element.attr('value')=='' ? '' : $element.attr('value');
			if (!val)
				return;
			
			if ($element.attr('value'))
				return ((val = o.rowData[$element.attr('value')][field]) === undefined) ? false : val;
		}
		
		function setValue(val){
			if ($element.data('init-shollu_cg')===false){ return; }
					
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
							$selected = true;
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

			var scrollPercent = (e.currentTarget.scrollTop + $(e.currentTarget).height())/e.currentTarget.scrollHeight*100;
			if ( scrollPercent > 90) {
				var target = e.currentTarget, lastTop;
				
				if (!loading){
					if (o.page < tot_page){
						// console.log('debug: loading: true');
						loading = true;
						o.page++;
						setTimeout(function(){ 
							var val = $element.val(),
									term = { q: val, page: o.page, rows: o.rows };
							
							$.each(o.queryParams, function(k, v){
								term[k] = v;
							});
							
							$.getJSON( o.url, term, function(result){ 
								var data = result.data;
								var list = '';
								tot_page = Math.ceil(data.total/o.rows);
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
			// console.log('debug: listen-'+state);
			if (state){
				$element
					.on('focus',    function(){ focused = true; })
					.on('blur',     blur)
					.focusout(blur)
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
	
  $.fn.shollu_cg = function(option) {
		var defaults = {
			source: function(term, response){},
			onSelect: function(rowData){},
			style: 'bs3',
			menu_type: 'normal', // iscroll (infinite scroll), normal
			emptyMessage: '<center><b>No results were found</b></center>',
			page: 1,
			rows: 50,
			idField: 'id',
			textField: 'name',
			queryParams: {},
			item_cls: '',
			addition: {},
			remote: false,
		};
		
		var $this = $(this), 
				instl = $this.data('shollu_cg');
				
		if (typeof option === 'string') {
			if (!instl) { return this; }
			if (instl[option]) {
				return instl[option].apply(instl, Array.prototype.slice.call(arguments, 1));
			} else {
				$.error( 'Method ' +  option + ' does not exist on jQuery.shollu_cg' );
			}
		}
		
		return this.each(function() {
			if (!instl) {
				$this.data('shollu_cg', new Shollu_CG(this, $.extend({}, defaults, option)) );
				// console.log($this.data('shollu_cg'));
			} else {
				$this.data('shollu_cg', new Shollu_CG(this, $.extend(instl.o, option)) );
				// console.log($this.data('shollu_cg'));
			}
		});
  };
	
}(jQuery));