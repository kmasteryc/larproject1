<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{!! url('/') !!}">
                <span class="menu-icon fa fa-home"></span>
                LARMP3
            </a>
        </div>

        <ul class="nav navbar-nav">
            @include('layouts.partials.li_search')
            @include('layouts.partials.li_chart')
            @include('layouts.partials.li_cate')
        </ul>

        <ul class="nav navbar-right">
            @include('layouts.partials.li_auth')
        </ul>

    </div>
</nav>