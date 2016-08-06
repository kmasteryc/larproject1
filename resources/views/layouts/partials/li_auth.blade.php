<li class="dropdown {!! $display or "" !!}">
    @if (auth()->guest())
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
            <i class="fa fa-user"></i> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('/login') }}">Đăng nhập</a></li>
            <li><a href="{{ url('/register') }}">Đăng kí</a></li>
        </ul>
    @else
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
            {{ auth()->user()->name }}
        </a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
        </ul>
    @endif
</li>
