<li class="dropdown {!! $display or "" !!}">
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