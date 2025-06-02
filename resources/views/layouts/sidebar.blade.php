<nav class="admin-sidebar" id="adminSidebar">
    <!-- <div class="sidebar-toggle-container d-lg-none">
        <button id="sidebarToggler" class="sidebar-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div> -->

    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-store text-cake"></i>
            <h5 class="brand-text">Crunchy Sweets</h5>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.orders') }}" class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
        </a>

        <div class="sidebar-heading">Products</div>

        <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>Categories</span>
        </a>

        <a href="{{ route('items.index') }}" class="sidebar-link {{ request()->routeIs('items.*') ? 'active' : '' }}">
            <i class="fas fa-cookie-bite"></i>
            <span>Items</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="user-profile">
            <!-- <div class="avatar">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e90ff&color=fff" alt="{{ Auth::user()->name }}"
            class="user-avatar">
            </div> -->
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">{{ Auth::user()->role }}</div>
            </div>
        </div>
    </div>
</nav>
