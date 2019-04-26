@extends('layouts.front')
@section('content')
    <div class="row pageContent">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- Blog Post -->
            @if(count($posts)>0)
                @foreach($posts as $post)
                    <br>
                    <div class="card mb-4">
                        <img class="card-img-top img-fluid rounded" style="max-height: 200px;"   src="{{asset('storage/'.$post->pic->path)}}" alt="Card image cap">
                        <div class="card-body">
                            <span class="card-title text-gray"><h1>{{$post->title}} </h1>  <small CLASS="text-muted"> By {{$post->user->name}} ,     {{$post->created_at->diffForHumans()}}</small></span>
                            <div class="card-text"> {!! $post->body !!}  </div>
                            @if(\Illuminate\Support\Str::length($post->body)>100)
                                <a href="#" class="btn btn-primary">Read More &rarr;</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-dange">Sorry, No posts to display it </p>
            @endif
        <!-- Pagination -->
            {{--<ul class="pagination justify-content-center mb-4">
                <li class="page-item">
                    <a class="page-link" href="#">&larr; Older</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="#">Newer &rarr;</a>
                </li>
            </ul>--}}
        </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Categories</h5>
                <div class="card-body">
                    <div class="row">
                        @if(count($categories)>0)
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    <?php
                                    $count = count($categories);
                                    $half = $count/2;
                                    ?>
                                    @for($i=0;$i<= $half ;$i++)
                                        <li>
                                            <a href="{{route('category.show',$categories[$i]->id)}}">{{$categories[$i]->name}}</a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled mb-0">
                                    @for($i=$half+1;$i< $count ;$i++)
                                        <li>
                                            <a href="{{route('category.show',$categories[$i]->id)}}">{{$categories[$i]->name}}</a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        @else
                            <p class="text-danger">no any category</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
