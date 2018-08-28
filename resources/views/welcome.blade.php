@extends('layouts.master')
@section('content')
    <!-- Page Header -->
    @include('includes.message-modal')
    @if(session()->has('error'))
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
          $(document).ready(function(){
            $('#myModal').modal('show'); 
          });
        </script>
    @endif
    <header class="masthead" style="background-image:url('{{url('/')}}/img/home-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="site-heading">
              <h1>Sushi Dev</h1>
              <span class="subheading">A Web Developer in Japan</span>
            </div> {{-- .site-heading --}}
          </div> {{-- .col-lg-8.col-md-10.mx-auto --}}
        </div> {{-- .row --}}
      </div> {{-- .container --}}
    </header>
    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          @if($posts)
            @foreach($posts as $post)
            <div class="post-preview">
              <a href="post/{{ $post->id }}">
                <h2 class="post-title">{{ $post->title}}</h2>
                @php
                    $body = $post->body;
                    $stripped = strip_tags($body);
                @endphp
                <h3 class="post-subtitle"><p>{{ str_limit($stripped, 100) }}</p></h3>
              </a>
              <p class="post-meta">Posted by <a href="#">{{ $post->user->name }}</a> on {{ $post->created_at->toFormattedDateString() }}</p>
              @if($post->tags->isNotEmpty())
                  @foreach($post->tags as $tag)
                      <span class="label label-default tag-link">
                          <a href="{{ url('/') }}/tag/{{ $tag->id }}">{{$tag->name}}</a>
                      </span>
                  @endforeach
              @endif
            </div> 
            <hr>
            @endforeach
            <!-- Pager -->
            <div id="pager-id" class="clearfix">
              @if($posts->previousPageUrl())
              <a class="pager btn btn-secondary float-left" href="{{ $posts->previousPageUrl() }}">&larr; Newer Posts</a>
              @endif
              @if($posts->nextPageUrl())
              <a class="pager btn btn-secondary float-right" href="{{ $posts->nextPageUrl() }}">Older Posts &rarr;</a>
              @endif
            </div> {{-- .clearfix --}}
          @endif
        </div> {{-- .col-lg-8.col-md-10.mx-auto --}}
      </div> {{-- .row --}}
    </div> {{-- .container --}}
    <hr class="before-footer">
<!--Removes hr if there is no pagination    -->
<script>
    if (document.querySelector('.pager') === null) {
        document.getElementById('pager-id').previousElementSibling.remove();
    }
</script>    
@endsection