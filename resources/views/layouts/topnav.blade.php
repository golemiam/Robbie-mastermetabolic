<nav class="site-navbar navbar navbar-default navbar-fixed-top navbar-mega" role="navigation">
    <div class="navbar-header">
    <button data-toggle="menubar" class="navbar-toggle hamburger hamburger-close navbar-toggle-left unfolded hided" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="hamburger-bar"></span>
      </button>
      <div class="navbar-brand navbar-brand-center site-gridmenu-toggle" data-toggle="gridmenu">
        <img class="navbar-brand-logo" src="/images/mm_logo.png" title="Master Metabolic">
        <span class="navbar-brand-text"></span>
      </div>
    </div>
    <div class="navbar-container container-fluid">
      <!-- Navbar Collapse -->
      <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
        <ul class="nav navbar-toolbar">
          <li id="toggleMenubar" class="hidden-float">
            <a role="button" href="#" data-toggle="menubar">
              <i class="icon hamburger hamburger-arrow-left hided unfolded">
                  <span class="sr-only">Toggle menubar</span>
                  <span class="hamburger-bar"></span>
                </i>
            </a>
          </li>
        </ul>
        <!-- Navbar Toolbar -->
        <div class="nav-breadcrumb"><span></span></div>
        <!-- End Navbar Toolbar -->
        <!-- Navbar Toolbar Right -->
        <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
		  <li class="dropdown">
			<a class="navbar-avatar dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"
			data-animation="scale-up" role="button">
			  <span> Welcome Back {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}} </span>
			</a>
			<ul class="dropdown-menu" role="menu">
			  <li role="presentation">
				<a href="/users/update/{{{ Auth::user()->id }}}" role="menuitem"><i class="icon wb-user" aria-hidden="true"></i> Profile</a>
			  </li>
			  <li class="divider" role="presentation"></li>
			  <li role="presentation">
        <a href="{{ url('/logout') }}"
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();" role="menuitem">
            <i class="icon wb-power" aria-hidden="true"></i>
          Logout
      </a>
      <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>
			  </li>
			</ul>
		  </li>
        </ul>
        <!-- End Navbar Toolbar Right -->
      </div>
      <!-- End Navbar Collapse -->
      <!-- Site Navbar Seach -->
      <div class="collapse navbar-search-overlap" id="site-navbar-search">
        <form role="search">
          <div class="form-group">
            <div class="input-search">
              <i class="input-search-icon wb-search" aria-hidden="true"></i>
              <input type="text" class="form-control" name="site-search" placeholder="Search...">
              <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
              data-toggle="collapse" aria-label="Close"></button>
            </div>
          </div>
        </form>
      </div>
      <!-- End Site Navbar Seach -->
    </div>
  </nav>