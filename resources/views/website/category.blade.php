
@extends('layouts.layout')

@section('content')
@if($postcount>0)
<div class="site-wrap">




<div class="py-5 bg-light">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <span>Category</span>
        <h3>{{ $category->name }}</h3>
            @if($category->description)
              <p>{!! $category->description !!}</p>
            @endif
      </div>
    </div>
  </div>
</div>

<div class="site-section bg-white">
  <div class="container">
    <div class="row">
    @foreach($posts as $post)
      <div class="col-lg-4 mb-4">
        <div class="entry2">
          <a href="{{ route('website.post', ['slug' => $post->slug]) }}"><img src="{{asset($post->image)}}" alt="Image" class="img-fluid rounded"></a>
          <div class="excerpt">
          <span class="post-category text-white bg-secondary mb-3">{{ $post->category->name}}</span>

          <h2><a href="single.html">{{ $post->category->title}}</a></h2>
          <div class="post-meta align-items-center text-left clearfix">
            <figure class="author-figure mb-0 mr-3 float-left"><img src="{{asset($post->user->image)}}" alt="Image" class="img-fluid"></figure>
            <span class="d-inline-block mt-1">By <a href="#">{{ $post->user->name }}</a></span>
            <span>&nbsp;-&nbsp; {{ $post->created_at->format('M d, Y') }}</span>
          </div>
          
            <p>{!! Str::limit($post->description, 100) !!}</p>
            <p><a href="#">Read More</a></p>
          </div>
        </div>
      </div>
   
@endforeach
  

     
      </div>
    </div>
    <div class="row text-center pt-5 border-top">
    {{ $posts->links() }}
      <!-- <div class="col-md-12">
        <div class="custom-pagination">
          <span>1</span>
          <a href="#">2</a>
          <a href="#">3</a>
          <a href="#">4</a>
          <span>...</span>
          <a href="#">15</a>
        </div>
      </div> -->
  </div>
</div>
</div>

</div>
@else
<h2 class="text-center p-5">Opps...No post found</h2>

@endif
@endsection