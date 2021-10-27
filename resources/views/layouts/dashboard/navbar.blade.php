
<nav class="navbar navbar-expand-lg main-navbar">
  <a href="{{route('dashboard')}}" class="navbar-brand sidebar-gone-hide">GANTARI</a>
  {{-- <div class="navbar-nav">
    <a href="{{route('dashboard')}}" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
  </div> --}}
  <form class="form-inline ml-auto">
  </form>
  
  <ul class="navbar-nav navbar-right">
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
      <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="mr-1 rounded-circle">
      <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name ?? 'Guest' }}</div></a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title">Logged in 5 min ago</div>
        <a href="features-profile.html" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Profile
        </a>
        <a href="features-settings.html" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> Settings
        </a>
        <div class="dropdown-divider"></div>
        @auth('web')
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();this.closest('form').submit();">
            <i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}
          </a>
        </form>
        @endauth
        @auth('admin')
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <a href="{{ route('admin.logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();this.closest('form').submit();">
            <i class="fas fa-sign-out-alt"></i> {{ __('Log Out') }}
          </a>
        </form>
        @endauth
      </div>
    </li>
  </ul>
</nav>