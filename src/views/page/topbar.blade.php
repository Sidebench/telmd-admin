<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top gradient-scooter">
        <ul class="navbar-nav mr-auto align-items-center">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();"><i class="icon-menu menu-icon"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav align-items-center right-nav-link">
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                    <span class="user-profile"><img src="{{ asset('adminhtml/images/placeholder.png') }}" class="img-circle" alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-item user-details">
                        <a href="javaScript:void();">
                            <div class="media">
                                <div class="avatar"><img class="align-self-start mr-3" src="{{ asset('adminhtml/images/placeholder.png') }}" alt="user avatar"></div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title">{{ Auth::guard('admin')->user()->name }}</h6>
                                    <p class="user-subtitle">{{ Auth::guard('admin')->user()->email }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    @if(Auth::guard('admin')->user()->role->isAvailable('admin.user.edit'))
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a href="{{ route('admin.user.edit', ['id' => Auth::guard('admin')->user()->id]) }}">
                            <i class="icon-settings mr-2"></i> Setting
                        </a>
                    </li>
                    @endif
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-item">
                        <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="icon-power mr-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>