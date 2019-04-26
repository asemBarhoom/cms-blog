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
                            <div class="card-text"> {!! str_limit(strip_tags($post->body) , 300) ." . . . "  !!}  </div>
                            @if(\Illuminate\Support\Str::length($post->body)>300)
                                <a href="#" class="btn btn-primary">Read More &rarr;</a>
                            @endif

                           <div class="container">
                               <hr>
                               <div class="row">
                                   <div class="col">
                                       <form action="{{route('comment.store')}}" method="POST">
                                           @csrf
                                           <div class="form-group">
                                               <label for="comment">Comment:</label>
                                               <textarea class="form-control" rows="2" id="comment" placeholder="type any comment" name="body"></textarea>
                                               <input type="hidden" name="post_id" value="{{$post->id}}">
                                           </div>
                                           <button type="submit" class="btn btn-danger float-right">Submit</button>
                                       </form>
                                   </div>
                               </div>
                               <hr>


                              @if(count($post->comments)>0)
                                   <div class="row">
                                      @foreach($post->comments->where('parent_id','==',null) as $comment)
                                                 <div class="col-2">
                                                     <div class="alert " style="background-image: url('https://www.atlassian.com/dam/jcr:13a574c1-390b-4bfb-956b-6b6d114bf98c/max-rehkopf.png'); background-position: center; background-size: cover; background-repeat: no-repeat, repeat;"></div>
                                                 </div>
                                                 <div class="col-10">
                                                     <div class="alert alert-light">
                                                           <span class="bodyOfComment"> {{$comment->body}}</span>
                                                            @if($comment->user_id==Auth::id() or $post->user_id == Auth::id())
                                                             {{--START UPDATE COMMENT SECTIOIN--}}
                                                             <form id="{{$comment->id}}" class="row" action="{{ route('comment.update', $comment->id) }}" method="post" style="display: none">
                                                                 @csrf
                                                                 @method('put')

                                                                   <div class="col-10">

                                                                           <textarea class="form-control " rows="1" name="body">{{$comment->body}}</textarea>


                                                                   </div>
                                                                   <div class="col-2 p-0">
                                                                       <button type="submit" class="btn btn-danger btn-sm mt-10">Update</button>
                                                                   </div>




                                                             </form>
                                                             {{--END UPDATE COMMENT SECTIOIN--}}

                                                                {{--START COMMENT ACTIONS DROPDOWN [EDIT,DELETE]--}}
                                                             <div  class="dropdown float-right bodyOfComment">
                                                                 <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                     <i class="fas fa-ellipsis-v"></i>
                                                                 </a>
                                                                 <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                                     <button class="dropdown-item" id="edit" data-content="{{$comment->id}}">Edit</button>
                                                                     <form action="{{ route('comment.destroy', $comment->id) }}" method="post">
                                                                         @csrf
                                                                         @method('delete')


                                                                         <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this post?") }}') ? this.parentElement.submit() : ''">
                                                                             {{ __('Delete') }}
                                                                         </button>
                                                                     </form>

                                                                 </div>
                                                             </div>
                                                                {{--END COMMENT ACTIONS DROPDOWN [EDIT,DELETE]--}}
                                                            @endif

                                                         {{--START REPLY SECTION--}}
                                                         <a class="btn btn-primary btn-sm float-right" data-toggle="collapse" href="#_{{$comment->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                             Reply
                                                         </a>

                                                         <div class="row">
                                                             <div class="col-2"></div>
                                                             <div class="col">
                                                                <div class="collapse" id="_{{$comment->id}}">
                                                                    <hr>
                                                                     <form action="{{route('comment.store')}}" method="POST">
                                                                         @csrf
                                                                         <div class="form-group">
                                                                             <textarea class="form-control" rows="2" id="comment" placeholder="type any reply" name="body"></textarea>
                                                                             <input type="hidden" name="post_id" value="{{$post->id}}">
                                                                             <input type="hidden" name="parent_id" value="{{$comment->id}}">
                                                                         </div>
                                                                         <button type="submit" class="btn btn-danger btn-sm float-right">Reply</button>
                                                                     </form>

                                                                 </div>
                                                             </div>
                                                         </div>
                                                         {{--END REPLY SECTION--}}
                                                     </div>
                                                 </div>
                                      @endforeach
                                   </div>
                              @endif
                           </div>
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

    @push('comments_script')
        <script>
            $(document).on('click','#edit',function ()
            {
                $(".bodyOfComment").hide();
                $("#"+$(this).attr('data-content')).show();
            });
        </script>
    @endpush
@endsection