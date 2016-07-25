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
                {!!$menu->make($cates,'nav2')!!}
            </ul>
            <form class="navbar-form navbar-left" id="top-search-form" role="search" onsubmit="return false;">
                <div class="form-group">
                    <input type="text" class="form-control" id="top-search-text" placeholder="Tìm kiếm....">
                </div>
                {{--<button class="btn btn-default" id="top-search-btn"><i class="fa fa-search"></i></button>--}}
                <p id="top-search-result"></p>
            </form>
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                        Danh sách nhạc của bạn <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        @foreach ($menu_playlists as $menu_playlist)
                            <li>
                                <a href="{!! url('playlist/'.$menu_playlist['id']) !!}">{!! $menu_playlist['playlist_title'] !!}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @if (auth()->guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            {{ auth()->user()->name }} <span class="caret"></span>
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