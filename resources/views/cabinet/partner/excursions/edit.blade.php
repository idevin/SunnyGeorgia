@extends('cabinet.layouts.app',['meta'=>['title'=>$excursion->title, 'description'=>$excursion->intro]])

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        <small>
                            <a href="{{route('excursions.view', ['excursion' => $excursion->slug, 'preview'=> 'true'])}}"
                               target="_blank">{{route('excursions.view', ['$excursion' => $excursion->slug])}}
                            </a>
                        </small>
                    </h3>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        @if ($excursion->reviewed && $excursion->published)
                            <a href="{{route('excursions.view', ['excursion' => $excursion->slug])}}"
                               class="btn btn-default"
                               target="_blank">Preview</a>
                        @else
                            <a href="{{route('excursions.view', ['excursion' => $excursion->slug, 'preview'=> 'true'])}}"
                               class="btn btn-default"
                               target="_blank">Preview no published</a>
                        @endif
                    </div>
                </div>
                <div class="mr-auto">
                    @if($excursion->reviewed)
                        <span class="m--font-success">Одобрено модератором</span>
                    @else
                        <span class="m--font-danger">На проверке</span>
                    @endif
                </div>
                <div class="m-portlet__head-tools">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Button group with nested dropdown">
                        <a href="{{route('cabinet:partner:excursions.edit', ['excursion' => $excursion->id])}}"
                           class="btn--info btn btn-default active"><i class="fa fa-file-alt"></i></a>
                        <a href="{{route('cabinet:partner:excursions.calendar', ['excursion' => $excursion->id])}}"
                           class="btn--calendar btn btn-default"><i class="fa fa-calendar-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <excursion-edit
                    form-role="edit"
                    user-role="partner"
                    :permissions="{{json_encode(\Auth::user()->allPermissions())}}"
                    form-action="{{route('cabinet:partner:excursions.update', ['excursion' => $excursion->id])}}"
                    files-action-many="{{route('cabinet:media.uploader')}}"
                    files-delete="{{route('cabinet:media.delete', ':id')}}"
                    user-currency="{{currency()->getUserCurrency()}}"
                    default-language="{{$defaultLang}}"
                    :localization="{{json_encode(trans('cabinet/excursions'))}}"
                    :composer-currencies="{{json_encode($composer_currencies)}}"
                    :composer-places="{{json_encode($composer_places)}}"
                    :languages="{{json_encode($languages)}}"
                    :partner="{{\Auth::user()->partner}}"
                    :gallery="{{json_encode($gallery)}}"
                    :excursion-src="{{$excursion}}"
                    :excursion-types="{{$excursionTypes}}"
                    :current-excursion-types="{{$currentExcursionTypesIds}}"
            ></excursion-edit>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.optionGroups = @json($optionGroups);
    </script>
@endpush
