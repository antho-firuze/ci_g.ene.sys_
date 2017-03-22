<div class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="#">{$page_title}</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">{$.session.name}</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="{$photo_url}" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials">
      <div class="input-group">
        <input type="hidden" class="form-control" name="name" value="{$.session.name}">
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
    <a href="{$logout_link}">Or sign in as a different user</a>
  </div>
  <div class="lockscreen-footer text-center">
    Genesys @2016 - Copyright to it's <a href="http://almsaeedstudio.com">Owner</a>.</b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->
</div>
