@if (count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
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