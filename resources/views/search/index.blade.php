@extends('layouts.master')
@section('content')
    <!-- Page Header -->
    <header class="masthead" style="background-image: url('/img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Search: {{ $s }}</h1>
              {{-- <span class="subheading">A Blog Theme by Start Bootstrap</span> --}}
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            
        @if($posts)
          @foreach($posts as $post)
          <div class="post-preview">
            <a href="{{url('/')}}/post/{{ $post->id }}">
              <h2 class="post-title">
                {{ $post->title }}
              </h2>
              @php
                $body = $post->body;
                $stripped = strip_tags($body);
              @endphp
              <h3 class="post-subtitle">
                {!!str_limit($stripped, 100)!!}
                {{-- {{ $post->body }} --}}
              </h3>
            </a>
            <p class="post-meta">Posted by
              <a href="#">{{ $post->user->name }}</a>
              on {{ $post->created_at->toFormattedDateString() }}</p>
          </div>
          
          <hr>
          @endforeach

          <!-- Pager -->
          <div class="clearfix">
            {{-- {{ $posts->links() }} --}}
            @if($posts->previousPageUrl())
            <a class="btn btn-secondary float-left" href="{{ $posts->previousPageUrl() }}">&larr; Newer Posts</a>
            @endif
            @if($posts->nextPageUrl())
            <a class="btn btn-secondary float-right" href="{{ $posts->nextPageUrl() }}">Older Posts &rarr;</a>
            @endif
          </div>
         @else
         <h2>Sorry, I couldn't find anything! :(</h2> 
         @endif
        </div>
      </div>
    </div>

    <hr>

    @endsection