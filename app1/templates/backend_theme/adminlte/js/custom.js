/**
 * General Function
 *
 */

function init_screen_timeout()
{
	$(document).idleTimer("destroy");
	$(document).idleTimer(parseInt(get("screen_timeout")));
}

function lock_screen()
{
	store("lockscreen", 1);
	$('.lockscreen').slideDown('fast');
	$(document).idleTimer("destroy");
}

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
  
  var select_screen_timeout = 
    $("<div />", {"class": "form-group"})
	  .append("<label>Screen Timeout</label>");
	  
  var j_timeout = { 
	"60000":"1 minute",
	"120000":"2 minutes",
	"180000":"3 minutes",
	"300000":"5 minutes",
	"600000":"10 minutes",
	"900000":"15 minutes",
	"1200000":"20 minutes",
	"1500000":"25 minutes",
	"1800000":"30 minutes",
	"2700000":"45 minutes",
	"3600000":"1 hour",
	"7200000":"2 hours",
	"10800000":"3 hours",
	"14400000":"4 hours",
	"18000000":"5 hours"
   };
  select_screen_timeout.append(setSelectList("timeout_list", "timeout_list", "form-control", j_timeout));
  page_settings.append(select_screen_timeout);
  
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
   * Store a new settings in the browser
   *
   * @param String name Name of the setting
   * @param String val Value of the setting
   * @returns void
   */
  function store(name, val) {
    if (typeof (Storage) !== "undefined") {
      localStorage.setItem(name, val);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
  }

  /**
   * Get a prestored setting
   *
   * @param String name Name of of the setting
   * @returns String The value of the setting | null
   */
  function get(name) {
    if (typeof (Storage) !== "undefined") {
      return localStorage.getItem(name);
    } else {
      window.alert('Please use a modern browser to properly view this template!');
    }
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
		
    //Add the change timeout_list
	$("#timeout_list").change(function() {
		store('screen_timeout', $("#timeout_list").val());
		init_screen_timeout();
		
		$.ajax({
			url: setUserConfig_url,
			method: "POST",
			dataType: 'json',
			data: '{"screen_timeout": "'+$("#timeout_list").val()+'"}'
		});
	});
	
	$("#timeout_list").val(get("screen_timeout"));
  }
})(jQuery);


/** 
 * Initialize Custom
 *
 */
(function ($) {

	"use strict";
  
	/* 
   	* Initialization for screen timeout
   	*/
	init_screen_timeout();
	
	var lockscreen = $('.lockscreen');
	$(document).on("idle.idleTimer", function(event, elem, obj){
		lock_screen();
    });
	
	(get("lockscreen")==1) ? lockscreen.slideDown() : lockscreen.slideUp();
	
	$("#go-lock-screen").click(function(e){
		e.preventDefault();
		lock_screen();
	});
	
	$("#go-sign-out").click(function(e){
		e.preventDefault();
		if (confirm("Are you sure ?"))
			window.location.replace($("#go-sign-out").attr('href'));
	});
	
	/* 
	* Validation for unlock screen 
	*/
    var form_lck = $('form.lockscreen-credentials');
	form_lck.validate({
	  rules: {
	    password: {
	      required: true
	    }
	  }
	});
	
	form_lck.submit( function(e) {
		e.preventDefault();
		
		if (! form_lck.valid()) return false;
		
		$.ajax({ url: setUnlockScreen_url, method: "GET", async: true, dataType: 'json',
			headers: {
				"X-AUTH": "Basic " + btoa(form_lck.find("input[name='name']").val() + ":" + form_lck.find("input[name='password']").val())
			},
			beforeSend: function(xhr) {
				form_lck.find('[type="submit"]').attr("disabled", "disabled");
			},
			complete: function(xhr, data) {
				setTimeout(function(){
					form_lck.find('[type="submit"]').removeAttr("disabled");
				},1000);
			},
			success: function(data) {
				store("lockscreen", 0);
				lockscreen.slideUp('fast');
				init_screen_timeout();
			},
			error: function(data) {
				var error = JSON.parse(data.responseText);
				dhtmlx.alert({ title: "Notification", type:"alert-error", text: error.message });
			}
		});  
	});
	
	/* 
	* FOR SEARCHING MENU 
	*/
	var xhr;
	$('#searching-menu').autoComplete({
		minChars: 1,
		delay: 0,
		// cache: false,
		source: function(term, response){
			try { xhr.abort(); } catch(e){}
			xhr = $.getJSON(setMenuSearch_url, { q: term }, function(data){ response(data.data); });
			// $.getJSON(setMenuSearch_url, { q: term }, function(data){ response(data.data); });
		},
		renderItem: function (item, search){
			search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
			var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
			/* return '<div style="height:35px; width:300px; padding-top:7px;" class="autocomplete-suggestion" data-href="' + item[1] + '" data-val="' + item[0] + '"><i class="fa fa-circle-o"></i> '+ item[0].replace(re, "<b>$1</b>") + '</div>'; */
			return '<div style="height:35px; width:300px; padding-top:7px;" class="autocomplete-suggestion" data-href="' + item['url'] + '" data-val="' + item['name'] + '"><i class="fa fa-circle-o"></i> '+ item['name'].replace(re, "<b>$1</b>") + '</div>';
		},
		onSelect: function(e, term, item){
			// window.location.replace(base_url+item.data('href'));
			window.location.href = base_url+item.data('href');
		} 
	});
  
	/* 
	* Change Password Process 
	*/
	$('#go-change-pwd').on('click', function(e){
		e.preventDefault();

		var content = $('<div />');
		var form = $('<form />', {class: 'form-horizontal'});
		form.append(setForm_Input('text', 'User Name', 'username', username, '', '', false, true, false));
		form.append(setForm_Input('password', 'Password (Old)', 'password'));
		form.append(setForm_Input('password', 'Password (New)', 'password_new'));
		form.append(setForm_Input('password', 'Password (Confirm)', 'password_confirm'));
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
							if (data.status==500){
								var message = data.statusText;
							} else {
								var error = JSON.parse(data.responseText);
								var message = error.message;
							}
							
							button.stopSpin();
							dialog.enableButtons(true);
							dialog.setClosable(true);
							
							BootstrapDialog.alert({ type:'modal-danger', title:'Notification', message:message });
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
