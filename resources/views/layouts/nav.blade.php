<div class="navbar-more-overlay"></div>
<nav class="navbar navbar-inverse navbar-fixed-top animate">
    <div class="container navbar-more visible-xs">
        <form class="navbar-form navbar-left" role="search" onsubmit="return false;">
            <div class="form-group">
                <input type="text" class="form-control" id="autocomplete" placeholder="Tìm kiếm....">
            </div>
        </form>
        <ul class="nav navbar-nav">

            @include('layouts.partials.li_chart')

            @include('layouts.partials.li_cate')

            @include('layouts.partials.li_userplaylist')

        </ul>
    </div>
    <div class="container">
        <div class="navbar-header hidden-xs">
            <a class="navbar-brand" href="{!! url('/') !!}">
                <span class="menu-icon fa fa-home"></span>
                LARMP3
            </a>
        </div>

        <ul class="nav navbar-nav mobile-bar">
            @include('layouts.partials.li_chart', ['display'=>'hidden-xs'])
            @include('layouts.partials.li_cate', ['nav_type' => 'nav3'])
            @include('layouts.partials.li_userplaylist', ['display'=>'hidden-xs'])
        </ul>
        <ul class="nav navbar-nav navbar-right mobile-bar">
            <li class="visible-xs">
                <a href="{!! url('/') !!}">
                    <span class="menu-icon fa fa-home"></span>
                    LARMP3
                </a>
            </li>

            @include('layouts.partials.li_auth', ['display'=>'hidden-xs'])

            <li class="visible-xs">
                <a href="#navbar-more-show">
                    <span class="menu-icon fa fa-bars"></span>
                    Menu
                </a>
            </li>
        </ul>
    </div>
</nav>