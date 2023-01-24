@extends('layouts.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">{{__('admin\dashboard.Home Page')}} </a>
                                </li>
                                <li class="breadcrumb-item"><a href="">
                                        {{__('admin\dashboard.sliders')}} </a>
                                </li>
                                <li class="breadcrumb-item active">{{__('admin\dashboard.sliders')}}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"
                                        id="basic-layout-form"> {{__('admin\dashboard.Add Sliders')}}</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('dashboard.includes.alerts.success')
                                @include('dashboard.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form"
                                              action="{{route('admin.sliders.storeImagesDB')}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-body">

                                                <h4 class="form-section"><i
                                                        class="ft-home"></i> {{__('admin\dashboard.images')}} </h4>
                                                <div class="form-group">
                                                    <div id="dpz-multiple-files" class="dropzone dropzone-area">
                                                        <div
                                                            class="dz-message">{{__('admin\dashboard.Upload Multi Image Here')}}</div>
                                                    </div>
                                                    <br><br>
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <ul class="list-unstyled list-inline">

                                                    @isset($photos)
                                                        @forelse($photos as $photo )
                                                            <li class="ml-2">
                                                                <a href="{{route('admin.sliders.deleteImage',$photo->photo)}}"
                                                                   class=""
                                                                    {{--                                                                   data-img="{{$photo->photo}}"--}}
                                                                >
                                                                    <span>&times;</span>
                                                                    {{--                                                                    <i class="ft-x-circle danger"></i>--}}

                                                                </a>
                                                                <img class="img img-thumbnail img-fluid"
                                                                     src="{{asset('assets/images/sliders/'.$photo->photo)}}" width="200" height="147">
                                                            </li>
                                                        @empty
                                                            لا يوجد صور حتي اللحظه
                                                        @endforelse
                                                    @endisset

                                                </ul>
                                            </div>


                                            {{--                                            <div class="card-body  my-gallery" itemscope="" itemtype="http://schema.org/ImageGallery"--}}
                                            {{--                                                 data-pswp-uid="1">--}}
                                            {{--                                                <div class="row">--}}
                                            {{--                                                    @isset($photos)--}}
                                            {{--                                                        @forelse($photos as $photo )--}}
                                            {{--                                                            <figure class="col-lg-3 col-md-6 col-12" itemprop="associatedMedia" itemscope=""--}}
                                            {{--                                                                    itemtype="http://schema.org/ImageObject">--}}
                                            {{--                                                                <button type="submit" class="close" data-img="{{$photo->photo}}">--}}
                                            {{--                                                                    <span>&times;</span>--}}
                                            {{--                                                                </button>--}}
                                            {{--                                                                <i class="ft-x danger"></i>--}}
                                            {{--                                                                <a href="{{$photo -> photo}}" itemprop="contentUrl"--}}
                                            {{--                                                                   data-size="480x360">--}}
                                            {{--                                                                    <img class="img-thumbnail img-fluid"--}}
                                            {{--                                                                         src="{{$photo -> photo}}"--}}
                                            {{--                                                                         itemprop="thumbnail" alt="Image description">--}}
                                            {{--                                                                </a>--}}
                                            {{--                                                            </figure>--}}
                                            {{--                                                        @empty--}}
                                            {{--                                                            لا يوجد صور حتي اللحظه--}}
                                            {{--                                                        @endforelse--}}
                                            {{--                                                    @endisset--}}
                                            {{--                                                </div>--}}

                                            {{--                                            </div>--}}


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> {{__('admin/dashboard.back')}}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{__('admin/dashboard.Add')}}
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@stop

@section('style')
    <style>
        .close {
            position: absolute;
            z-index: 1;
        }

        img {
            position: relative;
        }
        .dz-message{
            top:30% !important;
        }

    </style>
@stop

@section('script')

    <script>

        var uploadedDocumentMap = {}
        Dropzone.options.dpzMultipleFiles = {
            paramName: "dzfile", // The name that will be used to transfer the file
            //autoProcessQueue: false,
            maxFilesize: 5, // MB
            clickable: true,
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            dictFallbackMessage: " المتصفح الخاص بكم لا يدعم خاصيه تعدد الصوره والسحب والافلات ",
            dictInvalidFileType: "لايمكنك رفع هذا النوع من الملفات ",
            dictCancelUpload: "الغاء الرفع ",
            dictCancelUploadConfirmation: " هل انت متاكد من الغاء رفع الملفات ؟ ",
            dictRemoveFile: "{{__('admin\dashboard.Delete')}}",
            dictMaxFilesExceeded: "لايمكنك رفع عدد اكثر من هضا ",
            headers: {
                'X-CSRF-TOKEN':
                    "{{ csrf_token() }}"
            }

            ,
            url: "{{ route('admin.sliders.storeImages') }}", // Set the url
            success:
                function (file, response) {
                    $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
                    uploadedDocumentMap[file.name] = response.name
                }
            ,
            removedfile: function (file) {
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
            }
            ,
            // previewsContainer: "#dpz-btn-select-files", // Define the container to display the previews
            init: function () {

                @if(isset($event) && $event->document)
                var files =
                    {!! json_encode($event->document) !!}
                    for(
                var i
            in
                files
            )
                {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }


    </script>
    {{--    <script>--}}
    {{--        $(".close").click(function(){--}}
    {{--            // e.preventDefault();--}}
    {{--            let img = $(this).data('img');--}}
    {{--            img = img.split("/").slice(-1)[0];--}}
    {{--            var url = '{{ route("admin.sliders.deleteImage", ":img") }}';--}}
    {{--            url = url.replace(':img', img);--}}
    {{--            $.ajaxSetup({--}}
    {{--                headers: {--}}
    {{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
    {{--                }--}}
    {{--            });--}}
    {{--            $.ajax(--}}
    {{--                {--}}
    {{--                    url: url,--}}
    {{--                    type: 'post', // replaced from put--}}
    {{--                    dataType: "JSON",--}}
    {{--                    success: function (response)--}}
    {{--                    {--}}
    {{--                        // location.reload(true);--}}

    {{--                    },--}}
    {{--                    error: function(xhr) {--}}
    {{--                        console.log(xhr.responseText); // this line will save you tons of hours while debugging--}}
    {{--                        // do something here because of error--}}
    {{--                    }--}}
    {{--                });--}}
    {{--        });--}}
    {{--    </script>--}}
@stop
