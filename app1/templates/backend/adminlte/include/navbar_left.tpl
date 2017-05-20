  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{$.php.base_url()~$.session.user_photo_path~$.session.user_photo_file}" onclick="window.location.href = '{$.const.PROFILE_LNK}';" class="img-circle" alt="User Image" style="cursor:pointer; cursor:hand;">
        </div>
        <div class="pull-left info">
          <p><a href="{$.const.PROFILE_LNK}">{$.session.user_name}</a></p>
          <a href="{$.const.PROFILE_LNK}"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      {* <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> *}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">BACKEND SYSTEM | {$.session.page_title}</li>
				{$menus}
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  