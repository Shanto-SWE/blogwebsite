@extends('layouts.admin')

@section('content')

<div class="content-header">

      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Post Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Post Page</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

<div class="content">
<div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Tags List</h3>
                            <a href="{{ route('post.create') }}" class="btn btn-primary">Create Post</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th style="width: 10px">#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>tages</th>
                                    <th>Author</th>
                                    <th style="width: 130px">Created Date</th>
                                    <th style="width: 40px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($posts->count()>0)
                                @foreach ($posts as $post)
                                    <tr>
                                    <td>{{ $post->id }}</td>
                                        <td>
                                            <div style="max-width: 70px; max-height:70px;overflow:hidden">
                                                <img src="{{ asset($post->image) }}" class="img-fluid img-rounded" alt="">
                                            </div>
                                        </td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->category->name}}</td>
                                        <td>
                                            @foreach($post->tags as $tag) 
                                                <span class="badge badge-primary">{{ $tag->name }} </span>
                                            @endforeach
                                        </td>
                                      
                                        <td>{{ $post->user->name }}</td>
                                        <td style="width: 130px">{{ $post->created_at->format('d M, Y') }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('post.edit', [$post->id]) }}" class="btn btn-sm btn-primary mr-1"> <i class="fas fa-edit"></i> </a>
                                            <form action="{{ route('post.delete', [$post->id]) }}" class="mr-1" method="POST">
                                         
                                                @csrf 
                                                <button type="submit" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i> </button>
                                            </form>
                                           <a href="{{ route('post.show', [$post->id]) }}" class="btn btn-sm btn-success mr-1"> <i class="fas fa-eye"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @else   
                                    <tr>
                                        <td colspan="12">
                                            <h5 class="text-center">No post found.</h5>
                                        </td>
                                    </tr>

                                @endif
                            </tbody>
                        </table>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection