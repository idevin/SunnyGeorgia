@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Добавить тур
                    </h3>
                </div>

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <tour-edit
                    form-role="create"
                    user-role="partner"
                    :permissions="{{json_encode(\Auth::user()->allPermissions())}}"
                    previous-url="{{ url()->previous() }}"


                    form-action="{{route('cabinet:partner:tours.store')}}"
                    user-currency="{{currency()->getUserCurrency()}}"
                    default-currency="{{currency()->getUserCurrency()}}"
                    default-language="{{$defaultLang}}"
                    :data-languages="{{json_encode($languages)}}"
                    :localization="{{json_encode(trans('cabinet/tours'))}}"
                    :composer-currencies="{{json_encode($composer_currencies)}}"
                    :languages="{{json_encode($languages)}}"
                    :partner="{{\Auth::user()->partner}}"

                    :food-options="{{$foodOptions}}"
                    :tour-types="{{$tourTypes}}"


            ></tour-edit>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.default_language = '{{$defaultLang}}';
        window.composer_places = @json($composer_places);
        window.optionGroups = @json($optionGroups);
        window.composer_currencies = @json($composer_currencies);
    </script>
@endpush
