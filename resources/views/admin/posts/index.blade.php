@extends('layouts.admin')
@section('content')
<h1>Posts</h1>
<table class="table">
	<thead>
		<tr>
			<th>User</th>
			<th>Title</th>
			<th>Post link</th>
			<th>Comments</th>
			<th>Created</th>
			<th>Update</th>
		</tr>
	</thead>
	<tbody>
	
	@if($posts)

		@foreach($posts as $post)
	
		<tr>
			<td>{{$post->user->name}}</td>
			<td><a href="{{url('/')}}/admin/posts/edit/{{ $post->id }}">{{$post->title}}</a></td>
			<td><a href="{{url('/')}}/post/{{ $post->id }}">View Post</a></td>
			@if($post->comments->count())
			<td><a href="{{url('/')}}/admin/post/comments/{{ $post->id }}">View Comments ({{$post->comments->count()}})</a></td>
			@else
			<td>No replies</td>
			@endif
			<td>{{$post->created_at->diffForHumans()}}</td>
			<td>{{$post->updated_at->diffForHumans()}}</td>
		</tr>

		@endforeach
		
	@endif

	</tbody>
</table>
<div class="row">
	<div class="col-sm-6 col-sm-offset-5">
		{{$posts->render()}}
	</div>
</div>
@stop