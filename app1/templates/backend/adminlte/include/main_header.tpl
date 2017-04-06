  <header class="main-header">
    <!-- Logo -->
    <a href="{$.const.APPS_LNK}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>{$.session.logo_text_mn}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{$.session.logo_text_lg}</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <!-- search form -->
      {* <form class="navbar-form navbar-left sidebar-form" role="search"> *}
      <div class="navbar-form navbar-left search-menu-form">
      {* <div class="navbar-form navbar-left sidebar-form"> *}
        <div class="input-group">
          <input type="text" id="searching-menu" name="q" class="form-control" autocomplete="off" placeholder="Searching Menu...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </div>
      {* </form> *}
      <!-- /.search form -->
	  
	  <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
		  {if (isset($message_navbar))}
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          {/if}
		  <!-- Notifications: style can be found in dropdown.less -->
		  {if (isset($notofication_navbar))}
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          {/if}
          <!-- Tasks: style can be found in dropdown.less -->
		  {if (isset($tasks_navbar))}
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          {/if}
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{$.php.base_url()~$.session.user_photo_path~$.session.user_photo_file}" class="user-image" alt="User Image">
              <span class="hidden-xs">{$.session.user_name}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{$.php.base_url()~$.session.user_photo_path~$.session.user_photo_file}" class="img-circle" alt="User Image">

                <p>
                  {$.session.user_name} - {$.session.user_email}
                  <small>{$.session.user_description}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
			    <div class="row">
                  <div class="col-xs-4 text-left">
                    Client:
                  </div>
                  <div class="col-xs-8 text-left">
                    <a href="#">{$.session.client_name}</a>
                  </div>
				</div>
			    <div class="row">
                  <div class="col-xs-4 text-left">
                    Organization:
                  </div>
                  <div class="col-xs-8 text-left">
                    <a href="#">{$.session.org_name}</a>
                  </div>
				</div>
			    <div class="row">
                  <div class="col-xs-4 text-left">
                    Role:
                  </div>
                  <div class="col-xs-8 text-left">
                    <a href="#">{$.session.role_name}</a>
                  </div>
				</div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
								<div class="row" style="margin-right:0px;">
									<div class="col-md-4">
										<a href="{$.const.PROFILE_LNK}" class="btn btn-default btn-flat">Profile</a>
									</div>
									<div class="col-md-4">
										<a href="{$.const.RELOAD_LNK}" class="btn btn-default btn-flat" id="reload_session">Reload</a>
									</div>
									<div class="col-md-4">
										<a href="{$.const.LOGOUT_LNK}" class="btn btn-default btn-flat">Sign out</a>
									</div>
								</div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
<script>
	$("#reload_session").click(function(e){
		var last_url = window.location.href;
		$.getJSON('{$.const.RELOAD_LNK}', '', function(data){ window.location.replace(last_url); });
	});
</script>