    <div class="navbar-backdrop">
        <div class="navbar">
            <div class="navbar-left">
                <a class="navbar-toggle"><i class="fas fa-bars"></i></a>
                {{ env('APP_NAME', 'PrOjEcT') }}

            </div>
            @guest


            @else
            
            <div class="nav navbar-right">
                <ul>
                    <li class="dropdown dropdown-profile">
                        <a data-toggle="dropdown"><img id="avatar-image-mini" name="profile-image-mini" src="{{ env('APP_USR_IMG_LOC') }}/{{ substr(Auth::user()->profile_image,0,-4) . "-90x90" . substr(Auth::user()->profile_image,-4) }}" alt=""> <span>{{ Auth::user()->display_name }}</span></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item active"  href="/{{ Auth::user()->display_name }}"><i class="fas fa-user"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="fas fa-envelope-open"></i> <del>Inbox</del></a>
                            <a class="dropdown-item" href="#"><i class="fas fa-heart"></i> <del>Games</del></a>
                            <a href="{{ route('list_drafts') }}" class="dropdown-item"><i class="fas fa-cog"></i> Drafts</a>
                            @can('god-mode')
                                <a href="{{ route('super_admin') }}" class="dropdown-item"><i class="fas fa-cog"></i> Super Admin</a>
                            @endcan
                            <a class="dropdown-item" href="#"><i class="fas fa-cog"></i> <del>Settings</del></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                    <li class="dropdown dropdown-notification">
                        <a href="register.html" data-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-danger">2</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <h5 class="dropdown-header"><i class="fas fa-bell"></i> Notifications</h5>
                            <div class="dropdown-block">
                                <a class="dropdown-item" href="#">
                                    <span class="badge badge-info"><i class="fas fa-envelope-open"></i></span> new email
                                    <span class="date">just now</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <span class="badge badge-danger"><i class="fas fa-thumbs-up"></i></span> liked your post
                                    <span class="date">5 mins</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <span class="badge badge-primary"><i class="fas fa-user-plus"></i></span> friend request
                                    <span class="date">2 hours</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <span class="badge badge-info"><i class="fas fa-envelope"></i></span> new email
                                    <span class="date">3 days</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <span class="badge badge-info"><i class="fas fa-video-camera"></i></span> sent a video
                                    <span class="date">5 days</span>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <span class="badge badge-danger"><i class="fas fa-thumbs-up"></i></span> liked your post
                                    <span class="date">8 days</span>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li><a data-toggle="search"><i class="fas fa-search"></i></a></li>
                </ul>
            </div>
            @endguest
        </div>
    </div>
    <div class="navbar-search">
        <div class="container">
            <form method="post">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="fas fa-times close"></i>
            </form>
        </div>
    </div>