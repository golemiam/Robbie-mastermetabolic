  <div class="site-menubar">
    <div class="site-menubar-body">
      <div>
        <div>
          <ul class="site-menu">
          @if(Auth::user()->role == 'trainer')
            <li class="site-menu-category">Trainer</li>
			<li class="site-menu-item">
              <a href="/users/myclients">
                <i aria-hidden="true" class="site-menu-icon wb-users"></i>
                <span class="site-menu-title">My Clients</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
			<li class="site-menu-item">
              <a href="/users/mycalendar">
                <i aria-hidden="true" class="site-menu-icon wb-calendar"></i>
                <span class="site-menu-title">My Calendar</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
			<li class="site-menu-item">
              <a href="/goaltracker">
                <i aria-hidden="true" class="site-menu-icon wb-briefcase"></i>
                <span class="site-menu-title">Goal Tracker</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
			<li class="site-menu-item">
              <a href="/settings">
                <i aria-hidden="true" class="site-menu-icon wb-settings"></i>
                <span class="site-menu-title">Settings</span>
                <span class="site-menu-arrow"></span>
              </a>
            </li>
            
       	 @endif
       	@if(isset($client->name))
			<li class="site-menu-category">Client {{{ isset($client->name) ? ' - '.$client->name : '' }}}</li>
			@if(Auth::user()->role == 'trainer')
				<li class="site-menu-item">
				  <a href="{{{ isset($client->id) ? '/user/'.$client->id.'/sessions' : '/users/myclients' }}}">
					<i aria-hidden="true" class="site-menu-icon wb-book"></i>
					<span class="site-menu-title">Sessions</span>
					<span class="site-menu-arrow"></span>
				  </a>
				</li>
			@endif
			@if($client->has_dashboard)
				<li class="site-menu-item">
				  <a href="{{{ isset($client->id) ? '/user/'.$client->id.'/dashboard' : '/users/myclients' }}}">
					<i aria-hidden="true" class="site-menu-icon wb-eye"></i>
					<span class="site-menu-title">Dashboard</span>
					<span class="site-menu-arrow"></span>
				  </a>
				</li>
			@endif
			@if($client->has_nutrition)
				<li class="site-menu-item">
				  <a href="{{{ isset($client->id) ? '/user/'.$client->id.'/nutritionprogram' : '/users/myclients' }}}">
					<i aria-hidden="true" class="site-menu-icon wb-heart"></i>
					<span class="site-menu-title">Nutrition Programs</span>
					<span class="site-menu-arrow"></span>
				  </a>
				</li>
			@endif
			@if($client->has_exercise)
				<li class="site-menu-item">
				  <a href="{{{ isset($client->id) ? '/user/'.$client->id.'/exerciseprogram' : '/users/myclients' }}}">
					<i aria-hidden="true" class="site-menu-icon wb-hammer"></i>
					<span class="site-menu-title">Exercise Programs</span>
					<span class="site-menu-arrow"></span>
				  </a>
				</li>
			@endif
			@if(Auth::user()->role == 'trainer')
				<li class="site-menu-item">
				  <a href="{{{ isset($client->id) ? '/user/'.$client->id.'/sendresults' : '/users/myclients' }}}">
					<i aria-hidden="true" class="site-menu-icon wb-envelope"></i>
					<span class="site-menu-title">Session Results</span>
					<span class="site-menu-arrow"></span>
				  </a>
				</li>
			@endif
              @if($client->has_nutrition)
                  <li class="site-menu-category">Information</li>
                  <li class="site-menu-item">
                      <a href="/user/{{$client->id}}/pages/freefoods">
                          <i aria-hidden="true" class="site-menu-icon wb-heart"></i>
                          <span class="site-menu-title">Free Foods</span>
                          <span class="site-menu-arrow"></span>
                      </a>
                  </li>
                  <li class="site-menu-item">
                      <a href="/user/{{$client->id}}/pages/restaurantfood">
                          <i aria-hidden="true" class="site-menu-icon wb-heart"></i>
                          <span class="site-menu-title">Restaurant Foods</span>
                          <span class="site-menu-arrow"></span>
                      </a>
                  </li>
              @endif
        @endif
          </ul>
        </div>
      </div>
    </div>
  </div>