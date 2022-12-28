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
                                        {{__('admin\dashboard.Products')}} </a>
                                </li>
                                <li class="breadcrumb-item active">{{__('admin\dashboard.Add Product')}}
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
                                    <h4 class="card-title" id="basic-layout-form"> {{__('admin\dashboard.Add Product')}}
                                    </h4>
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
                                              action="{{route('admin.products.update',$product -> id)}}"
                                              method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <input name="id" value="{{$product -> id}}" type="hidden">
                                            {{--------------general-------------}}

                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i> {{__('admin/dashboard.General information')}}  </h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.product name')}}
                                                            </label>
                                                            <input type="text" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$product->name}}"
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.Link')}}
                                                            </label>
                                                            <input type="text"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$product->slug}}"
                                                                   name="slug">
                                                            @error("slug")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.description')}}
                                                            </label>
                                                            <textarea  name="description" id="description"
                                                                       class="form-control"
                                                                       placeholder="  "
                                                            >{{$product->description}}</textarea>

                                                            @error("description")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.short description')}}
                                                            </label>
                                                            <textarea  name="short_description" id="short-description"
                                                                       class="form-control"
                                                                       placeholder=""
                                                            >{{$product->short_description}}</textarea>

                                                            @error("short_description")
{{--                                                            <span class="text-danger">{{$message}}</span>--}}
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row" >
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> {{__('admin/dashboard.choose category')}}
                                                            </label>

                                                            <select name="categories[]" class="select2 form-control" multiple>
                                                                <optgroup label="{{__('admin/dashboard.choose category')}}">
                                                                    @if($categories && $categories -> count() > 0)
                                                                        @foreach($categories as $category)
                                                                            <option
                                                                                value="{{$category -> id }}"
                                                                                @foreach($selectedCategories as $selectedCategory)
                                                                                    {{$category->id == $selectedCategory ? 'selected' : ''}}
                                                                                @endforeach
                                                                            >
                                                                                {{$category->translations->where('locale',app()->getLocale())->first()->name ?? $category->translations->where('locale','en')->first()->name ?? $category->translations->where('locale','ar')->first()->name}}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('categories.0')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> {{__('admin/dashboard.choose tags')}}
                                                            </label>
                                                            <select name="tags[]" class="select2 form-control" multiple>
                                                                <optgroup label=" {{__('admin/dashboard.choose tags')}} ">
                                                                    @if($tags && $tags -> count() > 0)
                                                                        @foreach($tags as $tag)
                                                                            <option
                                                                                value="{{$tag -> id }}"
                                                                                 @foreach($selectedTags as $selectedTag)
                                                                                {{$tag->id == $selectedTag ? 'selected' : ''}}
                                                                                @endforeach
                                                                            >
                                                                                {{$tag->translations->where('locale',app()->getLocale())->first()->name ?? $tag->translations->where('locale','en')->first()->name ?? $tag->translations->where('locale','ar')->first()->name}}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('tags')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.choose brand')}}
                                                            </label>
                                                            <select name="brand_id" class="select2 form-control">
                                                                <optgroup label="{{__('admin/dashboard.choose brand')}} ">
                                                                    @if($brands && $brands -> count() > 0)
                                                                        @foreach($brands as $brand)
                                                                            <option
                                                                                value="{{$brand -> id }}"
                                                                                {{$brand->id == $product->brand_id ? 'selected' : ''}}
                                                                            >
                                                                                {{$brand->translations->where('locale',app()->getLocale())->first()->name ?? $brand->translations->where('locale','en')->first()->name ?? $brand->translations->where('locale','ar')->first()->name}}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </optgroup>
                                                            </select>
                                                            @error('brand_id')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group mt-1">
                                                            <input type="checkbox" value="1"
                                                                   name="is_active"
                                                                   id="switcheryColor4"
                                                                   @if($product -> is_active == 1)checked @endif
                                                                   class="switchery" data-color="success"/>
                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">{{__('admin/dashboard.status')}} </label>

                                                            @error("is_active")
                                                            <span class="text-danger">{{$message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            {{--------------prices-------------}}
                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i>{{__('admin/dashboard.prices')}}</h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.prices')}}
                                                            </label>
                                                            <input type="number" id="price"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$product->price}}"
                                                                   name="price">
                                                            @error("price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.special price')}}
                                                            </label>
                                                            <input type="number"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$product->special_price}}"
                                                                   name="special_price">
                                                            @error("special_price")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.special price type')}}
                                                            </label>
                                                            <select name="special_price_type" class="select2 form-control" >
                                                                <optgroup label="{{__('admin/dashboard.choose')}} ">
                                                                    <option value="fixed" {{$product->special_price_type == 'fixed' ? 'selected':''}}>fixed</option>
                                                                    <option value="percent" {{$product->special_price_type == 'percent' ? 'selected':''}}>precent</option>

                                                                </optgroup>
                                                            </select>
                                                            @error('special_price_type')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row" >
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin/dashboard.special price start')}}
                                                            </label>

                                                            <input type="date"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$product->special_price_start->format('Y-m-d')}}"
                                                                   name="special_price_start">

                                                            @error('special_price_start')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> {{__('admin/dashboard.special price end')}}
                                                            </label>
                                                            <input type="date"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$product->special_price_end->format('Y-m-d')}}"
                                                                   name="special_price_end">

                                                            @error('special_price_end')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            {{--------------stock-------------}}
                                            <div class="form-body">

                                                <h4 class="form-section"><i class="ft-home"></i>{{__('admin\dashboard.Manage stock')}}  </h4>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin\dashboard.code')}}(sku)
                                                            </label>
                                                            <input type="text" id="sku"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   value="{{$product->sku}}"
                                                                   name="sku">
                                                            @error("sku")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin\dashboard.Manage stock')}}
                                                            </label>
                                                            <select name="manage_stock" class="select2 form-control" id="manageStock">
                                                                <optgroup label="{{__('admin\dashboard.choose')}} ">
                                                                    <option value="1"  {{$product->manage_stock == 1 ? 'selected':''}}>{{__('admin\dashboard.enable')}}</option>
                                                                    <option value="0"  {{$product->manage_stock == 0 ? 'selected':''}}>{{__('admin\dashboard.disable')}}</option>
                                                                </optgroup>
                                                            </select>
                                                            @error('manage_stock')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- QTY  -->



                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin\dashboard.status')}}
                                                            </label>
                                                            <select name="in_stock" class="select2 form-control" >
                                                                <optgroup label="{{__('admin\dashboard.choose')}}">
                                                                    <option value="1"  {{$product->in_stock == 1 ? 'selected':''}}>{{__('admin\dashboard.available in stock')}}</option>
                                                                    <option value="0"  {{$product->in_stock == 0 ? 'selected':''}}>{{__('admin\dashboard.not available in stock')}}</option>
                                                                </optgroup>
                                                            </select>
                                                            @error('in_stock')
                                                            <span class="text-danger"> {{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6" style="{{$product->manage_stock == 1 ?'':'display:none'}}"  id="qtyDiv">
                                                        <div class="form-group">
                                                            <label for="projectinput1">{{__('admin\dashboard.quantity')}}
                                                            </label>
                                                            <input type="number"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   min="0"
                                                                   value="{{$product->qty}}"
                                                                   name="qty">
                                                            @error("qty")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>




                                            </div>


                                            <div class="form-actions">
                                                <button type="button" class="btn btn-warning mr-1"
                                                        onclick="history.back();">
                                                    <i class="ft-x"></i> {{__('admin/dashboard.back')}}
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> {{__('admin/dashboard.update')}}
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

@section('script')



@stop
