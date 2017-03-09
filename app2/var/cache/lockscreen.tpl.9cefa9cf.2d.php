<?php 
/** Fenom template 'backend/adminlte/include/lockscreen.tpl' compiled at 2017-03-08 16:40:22 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?><div class="hold-transition lockscreen"><!-- Automatic element centering --><div class="lockscreen-wrapper"><div class="lockscreen-logo"><a href="#"><?php
/* backend/adminlte/include/lockscreen.tpl:5: {$page_title} */
 echo $var["page_title"]; ?></a></div><!-- User name --><div class="lockscreen-name"><?php
/* backend/adminlte/include/lockscreen.tpl:8: {$.session.name} */
 echo (isset($_SESSION["name"]) ? $_SESSION["name"] : null); ?></div><!-- START LOCK SCREEN ITEM --><div class="lockscreen-item"><!-- lockscreen image --><div class="lockscreen-image"><img src="<?php
/* backend/adminlte/include/lockscreen.tpl:14: {$photo_url} */
 echo $var["photo_url"]; ?>" alt="User Image"></div><!-- /.lockscreen-image --><!-- lockscreen credentials (contains the form) --><form class="lockscreen-credentials"><div class="input-group"><input type="hidden" class="form-control" name="name" value="<?php
/* backend/adminlte/include/lockscreen.tpl:21: {$.session.name} */
 echo (isset($_SESSION["name"]) ? $_SESSION["name"] : null); ?>"><input type="password" class="form-control" placeholder="password" name="password"><div class="input-group-btn"><button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button></div></div></form><!-- /.lockscreen credentials --></div><!-- /.lockscreen-item --><div class="help-block text-center"> Enter your password to retrieve your session </div><div class="text-center"><a href="<?php
/* backend/adminlte/include/lockscreen.tpl:37: {$logout_link} */
 echo $var["logout_link"]; ?>">Or sign in as a different user</a></div><div class="lockscreen-footer text-center"> Genesys @2016 - Copyright to it's <a href="http://almsaeedstudio.com">Owner</a>.</b><br> All rights reserved </div></div><!-- /.center --></div><?php
}, array(
	'options' => 20608,
	'provider' => false,
	'name' => 'backend/adminlte/include/lockscreen.tpl',
	'base_name' => 'backend/adminlte/include/lockscreen.tpl',
	'time' => 1487553826,
	'depends' => array (
  0 => 
  array (
    'backend/adminlte/include/lockscreen.tpl' => 1487553826,
  ),
),
	'macros' => array(),

        ));
