<li class="dropdown {!! $display or "" !!}">
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