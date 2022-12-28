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

                                <li class="breadcrumb-item active">وسائل التوصيل
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
                                    <h4 class="card-title" id="basic-layout-form">{{__('admin\dashboard.edit shipping method')}}</h4>
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
                                              action="{{route('update.shipping.methods',$shippingMethod->id)}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method("PUT")
                                            <input type="hidden" name="id" value="{{$shippingMethod->id}}">


                                            <div class="form-body">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin\dashboard.name')}}</label>
                                                            <input type="text"
                                                                   value="{{$shippingMethod->value}}"
                                                                   id="value"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   name="value">
                                                            @error("value")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin\dashboard.prices')}}</label>
                                                            <input type="number"
                                                                   value="{{$shippingMethod->plain_value}}"
                                                                   id="plain_value"
                                                                   min="0"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   name="plain_value">
                                                        @error("plain_value")
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                        </div>

                                                    </div>
                                                </div>

{{--                                                <div class="row">--}}
{{--                                                    <div class="col-md-6">--}}
{{--                                                        <div class="form-group mt-1">--}}
{{--                                                            <input type="checkbox" value="1"--}}
{{--                                                                   name="active"--}}
{{--                                                                   id="switcheryColor4"--}}
{{--                                                                   class="switchery" data-color="success" checked--}}
{{--                                                            />--}}
{{--                                                            <label for="switcheryColor4"--}}
{{--                                                                   class="card-title ml-1">{{__('admin\dashboard.status')}}</label>--}}

{{--                                                            @error("status")--}}
{{--                                                            <span class="text-danger"> </span>--}}
{{--                                                            @enderror--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}

                                            </div>

                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> {{__('admin\dashboard.back')}}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i>{{__('admin\dashboard.save')}}
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
