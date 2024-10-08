<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>

    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle mr-1">

                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{url('/')}}">Admin</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{url('/')}}">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="active"><a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fas fa-fire"></i><span>General
                        Dashboard</span></a>
            </li>
            <li class="menu-header">Starter</li>
            <li class="active"><a class="nav-link" href="{{ route('admin.user.index') }}"><i
                        class="far fa-square"></i> <span>Users</span></a></li>
            <li class="active"><a class="nav-link" href="{{ route('admin.slider.index') }}"><i
                        class="far fa-square"></i> <span>Slider</span></a></li>
            <li class="active"><a class="nav-link" href="{{ route('admin.why-choose-us.index') }}"><i
                        class="far fa-square"></i> <span>Why Choose Us</span></a></li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i>
                    <span>Manage Restaurant</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('admin.category.index') }}">Product Categories</a></li>
                    <li><a class="nav-link" href="{{ route('admin.product.index') }}">Products</a></li>
                </ul>
            </li>
            <li class="active"><a class="nav-link" href="{{ route('admin.setting.index') }}"><i
                        class="far fa-square"></i> <span>Setting</span></a></li>
        </ul>
    </aside>
</div>
