@extends('layouts.app', ['title' => __('Pic Management')])

@section('content')
    @include('Pic.partials.header', ['title' => __('Add Pic')])   

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Pic Management') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('pic.index') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                            <h6 class="heading-small text-muted mb-4">{{ __('Pic information') }}</h6>
                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">

                                    <form action="{{route('pic.store')}}" method="post" class="dropzone  " id="myAwesomeDropzone" enctype="multipart/form-data">
                                        @csrf
                                        <div class="dz-message" data-dz-message><span>أسحب / أضغظ لرفع الصور / ة</span></div>

                                        <div class="fallback">
                                                <input name="file" type="file" multiple />
                                        </div>
                                    </form>
                                </div>
                               
                                 

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>

@push('dropzone')
    <script>
        var IDs = [];
        var Names = [];
        var i = 0;
        var j = 0;
        var index = 0;
        // var res;
        Dropzone.options.myAwesomeDropzone = {

            paramName: "file", // The name that will be used to transfer the file
            // maxFilesize: 2, // MB
            acceptedFiles:'image/*',
            success:function( response )
            {
                Names[j++] = response.name;
                var res= jQuery.parseJSON( response['xhr']['responseText'] );
                IDs[i++] = res.id;
                console.log(IDs);
            },
            addRemoveLinks : true,
            dictRemoveFileConfirmation:"هل أنت متأكد من حذف الصورة ؟! ",
            init: function ()
            {
                var thisIs = this;
                /*START DISPLAY IMAGES */
                jQuery.ajax({
                    url: "/getJson",
                    method: 'GET',
                    data: {
                        _token:'{!! csrf_token() !!}',
                    },
                    success: function(data){

                        $.each(data, function (index, item) {
                            //// Create the mock file:

                            var mockFile = {
                                name: item.id,
                            };
                            // Call the default addedfile event handler
                            thisIs.emit("addedfile", mockFile);
                            // And optionally show the thumbnail of the file:
                            thisIs.emit("thumbnail", mockFile, "/storage/"+item.path);
                        });


                    }
                });

                /*END DISPLAY IMAGES */

                this.on("removedfile", function ( file  ) {
                    var id , index = Names.indexOf(file.name);

                    if (index!=-1)
                    {
                        id = IDs[index];
                    }
                    else
                    {
                        id = file.name;
                    }
                //    START DELETE AJAX QUERY
                    jQuery.ajax({
                        url: "/pic/"+id ,
                        method: 'POST',
                        data: {

                            _method:'DELETE',
                            _token:'{!! csrf_token() !!}',
                        },
                        success: function(data){
                            console.log(data.success);
                            if (index!=-1)
                            {
                                IDs[index] = null;
                            }
                        }
                    });
                //    END DELETE AJAX QUERY

                });
            }
        };

    </script>
@endpush
@endsection