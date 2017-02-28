  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{$photo_url}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{$.session.name}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
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
        <li class="header">MENU</li>
		{var $idx = 1}
		{var $menu_id1 = 0}
		{var $menu_id2 = 0}
		{var $menu_id3 = 0}
		{var $close_menu1 = 0}
		{var $close_menu2 = 0}
		{var $close_menu3 = 0}
		{foreach $menus as $menu}
			{if ($menu_id1 != $menu->menu_id1 && !empty($menu->menu_id1))}
			
				{if ($close_menu3)} 
					</li></ul> 
					{var $close_menu3 = 0}
				{/if}
				{if ($close_menu2)} 
					</li></ul> 
					{var $close_menu2 = 0}
				{/if}
				{if ($close_menu1)} 
					</li> 
					{var $close_menu1 = 0}
				{/if}
				
				{if ($idx == 1)}
					<li class="treeview">
						<a href="{$home_link}"><i class="fa fa-dashboard"></i><span>Dashboard</span> </a>
					</li>
				{/if}
				
				<li class="treeview">
					<a href="{$.php.base_url()}systems/x_page?pageid={$menu->menu_id1}" data-menu_id="{$menu->menu_id1}"><i class="fa {$menu->icon1 !: 'fa-circle'}"></i>
						<span>{$menu->name1}</span> {if !empty($menu->menu_id2)} <i class="fa fa-angle-left pull-right"></i>{/if}
					</a>
				  
				{if ($menu_id2 != $menu->menu_id2 && !empty($menu->menu_id2)) }
					<ul class="treeview-menu">
						<li class="{if ($menu->name2 == 'User')} active {/if}">
							<a href="{$.php.base_url()}systems/x_page?pageid={$menu->menu_id2}" data-menu_id="{$menu->menu_id2}"><i class="fa {$menu->icon2 !: 'fa-circle-o'}"></i> {$menu->name2} 
							{if !empty($menu->menu_id3)} <i class="fa fa-angle-left pull-right"></i>{/if}
							</a>
					
					{if ($menu_id3 != $menu->menu_id3 && !empty($menu->menu_id3)) }
						<ul class="treeview-menu">
							<li><a href="{$.php.base_url()}systems/x_page?pageid={$menu->menu_id3}" data-menu_id="{$menu->menu_id3}"><i class="fa {$menu->icon2 !: 'fa-circle-o'}"></i> {$menu->name3}</a>
							
						{var $close_menu3 = 1}
						{var $menu_id3 = $menu->menu_id3}
					{/if}
					
					
					{var $close_menu2 = 1}
					{var $menu_id2 = $menu->menu_id2}
				{/if}
				  
				{var $close_menu1 = 1}  
				
			{elseif ($menu_id1 == $menu->menu_id1)}
			
				{if ($close_menu3)} 
					</li></ul>
					{var $close_menu3 = 0}
				{/if}
				{if ($close_menu2)} 
					</li>
					{var $close_menu2 = 0}
				{/if}
				
				{if ($menu_id2 != $menu->menu_id2 && !empty($menu->menu_id2)) }
					<li><a href="{$.php.base_url()}systems/x_page?pageid={$menu->menu_id2}" data-menu_id="{$menu->menu_id2}"><i class="fa fa-circle-o"></i> {$menu->name2}</a>
					
					{var $close_menu2 = 1}
					{var $menu_id2 = $menu->menu_id2}
					
				{elseif ($menu_id2 == $menu->menu_id2)}
					<li><a href="{$.php.base_url()}systems/x_page?pageid={$menu->menu_id3}" data-menu_id="{$menu->menu_id3}"><i class="fa fa-circle-o"></i> {$menu->name3}</a>
					
					{var $close_menu3 = 1}
					{var $menu_id3 = $menu->menu_id3}
				{/if}
			{/if}
			
			{var $idx = $idx + 1}
			{var $menu_id1 = $menu->menu_id1}
		{/foreach}
		{if ($close_menu1)} 
			</li></ul>
		{/if}
        <li class="header">OTHERS</li>
        <li><a href="#" id="go-change-pwd"><i class="fa fa-circle-o text-aqua"></i> <span>Change Password</span></a></li>
        <li><a href="#" id="go-lock-screen"><i class="fa fa-circle-o text-yellow"></i> <span>Lock Screen</span></a></li>
        <li><a href="{$logout_link}" id="go-sign-out"><i class="fa fa-circle-o text-red"></i> <span>Sign Out</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  