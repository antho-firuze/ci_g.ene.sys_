{* 
	Template Name: AdminLTE 
	Modified By: Firuze
	Email: antho.firuze@gmail.com
	Github: antho-firuze
*}
{var $template_url = $.php.base_url() ~ "templates/" ~ $theme_path}
{* {var $template_url = "{$.php.base_url()}{$template_url}"} *}
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="{$.const.ASSET_URL}genesys/js/common.func.js"></script>
<script>
	{* DECLARE VARIABLE *}
	{var $head_title = $head_title !: $.const.APP_TITLE}
	{var $page_title = '<b>GENESYS</b>Ultimate'}
	
	{var $home_link = $.php.base_url('systems')}
	var base_url = '{$.php.base_url()}';
</script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title>{$head_title}</title>

<link rel="stylesheet" href="{$template_url}bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="{$template_url}font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="{$template_url}plugins/ionicons/css/ionicons.min.css">
<link rel="stylesheet" href="{$template_url}dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="{$template_url}dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="{$template_url}css/custom.css">
<link rel="stylesheet" href="{$template_url}plugins/pace/pace.min.css">
<link rel="stylesheet" href="{$template_url}plugins/iCheck/square/blue.css">
<link rel="stylesheet" href="{$template_url}plugins/bootstrap-dialog/css/bootstrap-dialog.min.css">

<script src="{$template_url}plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="{$template_url}bootstrap/js/bootstrap.min.js"></script>
<script src="{$template_url}plugins/pace/pace.min.js"></script>
<script src="{$template_url}plugins/iCheck/icheck.min.js"></script>
<script src="{$template_url}plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
<script src="{$template_url}plugins/validation/jquery.validate.min.js"></script>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{$home_link}">{$page_title}</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{$validate_link}">
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <input type="text" class="form-control" placeholder="User Name" name="username">
      </div>
      <div class="form-group has-feedback">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <input type="password" class="form-control" placeholder="Password" name="password">
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" value="true" name="remember"> Remember Me
              <input type="hidden" value="false" name="remember">
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

	{if (isset($facebook) || isset($gplus))}
		<div class="social-auth-links text-center">
		  <p>- OR -</p>
		{if (isset($facebook))}
		  <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
			Facebook</a>
		{/if}
		{if (isset($gplus))}
		  <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
			Google+</a>
		{/if}
		</div>
	{/if}
    <!-- /.social-auth-links -->
	{*
    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>
	*}
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<div style="position: fixed; bottom: 0; width: 100%;">
	Server [<strong>{$elapsed_time}</strong>] - Client [<strong>{microtime(true)-$start_time}</strong>]
</div>

<script>
	$(document).ajaxStart(function() { Pace.restart(); });
	
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue', 
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%' 
	});
	
	var form = $('form');
	form.validate({
		rules: {
			username: {
				required: true
			},
			password: {
				required: true
			}
		}
	});
	
	form.submit( function(e) {
		e.preventDefault();
		
		if (! form.valid())	return false;
			
		var params = {};
		$.each(form.serializeArray(), function (index, value) {
			params[value.name] = params[value.name] ? params[value.name] || value.value : value.value;
		});
		
		{* console.log(form.valid()); return false; *}
		
		$.ajax({
			url: form.attr("action"),
			method: "GET",
			async: true,
			dataType: 'json',
			headers: {
				"X-AUTH": "Basic " + btoa(params.username + ":" + params.password)
			},
			beforeSend: function(xhr) {
				form.find('[type="submit"]').attr("disabled", "disabled");
			},
			complete: function(xhr, data) {
				setTimeout(function(){
					form.find('[type="submit"]').removeAttr("disabled");
				},1000);
			},
			success: function(data) {
				store("lockscreen", 0);
				window.location.replace('{$.php.site_url('systems')}');
				{* window.location.href = '{$.php.site_url('systems')}'; *}
			},
			error: function(data, status, errThrown) {
				if (data.status==500){
					{* Error from network *}
					var message = data.statusText;
				} else {
					{* Error from server *}
					var error = JSON.parse(data.responseText);
					var message = error.message;
				}
					
				{* dhtmlx.alert({ title: "Notification", type:"alert-error", text: error.message }); *}
				setTimeout(function(){
					form.find('[type="submit"]').removeAttr("disabled");
				},1000);
				BootstrapDialog.alert({ type:'modal-danger', title:'Error ('+data.status+') :', message:message });
			}
		});
	}); 
	
</script>
</body>
</html>
