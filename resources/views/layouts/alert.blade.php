@if (count($errors)>0)

    <div class="modal fade" id="alert-modal" data-show="true">
    	<div class="modal-dialog">
    		<div class="modal-content">
    			<div class="modal-header">
    				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    				<h4 class="modal-title text-danger">Lỗi</h4>
    			</div>
    			<div class="modal-body">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li class="text-danger">{{$error}}</li>
                        @endforeach
                    </ul>
    			</div>
    		</div><!-- /.modal-content -->
    	</div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    {{--<div class="alert alert-danger">--}}
        {{--<ul>--}}
            {{--@foreach($errors->all() as $error)--}}
                {{--<li>{{$error}}</li>--}}
            {{--@endforeach--}}
        {{--</ul>--}}
    {{--</div>--}}
@endif
@if (session()->get('my_errors')!='')
    <div class="alert alert-danger">
        <ul>
            <li>{{session()->get('my_errors')}}</li>
        </ul>
    </div>
@endif
@if (isset($succeeds))

    <div class="modal fade" id="alert-modal" data-show="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-success">OK</h4>
                </div>
                <div class="modal-body">
                    <ul>
                            <li class="text-success">{{$succeeds}}</li>
                    </ul>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endif