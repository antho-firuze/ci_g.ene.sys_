<div class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="#">{$.session.page_title}</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">{$.session.user_name}</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="{$.php.base_url()~$.session.user_photo_path~$.session.user_photo_file}" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials">
      <div class="input-group">
        <input type="hidden" class="form-control" name="name" value="{$.session.user_name}">
        <input type="password" class="form-control" placeholder="password" name="password" required>

        <div class="input-group-btn">
          <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="{$.const.LOGOUT_LNK}">Or sign in as a different user</a>
  </div>
  <div class="lockscreen-footer text-center">
    Genesys @2016 - Copyright to it's <a href="http://almsaeedstudio.com">Owner</a>.</b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->
</div>
<script>
	{* init for lockscreen *}
	var lockscreen = $('.lockscreen');
	var form_lck = $('form.lockscreen-credentials');

	get($lockscreen) == 1 ? lockscreen.slideDown('fast') : lockscreen.slideUp('fast');

	function lock_the_screen(){
		store($lockscreen, 1);

		lockscreen.slideDown('fast');
		init_screen_timeout();
	}

	function unlock_the_screen(){
		store($lockscreen, 0);
		
		lockscreen.slideUp('fast');
		init_screen_timeout();
	}
	
	function init_screen_timeout(){
		var is_locked = get($lockscreen) == 1 ? true : false;
		
		$(document).idleTimer("destroy");
		$(document).idleTimer({ timeout:parseInt(get($screen_timeout)), idle: is_locked });
		if (is_locked)
			$(document).idleTimer("pause");
		
		var user_state = get($lockscreen) == 1 ? "2" : "1";
		$.ajax({ url: $BASE_URL+"z_libs/shared/set_user_state", method: "PATCH", async: true, dataType: 'json', data: JSON.stringify({ "_user_state": user_state })	});
	}
	
	init_screen_timeout();
	$(document).on("idle.idleTimer", function(event, elem, obj){ lock_the_screen(); });
	
	form_lck.submit( function(e) {
		e.preventDefault();
		
		$.ajax({ url: "{$.const.AUTH_LNK}", method: "UNLOCK", async: true, dataType: 'json',
			headers: { "X-AUTH": "Basic " + btoa(form_lck.find("input[name='name']").val() + ":" + form_lck.find("input[name='password']").val())	},
			data: JSON.stringify({ "unlock":1 }),
			beforeSend: function(xhr) {	form_lck.find('[type="submit"]').attr("disabled", "disabled"); },
			complete: function(xhr, data) {
				setTimeout(function(){ form_lck.find('[type="submit"]').removeAttr("disabled");	},1000);
			},
			success: function(data) { unlock_the_screen(); },
			error: function(data) {
				if (data.status==500){
					var message = data.statusText;
				} else {
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
				setTimeout(function(){ form_lck.find('[type="submit"]').removeAttr("disabled"); },1000);
				$("div.lockscreen").find(".help-block").html("<b>"+message+"</b>");
			}
		});  
	});
	
	
</script>