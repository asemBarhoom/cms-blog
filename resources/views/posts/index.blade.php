@extends('layouts.app', ['title' => __('post Management')])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('posts') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('post.create') }}" class="btn btn-sm btn-primary">{{ __('Add post') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">{{ __('Post Image') }}</th>
                                    <th scope="col">{{ __('title') }}</th>
                                    <th scope="col">{{ __('body') }}</th>
                                    <th scope="col">{{ __('Number Of Comments') }}</th>
                                    <th scope="col">{{ __('Creation Date') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>

                                        <td><img height="130px" width="130px" class="img-fluid img-thumbnail" src="{{asset('storage/'.$post->pic->path)}}"/></td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{str_limit(strip_tags($post->body) , 30) ." . . . "}}</td>
                                        <td>{{count($post->comments)}}</td>
                                        <td>{{ $post->created_at->diffForHumans() }}</td>
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">

                                                        <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                                            @csrf
                                                             @method('delete')
                                                            
                                                            <a class="dropdown-item" href="{{ route('post.edit', $post) }}">{{ __('Edit') }}</a>
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this post?") }}') ? this.parentElement.submit() : ''">
                                                                {{ __('Delete') }}
                                                            </button>
                                                        </form>    

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $posts->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
            
        @include('layouts.footers.auth')
    </div>
@endsection