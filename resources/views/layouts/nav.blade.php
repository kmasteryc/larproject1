<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{!! url('/') !!}">
                <span class="menu-icon fa fa-home"></span>
                LARMP3
            </a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                @include('layouts.partials.li_search')
                @include('layouts.partials.li_chart')
                @include('layouts.partials.li_cate')
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @include('layouts.partials.li_auth')
            </ul>
        </div>
    </div>
</nav>