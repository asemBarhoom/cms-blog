@extends('layouts.app', ['title' => __('Post Management')])

@section('content')
    @include('posts.partials.header', ['title' => __('Edit Post')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Post Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('post.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('post.update' , $post->id)  }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Post information') }}</h6>
                            <div class="row">
                                <div class="col-9">
                                    <div class="pl-lg-4">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="input-name">{{ __('Title') }}</label>
                                            <input type="text" name="title" id="input-name" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('title') }}" value="{{ $post->title }}" required autofocus>

                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="form-group{{ $errors->has('body') ? ' has-danger' : '' }}">
                                            <label class="form-control-label" for="summernote">{{ __('Body') }}</label>
                                            <textarea name="body" id="summernote" class="form-control form-control-alternative{{ $errors->has('body') ? ' is-invalid' : '' }}" >{!! $post->body !!}</textarea>
                                            @if ($errors->has('body'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('body') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-3">
                                    <div class="pl-lg-4">
                                        <br>
                                        {{--START CHOICE POST IMAGE DIV--}}
                                        <div class="selectedImg col-12 p-1">
                                            <img class="checked" height="130px" width="130px" src="{{ asset('storage/'.$post->pic->path) }}" alt="">
                                            <input type="hidden" name="pic_id" value="{{$post->pic->id}}">
                                        </div>
                                        <br>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Choose Post Image
                                        </button>

                                        <BR>
                                        <hr class="my-3">
                                        <lable foe="customCheck">Categories</lable>
                                        <hr class="my-3">

                                        @foreach($categories as $category)

                                            <div class="custom-control custom-checkbox mb-3">
                                                <input class="custom-control-input" id="{{$category->id}}" value="{{$category->id}}" type="checkbox" name="categories[]" {{$post->categories}}  {{(empty($post->categories()->where(['category_id'=>$category->id])->first()))?'':'checked'}}>
                                                <label class="custom-control-label" for="{{$category->id}}">{{$category->name}}</label>
                                            </div>
                                        @endforeach




                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{--START MODAL--}}



    <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Post photo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" >
                        <div class="row">
                            <div class="dropzoneDiv col-4">

                            </div>

                            @foreach($pics as $pic)
                                <div class="col-4">
                                    <div class="form-check ">
                                        <label class="form-check-label " for="{{$pic->id}}">
                                            <input type="radio"  class="form-check-input " style="display: none;" id="{{$pic->id}}" name="pic_id" value="{{$pic->id}}" >
                                            <img height="130px" width="130px" src="{{asset('storage/'.$pic->path)}}" alt="">
                                        </label>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        {{--END CHOICE POST IMAGE DIV--}}
        {{--END MODAL--}}
        @include('layouts.footers.auth')
    </div>

    <form method="POST" style="height: 130px; width: 130px;    display: none;" action="{{route('pic.store')}}" class="dropzone"  id="postImage" enctype="multipart/form-data">
        @csrf
        <div class="dz-message" data-dz-message><span>أسحب / أضغظ لرفع صورة جديدة </span></div>
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>

    @push('dropzone')
        <script>
            Dropzone.options.postImage =
                {
                    success:function (response) {
                        var res= jQuery.parseJSON( response['xhr']['responseText'] );

                        $('.modal-body .row').append('  <div class="col-4">  <div class="form-check "> <label class="form-check-label '+res.id+' " for="'+res.id+'"> <input type="radio"  class="form-check-input checked " style="display: none;" id="'+res.id+'" name="pic_id" value="'+res.id+'" > <img height="130px" width="130px" src="/storage/'+res.path+'" alt=""></label></div></div>' );


                    }

                }
        </script>
    @endpush




@endsection