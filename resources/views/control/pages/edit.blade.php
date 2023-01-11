@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Page
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">

                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Page
                                        @if(isset($page))
                                            Update
                                        @else
                                            Create
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <form
                                    @if (isset($page)) action="{{route('control:pages.update', $page->id)}}"
                                    @else action="{{route('control:pages.store')}}"
                                    @endif
                                    method="POST"
                            >
                                @if(isset($page))
                                    <input type="hidden" name="_method" value="PUT">
                                @endif

                                    {{ csrf_field() }}

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Slug</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="slug" required placeholder="Select route">
                                                @foreach ($routes as $name)
                                                    <option value="{{$name}}" @if (isset($page) && ($page->slug == $name)) selected @endif>{{$name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-12" id="accordionMetaTags">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Locales and Meta Tags</label>
                                                <h5 class="col-sm-10 mb-0">
                                                    @foreach($locales as $locale)
                                                        <button class="btn btn-link"
                                                                type="button"
                                                                data-toggle="collapse"
                                                                data-target="#collapse_{{$locale}}"
                                                                aria-expanded="true"
                                                                aria-controls="collapse_{{$locale}}"
                                                        >
                                                            {{$locale}}
                                                        </button>
                                                    @endforeach
                                                </h5>
                                            </div>

                                            @foreach($locales as $locale)
                                                <div id="collapse_{{$locale}}"
                                                     class="collapse @if ($locale == 'ru') show @endif"
                                                     aria-labelledby="headingOne"
                                                     data-parent="#accordionMetaTags"
                                                >
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Page name {{$locale}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="translations[{{$locale}}][name]"
                                                                   placeholder="page name"
                                                                   value="{{ $page->{'name:'.$locale} ?? ''}}"
                                                            >
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Meta Title {{$locale}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text"
                                                                   class="form-control"
                                                                   name="translations[{{$locale}}][meta_title]"
                                                                   placeholder="meta title"
                                                                   value="{{ $page->{'meta_title:'.$locale} ?? ''}}"
                                                            >
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Meta Description {{$locale}}</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control"
                                                                   name="translations[{{$locale}}][meta_description]"
                                                                   placeholder="meta description"
                                                                   value="{{ $page->{'meta_description:'.$locale} ?? ''}}"
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="btn-group col-md-auto align-center">
                                            <button type="submit" class="btn btn-primary mr-2">
                                                @if(isset($page))
                                                    Update
                                                @else
                                                    Create
                                                @endif
                                            </button>
                                            <a class="btn btn-default" href="{{route('control:pages.index')}}">
                                                <i class="fa fa-list"></i>
                                            </a>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection