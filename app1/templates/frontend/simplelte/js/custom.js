/**
 * General Function
 *
 */

(function ($) {

  "use strict";
  
  $(document).ajaxStart(function() { Pace.restart(); });

})(jQuery);

/**
 * AdminLTE Right Menu
 * ------------------
 * 
 * Skin & Screen Timeout
 */
(function ($) {

  "use strict";

  /**
   * List of all the available skins
   *
   * @type Array
   */
  var my_skins = [
    "skin-blue",
    "skin-black",
    "skin-red",
    "skin-yellow",
    "skin-purple",
    "skin-green",
    "skin-blue-light",
    "skin-black-light",
    "skin-red-light",
    "skin-yellow-light",
    "skin-purple-light",
    "skin-green-light"
  ];

  //Create the tab button
  var tab_button_options = $("<li />", {"class": "active"})
      .html("<a href='#control-sidebar-options-tab' data-toggle='tab'>"
      + "<i class='fa fa-wrench'></i>"
      + "</a>");

  //Add the tab button to the right sidebar tabs
  var tab_button_settings = $("[href='#control-sidebar-settings-tab']");
  tab_button_settings
      .parent()
      .before(tab_button_options);

  //Create the new tab
  var tab_pane = $("[class='tab-content']");
  var tab_pane_options = $("<div />", {
    "id": "control-sidebar-options-tab",
    "class": "tab-pane active"
  });

  var tab_pane_settings = $("<div />", {
    "id": "control-sidebar-settings-tab",
    "class": "tab-pane"
  });

  //Create the menu
  var page_options = $("<div />");
  page_options.append("<h4 class='control-sidebar-heading'>Skins</h4>");

  var skins_list = $("<ul />", {"class": 'list-unstyled clearfix'});
  //Dark sidebar skins
  var skin_blue =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-blue' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span class='bg-light-blue' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin'>Blue</p>");
  skins_list.append(skin_blue);
  var skin_black =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-black' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin'>Black</p>");
  skins_list.append(skin_black);
  var skin_purple =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-purple' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-purple-active'></span><span class='bg-purple' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin'>Purple</p>");
  skins_list.append(skin_purple);
  var skin_green =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-green' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-green-active'></span><span class='bg-green' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin'>Green</p>");
  skins_list.append(skin_green);
  var skin_red =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-red' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-red-active'></span><span class='bg-red' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin'>Red</p>");
  skins_list.append(skin_red);
  var skin_yellow =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-yellow' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-yellow-active'></span><span class='bg-yellow' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #222d32;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin'>Yellow</p>");
  skins_list.append(skin_yellow);

  //Light sidebar skins
  var skin_blue_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-blue-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px; background: #367fa9;'></span><span class='bg-light-blue' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>Blue Light</p>");
  skins_list.append(skin_blue_light);
  var skin_black_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-black-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div style='box-shadow: 0 0 2px rgba(0,0,0,0.1)' class='clearfix'><span style='display:block; width: 20%; float: left; height: 7px; background: #fefefe;'></span><span style='display:block; width: 80%; float: left; height: 7px; background: #fefefe;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>Black Light</p>");
  skins_list.append(skin_black_light);
  var skin_purple_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-purple-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-purple-active'></span><span class='bg-purple' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>Purple Light</p>");
  skins_list.append(skin_purple_light);
  var skin_green_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-green-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-green-active'></span><span class='bg-green' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>Green Light</p>");
  skins_list.append(skin_green_light);
  var skin_red_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-red-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-red-active'></span><span class='bg-red' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px'>Red Light</p>");
  skins_list.append(skin_red_light);
  var skin_yellow_light =
      $("<li />", {style: "float:left; width: 33.33333%; padding: 5px;"})
          .append("<a href='javascript:void(0);' data-skin='skin-yellow-light' style='display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)' class='clearfix full-opacity-hover'>"
          + "<div><span style='display:block; width: 20%; float: left; height: 7px;' class='bg-yellow-active'></span><span class='bg-yellow' style='display:block; width: 80%; float: left; height: 7px;'></span></div>"
          + "<div><span style='display:block; width: 20%; float: left; height: 20px; background: #f9fafc;'></span><span style='display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;'></span></div>"
          + "</a>"
          + "<p class='text-center no-margin' style='font-size: 12px;'>Yellow Light</p>");
  skins_list.append(skin_yellow_light);

  page_options.append(skins_list);
  tab_pane_options.append(page_options);
  
  // PAGE SETTING PANE
  var page_settings = $("<form method='post' />")
	.append("<h4 class='control-sidebar-heading'>General Settings</h4>");
  
  tab_pane_settings.append(page_settings);
  
  tab_pane.append(tab_pane_settings);
  tab_pane.append(tab_pane_options);
  
  setup();

  /**
   * Replaces the old skin with the new skin
   * @param String cls the new skin class
   * @returns Boolean false to prevent link's default action
   */
  function change_skin(cls) {
    $.each(my_skins, function (i) {
      $("body").removeClass(my_skins[i]);
    });

    $("body").addClass(cls);
    store('skin', cls);
    return false;
  }

  /**
   * Retrieve default settings and apply them to the template
   *
   * @returns void
   */
  function setup() {
    var tmp = get('skin');
    if (tmp && $.inArray(tmp, my_skins))
      change_skin(tmp);

    //Add the change skin listener
    $("[data-skin]").on('click', function (e) {
      e.preventDefault();
      change_skin($(this).data('skin'));
	
	  $.ajax({
		  url: setUserConfig_url,
		  method: "POST",
		  dataType: 'json',
		  data: '{"skin": "'+$(this).data('skin')+'"}'
	  });
    });

    //Add the change sidebar toggle
	$("[class='sidebar-toggle']").on("click", function(){
		if (get('sidebar'))
			store('sidebar', '');
		else
			store('sidebar', 'sidebar-collapse');
		
		$.ajax({
		  url: setUserConfig_url,
		  method: "POST",
		  dataType: 'json',
		  data: '{ "sidebar": "' + get('sidebar') +'" }'
		});
	});
		
  }
})(jQuery);


/** 
 * Initialize 
 *
 */
(function ($) {

	"use strict";
  
	/* 
	* FOR SEARCHING MENU 
	*/
	// init();
	
	function init() {
		var xhr;
		$('input[name="q"]').autoComplete({
			minChars: 1,
			delay: 0,
			source: function(term, response){
				try { xhr.abort(); } catch(e){}
				xhr = $.getJSON(setMenuSearch_url, { q: term }, function(data){ 
					response(data.data);
				});
				/* $.getJSON(setMenuSearch_url, { q: term }, function(data){ 
					response(data.data);
				}); */
			},
			renderItem: function (item, search){
				search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
				var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
				return '<div style="height:35px; width:300px; padding-top:7px;" class="autocomplete-suggestion" data-href="' + item[1] + '" data-val="' + item[0] + '"><i class="fa fa-circle-o"></i> '+ item[0].replace(re, "<b>$1</b>") + '</div>';
			},
			onSelect: function(e, term, item){
				// window.location.replace(base_url+item.data('href'));
				window.location.href = base_url+item.data('href');
			} 
		})
		.closest('form')
		.submit(function(e){
			e.preventDefault();
			
			var q = $('input[name="q"]');
			var tx = q.val();
			q.val('').trigger('keyup'); 
			q.focus();
			q.val(tx).trigger('keyup'); 
				
			return false;
		});
	}
	
	/* 
	* Change Password Process 
	*/
	$('#go-change-pwd').on('click', function(e){
		e.preventDefault();

		var content = $('<div />');
		var form = $('<form />', {class: 'form-horizontal'});
		var input_username = 
			$('<div />', {class: 'form-group'})
			.append('<label for="username" class="col-sm-4 control-label">User Name</label>'
			+ '<div class="col-sm-8"><input type="text" class="form-control" id="username" value="'+username+'" name="name" disabled></div>');
		form.append(input_username);
		var input_passold = 
			$('<div />', {class: 'form-group'})
			.append('<label for="password" class="col-sm-4 control-label">Password (Old)</label>'
			+ '<div class="col-sm-8"><input type="password" class="form-control" id="password" name="password"></div>');
		form.append(input_passold);
		var input_passnew = 
			$('<div />', {class: 'form-group'})
			.append('<label for="password_new" class="col-sm-4 control-label">Password (New)</label>'
			+ '<div class="col-sm-8"><input type="password" class="form-control" id="password_new" name="password_new"></div>');
		form.append(input_passnew);
		var input_passconfirm = 
			$('<div />', {class: 'form-group'})
			.append('<label for="password_confirm" class="col-sm-4 control-label">Password (Confirm)</label>'
			+ '<div class="col-sm-8"><input type="password" class="form-control" id="password_confirm" name="password_confirm"></div>');
		form.append(input_passconfirm);
		content.append(form);
		
		BootstrapDialog.show({ cssClass: 'modal-primary',
			title: 'Change Password',
			message: content,
			buttons: [{
				icon: 'glyphicon glyphicon-send',
				cssClass: 'btn-primary',
                label: '&nbsp;&nbsp;Save',
                action: function(dialog) {
					
					if (! form.valid()) return false;
					
					var button = this;
					button.spin();
					
					// dialog.setClosable(false);
					// dialog.enableButtons(false);
					
					$.ajax({ url: setCHPass_url, method: "POST", async: true, dataType: 'json',
						data: '{"password_new": "'+form.find("input[name='password_new']").val()+'"}',
						headers: {
							"X-AUTH": "Basic " + btoa(form.find("input[name='name']").val() + ":" + form.find("input[name='password']").val())
						},
						success: function(data) {
							BootstrapDialog.alert({ type:'modal-info', title:'Notification', message:data.message, callback: function(){
									dialog.close();
								}
							});
						},
						error: function(data) {
							var error = JSON.parse(data.responseText);
							
							button.stopSpin();
							dialog.enableButtons(true);
							dialog.setClosable(true);
							
							BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:error.message });
						}
					});
                }
            }, {
                label: 'Close',
                action: function(dialog) { dialog.close(); }
            }],
			onshown: function(dialog) {
				form.validate({
					rules: {
						password: {
							required: true
						},
						password_new: {
							required: true,
							minlength: 3
						},
						password_confirm: {
							required: true,
							minlength: 3,
							equalTo: "#password_new"
						},
					}
				});
				$('#password').focus();
				// dialog.getModalDialog().css("top", Math.max(0, ($(window).height() - dialog.getModalContent().height()) / 2));
			}
		});
	});
	
})(jQuery);
