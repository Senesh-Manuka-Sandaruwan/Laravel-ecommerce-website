<header class="admin-header">
    <div class="header-start">
    <button id="sidebarToggleBtn" class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- <div class="header-search">
        <form action="#" method="GET">
            <div class="search-input-group">
                <input type="text" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div> -->

        <div class="header-user ms-auto"></div>
            <button class="user-dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e90ff&color=fff" alt="{{ Auth::user()->name }}"
                    class="user-avatar">
                <span class="user-name d-none d-md-inline">{{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down ms-1"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              

                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>