<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-dark navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="{{ route('dashboard') }}" id="topnav-dashboards" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="uil-dashboard mr-1"></i>Dashboard 
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps"
                            role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="uil-apps mr-1"></i>Gestion <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-apps">
                            <a href="{{ route('listUser') }}" class="dropdown-item">Usuarios</a>
                            <a href="apps-chat.html" class="dropdown-item">Roles</a>
                            <a href="apps-chat.html" class="dropdown-item">Persmisos</a>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Email <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="apps-email-inbox.html" class="dropdown-item">Inbox</a>
                                    <a href="apps-email-read.html" class="dropdown-item">Read Email</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>