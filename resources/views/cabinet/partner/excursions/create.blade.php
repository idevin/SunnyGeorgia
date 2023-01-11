@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Добавить экскурсию
                    </h3>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <excursion-edit
                    form-role="create"
                    user-role="partner"
                    :permissions="{{json_encode(\Auth::user()->allPermissions())}}"
                    form-action="{{route('cabinet:partner:excursions.store')}}"
                    files-action="{{route('cabinet:media.upload_one')}}"
                    files-action-many="{{route('cabinet:media.upload_many')}}"
                    files-delete="{{route('control:media.delete', ':id')}}"
                    default-currency="{{currency()->getUserCurrency()}}"
                    default-language="{{$defaultLang}}"
                    :localization="{{json_encode(trans('cabinet/excursions'))}}"
                    :composer-currencies="{{json_encode($composer_currencies)}}"
                    :composer-places="{{json_encode($composer_places)}}"
                    :languages="{{json_encode($languages)}}"
                    :partner="{{\Auth::user()->partner}}"
            ></excursion-edit>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        {{--languages = {!! json_encode($languages) !!};--}}
        {{--window.default_language = {!! json_encode($defaultLang) !!};--}}
        window.composer_places = {!! json_encode($composer_places) !!};
        window.optionGroups = {!! json_encode($optionGroups) !!};
        {{--window.composer_currencies = {!! json_encode($composer_currencies) !!};--}}
    </script>
@endpush
