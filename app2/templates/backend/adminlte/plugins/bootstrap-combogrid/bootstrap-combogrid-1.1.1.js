(function($) {

  "use strict";

	function template(){
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
		
  function Combogrid( elem, options ) {
		this.o = options;
		this.$element     = $(elem);
		this.$container   = $(template());
		this.$target      = this.$container.find('input[type=hidden]');
		this.$button      = this.$container.find('.dropdown-toggle');
		this.$menu  		  = $(template_result()).appendTo('body');
		
		this.disabled     = false;
		this.shown        = false;
		this.focused      = false;
		this.selected     = false;
		this.mousedover   = false;
		this.suppressKeyPressRepeat = {};
		this.loading			= false;
		this.rowData			= {};
		this.page				 	= this.o.page;
		this.ttl_page		 	= 1;
		
		this.init();
		this.initValue();		// INIT DEFAULT VALUE IF DEFINED
		this.listen();
		
		
		
	};
	
  $.fn.combogrid = function(options) {
		if (typeof options == 'string') {
			return this.each(function() {
				var data = $.data(this, 'combogrid');
				// $.fn.combogrid.methods[option]();
				// Combogrid.prototype[option]();
				// console.log(data);
				// console.log( data.o[option] );
				data[options]();
			});
		}
			
    return this.each(function() {
			var data = $.data(this, 'combogrid');
			if (data){
				data = $.data(this, 'combogrid', (new Combogrid(this, $.extend(data, options))) );
			} else {
				data = $.data(this, 'combogrid', (new Combogrid(this, $.extend({}, $.fn.combogrid.defaults, options))) );
			}
    });
  };
	
	// $.fn.combogrid.methods = {
		// constructor: Combogrid,
		// disable: function(){
			// console.log('combogrid.disabled');
			// Combogrid.disable;
		// }
	// }
	
	Combogrid.prototype = {
		init: function(){
			this.$element.before(this.$container);
			this.$target.before(this.$element);
			if (this.$element.attr('disabled')!==undefined) { this.disable(); }
		},

		initValue: function(){
			var val = this.$target.val();
			if (!val) {return;}

			setTimeout(function(){ 
				o.source({id: val}, function(data){
					if (typeof data.rows[0] !== 'undefined'){
						this.$element.val(data.rows[0].name);
						this.selected = true;
					}
				});
			}, 100);
		},

		select: function() {
			var id = this.$menu.find('.active').data(o.idField),
					text = this.$menu.find('.active').data(o.textField);
			this.$element.attr('data-id', id).val(text).trigger('change');
			this.$target.val(id).trigger('change');
			this.selected = true;
			o.onSelect.call(this, this.rowData[id]);
			return hide();
		},

		scroll: function(e){
			this.$element.focus();
			e.stopPropagation();
			e.preventDefault();
			if (o.menu_type !== 'iscroll') {return;}
			if (e.currentTarget.scrollHeight - 35 < e.currentTarget.scrollTop + $(e.currentTarget).height()) {
				var curTar = e.currentTarget;
				var lastTop = curTar.scrollTop;
				
				if (!this.loading){
					if (this.page < this.ttl_page){
						this.loading = true;
						this.page++;
						this.queries();
						curTar.scrollTop = lastTop;
						lastScrollPos = lastTop;
						setTimeout(function(){ curTar.scrollTop = lastTop; console.log(lastTop) }, 500);
					}
				}
			}
		},
		
		keyup: function(e){
			switch(e.keyCode) {
				case 40: // down arrow
					if (!this.shown) {this.toggle();}
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
					if (!this.shown) {return;}
					select();
					break;

				case 27: // escape
					if (!this.shown) {return;}
					hide();
					break;

				default:
					this.queries();
			}

			e.stopPropagation();
			e.preventDefault();
		},
		
		fixMenuScroll: function(){
			var active = this.$menu.find('.active');
			if(active.length){
				var top = active.position().top;
				var bottom = top + active.height();
				var scrollTop = this.$menu.scrollTop();
				var menuHeight = this.$menu.height();
				if(bottom > menuHeight){
						this.$menu.scrollTop(scrollTop + bottom - menuHeight);
				} else if(top < 0){
						this.$menu.scrollTop(scrollTop + top);
				}
			}
		},
		
		move: function(e){
			if (!this.shown) {return;}

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
		},
	
		next: function() {
			var active = this.$menu.find('.active').removeClass('active'), 
					$next = active.next();

			if (!$next.length) {
				$next = $($menu.find('li')[0]);
			}

			$next.addClass('active');
		},
	
		prev: function() {
			var active = this.$menu.find('.active').removeClass('active'), 
					$prev = active.prev();

			if (!$prev.length) {
				$prev = this.$menu.find('li').last();
			}

			$prev.addClass('active');
		},
	
		show: function(){
			var pos = $.extend({}, this.$element.position(), {	height: this.$element[0].offsetHeight });

			this.$menu
				.insertAfter(this.$element)
				.css({top: pos.top + pos.height, left: pos.left})
				.show();
			
			this.shown = true;
		},
		
		hide: function(){
			this.$menu.hide();
			$('.dropdown-menu').off('mousedown', function(e){
				if (e.target.tagName == 'UL') {
					this.$element.off('blur');
				}
			});
			this.$element.on('blur', blur);
			this.shown = false;
			return;
		},
	
		blur: function(){
			var that = this;
			this.focused = false;
			var val = this.$element.val();
			if ( (!this.selected && val !== '') || (this.selected && val == '') ) {
				this.$element.val('');
				this.$target.val('').trigger('change');
			}
			if (!this.mousedover && this.shown) {setTimeout(function () { that.hide; }, 200);}
		},
		
		enable: function(){
			this.$element.prop('disabled', false);
			this.$button.attr('disabled', false);
			this.disabled = false;
		},

		disable: function(){
			this.$element.prop('disabled', true);
			this.$button.attr('disabled', true);
			this.disabled = true;
		},

		queries: function(){
			var that = this;
			var o = this.o;
			var val = this.$element.val(),
					term = { q: val, page: this.page, rows: this.o.rows };
			
			$.each(this.o.queryParams, function(k, v){
				term[k] = v;
			});
			
			setTimeout(function(){ o.source(term, $.proxy(that.lookup, that)) }, 100);
			// o.source(term, $.proxy(this.lookup, this));
		},

		toggle: function(){
			if (!this.disabled){
				if (this.shown){
					this.hide();
					this.$element.focus();
				} else {
					this.queries();
				}
			}
		},

		lookup: function(data){
			var o = this.o;
			var list = '',
					rowData = {};
					
			this.$menu.html('');
			this.ttl_page = Math.ceil(data.total/o.rows);
			$.each(data.rows, function(k, v) {
				rowData[v[o.idField]] = v;
				list += '<li data-'+o.idField+'="'+ v[o.idField] +'" data-'+o.textField+'="'+ v[o.textField] +'"><a>'+v[o.textField]+'</a></li>';
			});
			this.rowData = rowData;
			this.$menu.append(list);
			this.$menu.find('li').first().addClass('active');
			this.show();
			this.$element.focus();
			this.loading = false;
		},

		listen: function(){
			this.$element
				.on('focus',    function(){ this.focused = true; })
				.on('blur',     $.proxy(this.blur, this))
				.on('keypress', function(e){
					if (this.suppressKeyPressRepeat) {return;}
					this.move(e);
				})
				.on('keydown',  function(e){
					this.suppressKeyPressRepeat = ~$.inArray(e.keyCode, [40,38,9,13,27]);
					this.move(e);
				})
				.on('keyup',    $.proxy(this.keyup, this))
				.on('dblclick', $.proxy(this.toggle, this));
		
			this.$menu
				.on('click', function(e){
					this.$element.focus();
					e.stopPropagation();
					e.preventDefault();
					this.select();
				})
				.on('mouseenter', 'li', function(e){
					this.mousedover = true;
					this.$menu.find('.active').removeClass('active');
					$(e.currentTarget).addClass('active');
				})
				.on('mouseleave', function(){ 
					this.mousedover = false; 
				})
				.scroll( $.proxy(this.scroll, this) );

			this.$button
				.on('click', $.proxy(this.toggle, this));
		}

	}
	
  $.fn.combogrid.defaults = {
    source: function(term, lookup){
			$.ajax({
				url: '',
				method: "GET",
				dataType: "json",
				data: term,
				success: function(data){
					response(data.data);
				}
			}); 
		},
    style: 'bs3',
		menu_type: 'normal', // iscroll (infinite scroll), normal
    page: 1,
    rows: 10,
    idField: 'id',
    textField: 'name',
		queryParams: {},
		onSelect: function(rowData){}
  };
	
}(jQuery));
