(function($) {

  "use strict";

  var Combogrid = function ( element, options ) {
    this.options = $.extend({}, $.fn.combobox.defaults, options);
    this.template = this.options.template || this.template
    this.$source = $(element);
    this.$container = this.setup();
    this.$element = this.$container.find('input[type=text]');
    this.$target = this.$container.find('input[type=hidden]');
    this.$button = this.$container.find('.dropdown-toggle');
    this.$menu = $(this.options.menu).appendTo('body');
	
    this.matcher = this.options.matcher || this.matcher;
    this.sorter = this.options.sorter || this.sorter;
    this.highlighter = this.options.highlighter || this.highlighter;
    this.shown = false;
    this.selected = false;
    this.refresh();
    this.transferAttributes();
    this.listen();
  };
	
  $.fn.combogrid = function(option) {
    // public methods
    /* if (typeof options == 'string') {
      this.each(function(){
        var that = $(this);
        if (options == 'destroy') {
          $(window).off('resize.autocomplete', that.updateSC);
          that.off('blur.autocomplete focus.autocomplete keydown.autocomplete keyup.autocomplete');
          if (that.data('autocomplete'))
            that.attr('autocomplete', that.data('autocomplete'));
          else
            that.removeAttr('autocomplete');
          $(that.data('sc')).remove();
          that.removeData('sc').removeData('autocomplete');
        }
      }); 
      return this;
    } */

    return this.each(function() {
			var o = $.extend({}, $.fn.combogrid.defaults, option),
					data = $(this).data('combogrid'),
					options = typeof option == 'object' && option;
					
      // if(!data) {$this.data('combogrid', (data = new Combogrid(this, options)));}
      // if (typeof option == 'string') {data[option]();}
					
      var that = $(this),
          $source      = that,
          $container   = $(template()),
          $source_id   = $source.attr('id'),
          $source_name = $source.attr('name'),
          $target      = $container.find('input[type=hidden]'),
          $element     = $container.find('input[type=text]'),
          $button      = $container.find('.dropdown-toggle'),
          $menu        = $(o.menu).appendTo('body'),
          disabled     = false,
          shown        = false,
          focused      = false,
          selected     = false,
          mousedover   = false,
          suppressKeyPressRepeat = {},
					loading			 = false,
					rowData			 = {},
					page				 = 1,
					ttl_page		 = 1;

	  var $result = $('<div />')
	  
			function template(){
				if (o.style=='bs3')
					return '<div class="combogrid-container"><input type="hidden" /><div class="input-group"> <input type="text" autocomplete="off" class="form-control" /> <div class="input-group-btn"><span class="btn btn-default dropdown-toggle" data-dropdown="dropdown"> <span class="caret" /> </span> </div> </div> </div>';
			}
		  
      function disable(){
        $element.prop('disabled', true);
        $button.attr('disabled', true);
        disabled = true;
        $container.addClass('combogrid-disabled');
      }
      
      function enable(){
        $element.prop('disabled', false);
        $button.attr('disabled', false);
        disabled = false;
        $container.removeClass('combogrid-disabled');
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
        $menu.hide();
        $('.dropdown-menu').off('mousedown', function(e){
          if (e.target.tagName == 'UL') {
            $element.off('blur');
          }
        });
        $element.on('blur', blur);
        shown = false;
        return;
      }
      
      function blur(){
        focused = false;
        var val = $element.val();
        if ( (!selected && val !== '') || (selected && val == '') ) {
          $element.val('');
          $source.val('').trigger('change');
          $target.val('').trigger('change');
        }
        if (!mousedover && shown) {setTimeout(function () { hide(); }, 200);}
      }
      
      function toggle(){
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
        var val = $element.val(),
						term = { q: val, page: page, rows: o.rows };
				
				$.each(o.queryParams, function(k, v){
					term[k] = v;
				});
				
				setTimeout(function(){ o.source(term, lookup) }, 100);
			}
	  
      function lookup(data){
				var list = '';
				$menu.html('');
				ttl_page = Math.ceil(data.total/o.rows);
				$.each(data.rows, function(k, v) {
					rowData[v[o.idField]] = v;
					list += '<li class="'+o.item_cls+'" data-'+o.idField+'="'+ v[o.idField] +'" data-'+o.textField+'="'+ v[o.textField] +'"><a>'+v[o.textField]+'</a></li>';
				});
				$menu.append(list);
				$menu.find('li').first().addClass('active');
				show();
				$element.focus();
				loading = false;
      }
      
      function keyup(e){
        switch(e.keyCode) {
          case 40: // down arrow
            if (!shown){
              toggle();
            }
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
      
      function select() {
        var id = $menu.find('.active').data(o.idField),
            text = $menu.find('.active').data(o.textField);
        $element.attr('data-id', id).val(text).trigger('change');
        $target.val(id).trigger('change');
        $source.val(text).trigger('change');
        selected = true;
				o.onSelect.call(this, rowData[id]);
        return hide();
      }

      function fixMenuScroll(){
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
      
			function initValue(){
				var val = $target.val();
				if (!val) return;

				setTimeout(function(){ 
					o.source({id: val}, function(data){
						if (typeof data.rows[0] !== 'undefined'){
							$element.val(data.rows[0].name);
							selected = true;
						}
					});
				}, 100);
			}
			
			function scroll(e){
				$element.focus();
				e.stopPropagation();
				e.preventDefault();
				if (o.type !== 'iscroll') return;

				if (e.currentTarget.scrollHeight - 35 < e.currentTarget.scrollTop + $(e.currentTarget).height()) {
					var curTar = e.currentTarget;
					var lastTop = curTar.scrollTop;
					
					/* if (!loading){
						if (page < ttl_page){
							loading = true;
							page++;
							queries();
							// curTar.scrollTop = lastTop;
							lastScrollPos = lastTop;
							// setTimeout(function(){ curTar.scrollTop = lastTop; console.log(lastTop) }, 500);
						}
					} */
				}
			}
			
      $source.before($container);
      $source.hide();
      $source.attr('id', $source_id+'_old');
      $source.removeAttr('name');
      $source.removeAttr('tabindex');
      if ($source.attr('disabled')!==undefined) disable();
      
      $target.attr('name', $source_name);
      $target.val($source.val());

      $element.attr('id', $source_id);
      $element.attr('placeholder', $source.attr('placeholder'));
      $element.attr('rel', $source.attr('rel'));
      $element.attr('title', $source.attr('title'));
      $element.attr('class', $source.attr('class'));
      $element.attr('required', $source.attr('required'));
      $element.attr('tabindex', $source.attr('tabindex'));
      
			// INIT DEFAULT VALUE IF DEFINED
			initValue();
			
      // LISTEN
      $element
        .on('focus',    function(){ focused = true; })
        .on('blur',     blur)
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
    });
  };

  $.fn.combogrid.defaults = {
    source: null,
    style: 'bs3',
		type: 'normal', // iscroll (infinite scroll), paging, normal
    page: 1,
    rows: 10,
    idField: 'id',
    textField: 'name',
		queryParams: {},

    menu: '<ul class="typeahead-long dropdown-menu dropdown-menu-right"></ul>',
    item_cls: '',
		
		onSelect: function(rowData){}
  };

}(jQuery));
