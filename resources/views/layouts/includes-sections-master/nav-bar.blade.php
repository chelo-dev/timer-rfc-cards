<div class="navbar-custom topnav-navbar">
    <div class="container-fluid">

        <!-- LOGO -->
        <a href="{{ route('dashboard') }}" class="topnav-logo">
            <span class="topnav-logo-lg">
                <img src="{{ asset('logo-general.svg') }}" alt="" height="36">
            </span>
            <span class="topnav-logo-sm">
                <img src="{{ asset('logo-general.svg') }}" alt="" height="36">
            </span>
        </a>

        <ul class="list-unstyled topbar-right-menu float-right mb-0">

            <li class="dropdown notification-list topbar-dropdown d-none d-lg-block">
                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown"
                    id="topbar-languagedrop" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <img src="{{ asset('assets/images/flags/us.jpg') }}" alt="user-image" class="mr-1" height="12">
                    <span class="align-middle">English</span> <i class="mdi mdi-chevron-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu"
                    aria-labelledby="topbar-languagedrop">

                    <!-- item-->
                    <a href="{{ route('changeLang', ['locale' => 'en']) }}" class="dropdown-item notify-item">
                        <img src="{{ asset('assets/images/flags/us.jpg') }}" alt="user-image" class="mr-1" height="12">
                        <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('changeLang', ['locale' => 'es']) }}" class="dropdown-item notify-item">
                        <img src="{{ asset('assets/images/flags/spain.jpg') }}" alt="user-image" class="mr-1" height="12">
                        <span class="align-middle">Spanish</span>
                    </a>

                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#"
                    id="topbar-notifydrop" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="dripicons-bell noti-icon"></i>
                    <span class="noti-icon-badge"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg"
                    aria-labelledby="topbar-notifydrop">

                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                            <span class="float-right">
                                <a href="javascript: void(0);" class="text-dark">
                                    <small>Clear All</small>
                                </a>
                            </span>Notification
                        </h5>
                    </div>

                    <div class="slimscroll" style="max-height: 230px;">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary">
                                <i class="mdi mdi-comment-account-outline"></i>
                            </div>
                            <p class="notify-details">Caleb Flakelar commented on Admin
                                <small class="text-muted">1 min ago</small>
                            </p>
                        </a>
                    </div>

                    <!-- All-->
                    <a href="javascript:void(0);"
                        class="dropdown-item text-center text-primary notify-item notify-all">
                        View All
                    </a>

                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown"
                    id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                    aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="user-image" class="rounded-circle">
                    </span>
                    <span>
                        <span class="account-user-name">{{ Auth::user()->name }}</span>
                        <span class="account-position">{{ Auth::user()->roles[0]->name }}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown"
                    aria-labelledby="topbar-userdrop">
                    <!-- item-->
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{ route('getAccount', Auth::user()->uuid) }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle mr-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-edit mr-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="{{ route('logout') }}" class="dropdown-item notify-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout mr-1"></i><span> Logout </span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </li>

        </ul>
        <a class="navbar-toggle" data-toggle="collapse" data-target="#topnav-menu-content">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a>
        <div class="app-search">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="mdi mdi-magnify"></span>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>