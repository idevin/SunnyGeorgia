@extends('cabinet.layouts.app',['meta'=>['title'=>$tour->title, 'description'=>$tour->intro]])

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        <small>
                            <a href="{{route('tours.view', ['tour' => $tour->slug, 'preview'=> 'true'])}}"
                               target="_blank">{{route('tours.view', ['tour' => $tour->slug])}}
                            </a>
                        </small>
                    </h3>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        @if ($tour->reviewed && $tour->published)
                            <a href="{{route('tours.view', ['tour' => $tour->slug])}}"
                               class="btn btn-default"
                               target="_blank">Preview</a>
                        @else
                            <a href="{{route('tours.view', ['tour' => $tour->slug, 'preview'=> 'true'])}}"
                               class="btn btn-default"
                               target="_blank">Preview no published</a>
                        @endif
                    </div>
                </div>
                <div class="mr-auto">
                    @if($tour->reviewed)
                        <span class="m--font-success">Одобрено модератором</span>
                    @else
                        <span class="m--font-danger">На проверке</span>
                    @endif
                </div>
                <div class="m-portlet__head-tools">

                    <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{route('cabinet:partner:tours.edit', $tour->id)}}"
                           class="btn--info btn btn-default active"><i class="fa fa-file-alt"></i></a>
                        <a href="{{route('cabinet:partner:tours.accommodation', $tour->id)}}"
                           class="btn--accomodations btn btn-default"><i class="fa fa-building"></i></a>
                        <a href="{{route('cabinet:partner:tours.calendar', $tour->id)}}"
                           class="btn--calendar btn btn-default"><i class="fa fa-calendar-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <tour-edit-helper
                    previous-url="{{ url()->previous() }}"
            ></tour-edit-helper>
            <tour-edit
                    form-role="edit"
                    user-role="partner"
                    :permissions="{{json_encode(\Auth::user()->allPermissions())}}"
                    previous-url="{{ url()->previous() }}"
                    files-action-many="{{route('cabinet:media.uploader')}}"
                    files-delete="{{route('cabinet:media.delete', ':id')}}"
                    form-action="{{route('cabinet:partner:tours.update', $tour->id)}}"
                    user-currency="{{currency()->getUserCurrency()}}"
                    default-currency="{{currency()->getUserCurrency()}}"
                    default-language="{{$defaultLang}}"
                    :data-languages="{{json_encode($languages)}}"
                    :localization="{{json_encode(trans('cabinet/tours'))}}"
                    :composer-currencies="{{json_encode($composer_currencies)}}"
                    :languages="{{json_encode($languages)}}"
                    :partner="{{\Auth::user()->partner}}"
                    :tour-src="{{$tour}}"
                    :food-options="{{$foodOptions}}"
                    :tour-types="{{$tourTypes}}"
                    :current-tour-types="{{$currentTourTypesIds}}"
                    :gallery="{{json_encode($gallery)}}"
            ></tour-edit>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.composer_places = @json($composer_places);
        window.optionGroups = @json($optionGroups);
    </script>
@endpush
