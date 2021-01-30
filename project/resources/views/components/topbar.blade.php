<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  @yield('topbar-search')

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

    @guest
      @if (Route::has('login'))
          <li class="nav-item">
              <a class="nav-link text-dark" href="{{ route('login') }}">{{ __('Logowanie') }}</a>
          </li>
      @endif
      
      @if (Route::has('register'))
          <li class="nav-item">
              <a class="nav-link text-dark" href="{{ route('register') }}">{{ __('Rejestracja') }}</a>
          </li>
      @endif
    @else

      <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle text-dark" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }}
          </a>

          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  {{ __('Wyloguj') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
          </div>
      </li>
    @endguest

  </ul>

</nav>
<!-- End of Topbar -->