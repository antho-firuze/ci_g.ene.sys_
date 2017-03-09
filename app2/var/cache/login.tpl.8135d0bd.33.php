<?php 
/** Fenom template 'backend/adminlte/pages/systems/auth/login.tpl' compiled at 2017-03-08 16:40:16 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:7: {var $template_url = $.php.base_url() ~ "templates/" ~ $theme_path} */
 $var["template_url"]=(call_user_func_array('base_url', array()).strval("templates/").strval($var["theme_path"])); ?> <!DOCTYPE html><html><head><script type="text/javascript" src="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:11: {$.const.ASSET_URL} */
 echo @constant('ASSET_URL'); ?>js/common.func.js"></script><script>  <?php
/* backend/adminlte/pages/systems/auth/login.tpl:14: {var $head_title = $head_title !: $.const.APP_TITLE_B} */
 $var["head_title"]=(isset($var["head_title"]) ? $var["head_title"] : (@constant('APP_TITLE_B'))); ?> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:15: {var $page_title = $.const.TITLE_B} */
 $var["page_title"]=@constant('TITLE_B'); ?> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:17: {var $home_link = $.php.base_url()~$.const.HOME_B_LNK} */
 $var["home_link"]=(call_user_func_array('base_url', array()).strval(@constant('HOME_B_LNK'))); ?> var base_url = '<?php
/* backend/adminlte/pages/systems/auth/login.tpl:18: {$.php.base_url()} */
 echo call_user_func_array('base_url', array()); ?>'; </script><meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"><title><?php
/* backend/adminlte/pages/systems/auth/login.tpl:24: {$head_title} */
 echo $var["head_title"]; ?></title><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:26: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/css/bootstrap.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:27: {$template_url} */
 echo $var["template_url"]; ?>font-awesome/css/font-awesome.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:28: {$template_url} */
 echo $var["template_url"]; ?>plugins/ionicons/css/ionicons.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:29: {$template_url} */
 echo $var["template_url"]; ?>dist/css/AdminLTE.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:30: {$template_url} */
 echo $var["template_url"]; ?>dist/css/skins/_all-skins.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:31: {$template_url} */
 echo $var["template_url"]; ?>css/custom.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:32: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:33: {$template_url} */
 echo $var["template_url"]; ?>plugins/iCheck/square/blue.css"><link rel="stylesheet" href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:34: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-dialog/css/bootstrap-dialog.min.css"><script src="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:36: {$template_url} */
 echo $var["template_url"]; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script><script src="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:37: {$template_url} */
 echo $var["template_url"]; ?>bootstrap/js/bootstrap.min.js"></script><script src="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:38: {$template_url} */
 echo $var["template_url"]; ?>plugins/pace/pace.min.js"></script><script src="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:39: {$template_url} */
 echo $var["template_url"]; ?>plugins/iCheck/icheck.min.js"></script><script src="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:40: {$template_url} */
 echo $var["template_url"]; ?>plugins/bootstrap-dialog/js/bootstrap-dialog.min.js"></script><script src="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:41: {$template_url} */
 echo $var["template_url"]; ?>plugins/validation/jquery.validate.min.js"></script></head><body class="hold-transition login-page"><div class="login-box"><div class="login-logo"><a href="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:47: {$home_link} */
 echo $var["home_link"]; ?>"><?php
/* backend/adminlte/pages/systems/auth/login.tpl:47: {$page_title} */
 echo $var["page_title"]; ?></a></div><!-- /.login-logo --><div class="login-box-body"><p class="login-box-msg">Sign in to start your session</p><form action="<?php
/* backend/adminlte/pages/systems/auth/login.tpl:53: {$.php.base_url()~$.const.AUTH_LNK} */
 echo (call_user_func_array('base_url', array()).strval(@constant('AUTH_LNK'))); ?>"><div class="form-group has-feedback"><span class="glyphicon glyphicon-user form-control-feedback"></span><input type="text" class="form-control" placeholder="User Name" name="username"></div><div class="form-group has-feedback"><span class="glyphicon glyphicon-lock form-control-feedback"></span><input type="password" class="form-control" placeholder="Password" name="password"></div><div class="row"><div class="col-xs-8"><div class="checkbox icheck"><label><input type="checkbox" value="true" name="remember"> Remember Me <input type="hidden" value="false" name="remember"></label></div></div><!-- /.col --><div class="col-xs-4"><button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button></div><!-- /.col --></div></form> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:79: {if (isset($facebook) || isset($gplus))} */
 if((isset($var["facebook"]) || isset($var["gplus"]))) { ?> <div class="social-auth-links text-center"><p>- OR -</p> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:82: {if (isset($facebook))} */
 if((isset($var["facebook"]))) { ?> <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:85: {/if} */
 } ?> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:86: {if (isset($gplus))} */
 if((isset($var["gplus"]))) { ?> <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:89: {/if} */
 } ?> </div> <?php
/* backend/adminlte/pages/systems/auth/login.tpl:91: {/if} */
 } ?> <!-- /.social-auth-links -->  </div><!-- /.login-box-body --></div><!-- /.login-box --><div style="position: fixed; bottom: 0; width: 100%;"> Server [<strong><?php
/* backend/adminlte/pages/systems/auth/login.tpl:102: {$elapsed_time} */
 echo $var["elapsed_time"]; ?></strong>] - Client [<strong><?php
/* backend/adminlte/pages/systems/auth/login.tpl:102: {microtime(true)-$start_time} */
 echo microtime(true) - $var["start_time"]; ?></strong>] </div><script> $(document).ajaxStart(function() { Pace.restart(); }); $('input').iCheck({  checkboxClass: 'icheckbox_square-blue', radioClass: 'iradio_square-blue', increaseArea: '20%' }); var form = $('form'); form.validate({  rules: {  username: {  required: true }, password: {  required: true } } }); form.submit( function(e) {  e.preventDefault(); if (! form.valid()) return false; var params = {}; $.each(form.serializeArray(), function (index, value) {  params[value.name] = params[value.name] ? params[value.name] || value.value : value.value; });  $.ajax({  url: form.attr("action"), method: "GET", async: true, dataType: 'json', headers: {  "X-AUTH": "Basic " + btoa(params.username + ":" + params.password) }, beforeSend: function(xhr) {  form.find('[type="submit"]').attr("disabled", "disabled"); }, complete: function(xhr, data) {  setTimeout(function(){  form.find('[type="submit"]').removeAttr("disabled"); },1000); }, success: function(data) {  store("lockscreen", 0); window.location.replace('<?php
/* backend/adminlte/pages/systems/auth/login.tpl:156: {$.php.site_url('systems')} */
 echo call_user_func_array('site_url', array('systems')); ?>');  }, error: function(data, status, errThrown) {  if (data.status==500){   var message = data.statusText; } else {   var error = JSON.parse(data.responseText); var message = error.message; }  setTimeout(function(){  form.find('[type="submit"]').removeAttr("disabled"); },1000); BootstrapDialog.alert({ type:'modal-danger', title:'Error ('+data.status+') :', message:message }); } }); }); </script></body></html> <?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/pages/systems/auth/login.tpl',
	'base_name' => 'backend/adminlte/pages/systems/auth/login.tpl',
	'time' => 1488187619,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/pages/systems/auth/login.tpl' => 1488187619,
  ),
),
	'macros' => array(),

        ));
