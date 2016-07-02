@if (count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session()->get('my_errors')!='')
    <div class="alert alert-danger">
        <ul>
            <li>{{session()->get('my_errors')}}</li>
        </ul>
    </div>
@endif
@if (isset($succeeds))
    <div class="alert alert-success">
        <ul>
            <li>{{$succeeds}}</li>
        </ul>
    </div>
@endif