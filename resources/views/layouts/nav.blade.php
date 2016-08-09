<nav class="navbar navbar-inverse navbar-static">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{!! url('/') !!}">LIFE'S SOUND</a>
    </div>


    <div class="collapse navbar-collapse js-navbar-collapse">
        <ul class="nav navbar-nav">

            @include('layouts.partials.li_cate')

            @include('layouts.partials.li_chart')
            
            @include('layouts.partials.li_search')
        </ul>
        <ul class="nav navbar-nav navbar-right">
            @include('layouts.partials.li_userplaylist')

            @include('layouts.partials.li_auth')
        </ul>

    </div><!-- /.nav-collapse -->
</nav>
