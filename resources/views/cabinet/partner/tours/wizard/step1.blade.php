@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Add new tour

                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                        <form class="m-form m-form--fit m-form--label-align-right" method="POST"
                              action="{{route('cabinet:partner:tours.store')}}"
                        >
                            {!! csrf_field() !!}

                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <div class="m-portlet__head-title">
                                        <h3 class="m-portlet__head-text">
                                            1. Tour Details
                                        </h3>
                                    </div>
                                </div>
                                <div class="m-portlet__head-tools">
                                    <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--right m-tabs-line-danger"
                                        role="tablist">
                                        @foreach($languages as $lang)
                                            <li class="nav-item m-tabs__item">
                                                <a class="nav-link m-tabs__link {{$lang->locale == $defaultLang ? 'active' : ''}}"
                                                   data-toggle="tab"
                                                   href="#m_portlet_tab_{{$lang->locale}}" role="tab">
                                                    {{$lang->name}}
                                                    @if($lang->locale == $defaultLang)
                                                        (default)
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="tab-content">

                                    @foreach($languages as $lang)
                                        <div class="tab-pane {{$lang->locale == $defaultLang ? 'active' : ''}}"
                                             id="m_portlet_tab_{{$lang->locale}}">
                                            <div class="form-group m-form__group row">
                                                <label for="input_title"
                                                       class="col-2 col-form-label">Title {!!$lang->locale == $defaultLang ? '<span style="color: red">*</span>' : '' !!}
                                                    ({{$lang->locale}})</label>
                                                <div class="col-7">
                                                    <input class="form-control m-input" id="input_title"
                                                           type="text" name="{{$lang->locale}}[title]"
                                                           {!!$lang->locale == $defaultLang ? 'required' : '' !!}
                                                           value="{{old($lang->locale.'.title')}}">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="input_intro" class="col-2 col-form-label">Intro</label>

                                                <div class="col-7">
                                                <textarea class="form-control m-input" id="input_intro"
                                                          name="{{$lang->locale}}[intro]"
                                                          rows="10">{{old($lang->locale.'.intro')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label for="input_description"
                                                       class="col-2 col-form-label">Description</label>

                                                <div class="col-7">
                                                <textarea class="form-control m-input summernote"
                                                          name="{{$lang->locale}}[description]"
                                                          id="input_description"
                                                          rows="10">{{old($lang->locale.'.description')}}</textarea>
                                                </div>
                                            </div>


                                        </div>

                                    @endforeach
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-7">
                                            <button type="submit"
                                                    class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                                Save changes
                                            </button>
                                            &nbsp;&nbsp;
                                            <button type="reset"
                                                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script src="/assets/vendors/custom/fileuploader/src/jquery.fileuploader.min.js" type="text/javascript"></script>
    <link href="/assets/vendors/custom/fileuploader/src/jquery.fileuploader.css" rel="stylesheet">
    <script>

        jQuery(document).ready(function () {
            $('.m-select2').select2({});
            $(".summernote").summernote({height: 150});

            $('input[name="files_uploader"]').fileuploader({
                // Options will go here
            });
            $('input[name="thumb"]').fileuploader({
                limit: 1
            });


        });
    </script>
@endpush