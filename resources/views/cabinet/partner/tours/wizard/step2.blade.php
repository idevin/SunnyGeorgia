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
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_user_profile_tab_1">
                                <form class="m-form m-form--fit m-form--label-align-right" method="POST"
                                      enctype="multipart/form-data"
                                      action="{{route('cabinet:partner:tours.store.step2', $tour->id)}}"
                                >
                                    {!! csrf_field() !!}
                                    <div class="m-portlet__body">

                                        <div class="form-group m-form__group row">
                                            <div class="col-10 ml-auto">
                                                <h3 class="m-form__section">
                                                    2. Tour Details
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="start_place_id" class="col-2 col-form-label">From place</label>
                                            <div class="col-7">
                                                <select name="start_place_id" id="start_place_id" class="form-control m-select2"
                                                        required>
                                                    <option value="" disabled="disabled" selected>-- select --</option>
                                                    @foreach($composer_places->sortBy('name') as $item)
                                                        <option value="{{$item->id}}" {{old('start_place_id') == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="input_thumb" class="col-2 col-form-label">
                                                Thumbnail
                                            </label>
                                            <div class="col-7">
                                                <input id="input_thumb"
                                                       name="thumb" type="file">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="image_dropzone" class="col-2 col-form-label">Images</label>
                                            <div class="col-7">

                                                <input type="file" name="files_uploader">

                                            </div>

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