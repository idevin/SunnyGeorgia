@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        New Option Group
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <form action="{{route('control:options.store')}}"
                          id="edit_options_form" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group m-form__group row ">
                            @foreach($languages as $lang)
                                <div class="col-sm">
                                    <label>{{$lang->locale}} {{$lang->locale == $defaultLang ? '*':''}}</label>

                                    <input type="text" class="form-control m-input"
                                           name="main[{{$lang->locale}}][title]"
                                           value="{{old('main.'.$lang->locale.'.title')}}"
                                            {{$lang->locale == $defaultLang ? 'required':''}}>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="m-form__group form-group row">
                            <label class="col-1 col-form-label">
                                Applied for
                            </label>
                            <div class="col-4">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox"
                                               name="tours" {{old('tours') ? 'checked' : ''}}>
                                        Tours
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox"
                                               name="excursions" {{old('excursions') ? 'checked' : ''}}>
                                        Excursions
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input checked="checked" type="checkbox"
                                               name="hotels" {{old('hotels') ? 'checked' : ''}}>
                                        Hotels
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input disabled="" type="checkbox"
                                               name="rooms" {{old('rooms') ? 'checked' : ''}}>
                                        Hotels Rooms
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-form__group form-group row">
                            <label class="col-1 col-form-label">
                                Show at
                            </label>
                            <div class="col-4">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox"
                                               name="main_list" {{old('main_list') ? 'checked' : ''}}>
                                        Main filter
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>


                        <h5>New option</h5>
                        <div class="new_list">
                            <div class="form-group m-form__group row">
                                @foreach($languages as $lang)
                                    <div class="col-sm">
                                        <label>{{$lang->locale}} {{$lang->locale == $defaultLang ? '*':''}}</label>
                                        <input type="text" class="form-control m-input"
                                               value="{{old('newOption.1.'.$lang->locale.'title')}}"
                                               name="newOption[1][{{$lang->locale}}][title]" {{$lang->locale == $defaultLang ? "required":""}}>
                                    </div>
                                @endforeach
                                <div class="col-sm">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-default" type="button" id="add_row_button">Add option</button>

                        <div>
                            <hr>
                            <button class="btn btn-primary btn-lg" type="submit" id="add_row_button">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#add_row_button').click(function (e) {
            var liAmount = $(this).parent().find('ul.new_list li').length;
            var html = '<div class="form-group m-form__group row">' +
                    @foreach($languages as $lang)
                        '<div class="col-sm">' +
                '<label>{{$lang->locale}}</label>' +
                '<input type="text" class="form-control m-input" name="newOption[' + liAmount + '][{{$lang->locale}}][title]" {{$lang->locale == $defaultLang ? "required":""}}>' +
                '</div>' +
                    @endforeach
                        '<div class="col-sm">' +
                '<a href="#" class="btn btn-danger" onclick="$(this).parent().parent().remove(); return false;">Delete</a>' +
                '</div>' +
                '</div>';
            $(this).parent().find('div.new_list').append(html);
        });

    </script>
@endpush