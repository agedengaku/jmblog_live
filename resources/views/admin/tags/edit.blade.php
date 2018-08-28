@extends('layouts.admin')
@section('content')

<h1>Tags</h1>

<div class="col-sm-6">
	
{!! Form::model($tag, ['method'=>'PATCH', 'action'=>['AdminTagsController@update', $tag->id]]) !!}

	<div class="form-group">
		{!! Form::label('name', 'Name:') !!}
		{!! Form::text('name', null, ['class'=>'form-control']) !!}
	</div>

	<div class="form-group">
		{!! Form::submit('Update Category', ['class'=>'btn btn-primary col-sm-6']) !!}
	</div>

{!! Form::close() !!}

{!! Form::open(['method'=>'DELETE', 'action'=>['AdminTagsController@destroy'], 'class'=>'delete_form']) !!}

	<input type="hidden" name="id" value="{{$tag->id}}">
	<div class="form-group">
		{!! Form::submit('Delete', ['class'=>'btn btn-danger col-sm-6 undisable', 'disabled'=>'disabled']) !!}
	</div>
	
{!! Form::close() !!}

</div>

<div class="col-sm-6">

</div>

@stop

@section('scripts')

<script src="{{asset('js/sweetalert.min.js')}}"></script>
@include('includes.delete-swal')
<script>
	$(".undisable").prop("disabled", false);
</script>

@endsection