@extends('layouts.admin')
@section('content')
<h2>Showing comments for post: <a href="{{url('/')}}/admin/posts/edit/{{ $post->id }}">{{ $post->title }}</a></h2>
<table class="table">
	<thead>
		<tr>
			@if(Auth::user()->role_id === 1)
			<th>User</th>
			@endif
			<th>Comment</th>
			<th>Replies</th>			
			<th>Post Link</th>
			<th>Created</th>
			<th>Updated</th>
		</tr>
	</thead>
	<tbody>
	@if($comments)
		@foreach($comments as $comment)
		<tr>
			@if(Auth::user()->role_id === 1)
			<td>{{$comment->user->name}}</td>
			@endif
			@php
                $body = $comment->body;
                $stripped = strip_tags($body);
            @endphp
			<td><a href="{{url('/')}}/admin/comments/edit/{{ $comment->id }}">{!!str_limit($stripped, 20)!!}</a></td>
			@if($comment->replies->count())
			<td><a href="{{url('/')}}/admin/comment/replies/{{ $comment->id }}">View Replies ({{$comment->replies->count()}})</a></td>
			@else
			<td>No replies</td>
			@endif			
			<td><a href="{{url('/')}}/post/{{ $comment->post->id }}">{{$comment->post->title}}</a></td>
			<td>{{$comment->created_at->diffForHumans()}}</td>
			<td>{{$comment->updated_at->diffForHumans()}}</td>
		</tr>
		@endforeach	
	@endif
	</tbody>
</table>
<div class="row">
	<div class="col-sm-6 col-sm-offset-5">
		{{$comments->render()}}
	</div>
</div>
@stop