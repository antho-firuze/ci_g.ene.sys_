  <header class="main-header">
    <!-- Logo -->
    <a href="{$home_link}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>{$logo_text_mn}</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{$logo_text_lg}</b></span>
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
      {* <form id="searching-menu" class="navbar-form navbar-left sidebar-form" role="search">
        <div class="input-group">
          <input type="text" name="q" class="form-control" autocomplete="off" placeholder="Searching Menu...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> *}
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
          <!-- Sign In/Login: style can be found in dropdown.less -->
          <li>
            <a href="{$login_link}">
				<i class="fa fa-lock"></i>
				<span class="hidden-xs"> &nbsp;&nbsp;&nbsp; Login</span>
			</a>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
         {*  <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{$photo_url}" class="user-image" alt="User Image">
              <span class="hidden-xs">{$name}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{$photo_url}" class="img-circle" alt="User Image">

                <p>
                  {$name} - {$email}
                  <small>{$description}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
			    <div class="row">
                  <div class="col-xs-4 text-left">
                    Client:
                  </div>
                  <div class="col-xs-8 text-left">
                    <a href="#">{$client_name}</a>
                  </div>
				</div>
			    <div class="row">
                  <div class="col-xs-4 text-left">
                    Organization:
                  </div>
                  <div class="col-xs-8 text-left">
                    <a href="#">{$org_name}</a>
                  </div>
				</div>
			    <div class="row">
                  <div class="col-xs-4 text-left">
                    Role:
                  </div>
                  <div class="col-xs-8 text-left">
                    <a href="#">{$role_name}</a>
                  </div>
				</div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{$profile_link}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{$logout_link}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li> *}
          <!-- Control Sidebar Toggle Button -->
          {* <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> *}
        </ul>
      </div>
    </nav>
  </header>
