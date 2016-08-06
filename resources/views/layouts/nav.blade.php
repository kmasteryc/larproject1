@inject('menu','Tools\Menu')
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                LARMP3
            </a>

        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">

                <form class="navbar-form navbar-left" role="search" onsubmit="return false;">
                    <div class="form-group">
                        <input type="text" class="form-control" id="autocomplete" placeholder="Tìm kiếm....">
                    </div>
                </form>

                {!!$menu->make($cates,'nav2')!!}

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" role="button"><i class="fa fa-line-chart"></i> BXH</a>
                    <ul class="dropdown-menu">
                        @foreach($cates as $cate)
                            @if($cate->cate_chart==1)
                                <li>
                                    <a href="{!! url("bang-xep-hang/$cate->cate_title_slug.html") !!}">{!! $cate->cate_title !!}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        Playlist của bạn <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        @foreach ($menu_playlists as $menu_playlist)
                            <li>
                                <a href="{!! url("playlist/$menu_playlist[playlist_title_slug].html") !!}">{!! $menu_playlist['playlist_title'] !!}</a>
                            </li>
                        @endforeach
                        @if (!auth()->guest())
                            <li class="divider"></li>
                            <li><a href="{!! url('/playlist') !!}"><i class="fa fa-gear"></i> Quản lý danh sách nhạc</a>
                            </li>
                        @endif
                    </ul>
                </li>
                @if (auth()->guest())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                             <i class="fa fa-user"></i> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/login') }}">Đăng nhập</a></li>
                            <li><a href="{{ url('/register') }}">Đăng kí</a></li>
                        </ul>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            {{ auth()->user()->name }}
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>