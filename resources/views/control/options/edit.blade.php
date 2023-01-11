@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Option Group #{{$optionGroup->id}} {{$optionGroup->title}}
                    </h3>
                    <a href="{{route('control:options.group.delete', $optionGroup->id)}}" class="btn btn-danger m-btn m-btn--custom m-btn--bolder m-btn--uppercase" >Delete group</a>

                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <form action="{{route('control:options.update', $optionGroup->id)}}"
                          id="edit_options_form" method="post">
                        {!! csrf_field() !!}
                        @php
                            $optionsGroupTranslations = $optionGroup->getTranslationsArray();
                        @endphp
                        <div class="form-group m-form__group row ">
                            @foreach($languages as $lang)
                                <div class="col-sm">
                                    <label>{{$lang->locale}}</label>

                                    <input type="text" class="form-control m-input"
                                           name="main[{{$lang->locale}}][title]"
                                           value="{{isset($optionsGroupTranslations[$lang->locale]['title']) ? $optionsGroupTranslations[$lang->locale]['title'] : ''}}"
                                            {{$lang->locale == $defaultLang ? 'required':''}}>
                                </div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="m-form__group form-group row">
                            <label class="col-3 col-form-label">
                                {{trans('cabinet/index.Applied for')}}
                            </label>
                            <div class="col-4">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="tours" {{$optionGroup->tours ? 'checked' : ''}}>
                                        Tours
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="excursions" {{$optionGroup->excursions ? 'checked' : ''}}>
                                        Excursions
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="hotels" {{$optionGroup->hotels ? 'checked' : ''}}>
                                        Hotels
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="rooms" {{$optionGroup->rooms ? 'checked' : ''}}>
                                        Hotels Rooms
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{--<div class="m-form__group form-group row">--}}
                            {{--<label class="col-3 col-form-label">--}}
                                {{--Show at--}}
                            {{--</label>--}}
                            {{--<div class="col-4">--}}
                                {{--<div class="m-checkbox-list">--}}
                                    {{--<label class="m-checkbox">--}}
                                        {{--<input type="checkbox" name="main_list" {{$optionGroup->main_list ? 'checked' : ''}}>--}}
                                        {{--Main filter--}}
                                        {{--<span></span>--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="m-form__group form-group row">
                            <label class="col-3 col-form-label">
                                {{trans('cabinet/index.Partners can add price for each option')}}
                            </label>
                            <div class="col-4">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="price" {{$optionGroup->price ? 'checked' : ''}}>

                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="m-form__group form-group row">
                            <label class="col-3 col-form-label">Отображать в фильтре на главной странице</label>
                            <div class="col-4">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="main_list" {{$optionGroup->main_list ? 'checked' : ''}}>

                                        <span></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr>


                        @foreach($optionGroup->options as $option)
                            <div class="form-group m-form__group row ">
                                @php
                                    $optionsTranslations = $option->getTranslationsArray();
                                @endphp
                                @foreach($languages as $lang)
                                    <div class="col-sm">
                                        <label>{{$lang->locale}}</label>

                                        <input type="text" class="form-control m-input"
                                               name="options[{{$option->id}}][{{$lang->locale}}][title]"
                                               value="{{isset($optionsTranslations[$lang->locale]['title']) ? $optionsTranslations[$lang->locale]['title'] : ''}}"
                                                {{$lang->locale == $defaultLang ? 'required':''}}>
                                    </div>
                                @endforeach
                                {{--<div class="col-sm">--}}
                                    {{--<div class="m-form__group form-group row">--}}
                                        {{--<label class="col-3 col-form-label">--}}
                                            {{--More--}}
                                        {{--</label>--}}
                                        {{--<div class="col-9">--}}
                                            {{--<div class="m-checkbox-list">--}}
                                                {{--<label class="m-checkbox">--}}
                                                    {{--<input type="checkbox">--}}
                                                    {{--Price--}}
                                                    {{--<span></span>--}}
                                                {{--</label>--}}
                                                {{--<label class="m-checkbox">--}}
                                                    {{--<input type="checkbox">--}}
                                                    {{--Value--}}
                                                    {{--<span></span>--}}
                                                {{--</label>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="col-sm">
                                    <a href="{{route('control:options.option.delete', $option->id)}}" class="btn btn-danger">{{trans('cabinet/index.Delete')}}</a>
                                </div>
                            </div>
                        @endforeach
                        <h5>New</h5>
                        <div class="new_list">

                        </div>

                        <button class="btn btn-default" type="button" id="add_row_button">Add option</button>

                        <div>
                            <hr>
                            <button class="btn btn-primary m-btn m-btn--custom m-btn--bolder m-btn--uppercase"
                                    type="submit">{{trans('cabinet/index.Update')}}</button>
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