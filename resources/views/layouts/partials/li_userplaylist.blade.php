<li class="dropdown {!! $display or "" !!}">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
        <i class="fa fa-music"></i> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        @foreach ($menu_playlists as $menu_playlist)
            <li>
                <a href="{!! url("playlist/$menu_playlist[playlist_title_slug].html") !!}">{!! $menu_playlist['playlist_title'] !!}</a>
            </li>
        @endforeach
        @if (!auth()->guest())
            <li class="divider"></li>
            <li><a href="{!! url('/playlist/create') !!}"><i class="fa fa-pencil"></i> Thêm danh sách mới</a>
            <li><a href="{!! url('/playlist') !!}"><i class="fa fa-gear"></i> Quản lý danh sách nhạc</a>
            </li>
        @endif
    </ul>
</li>