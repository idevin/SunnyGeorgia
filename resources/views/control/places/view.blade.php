@extends('cabinet.layouts.app',['meta'=>['title'=>$place->name, 'description'=>str_limit($place->page, 255)]])

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Место
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
                                        {{$place->name}}
                                        <small>

                                            <a href="{{route($place->slug)}}"
                                               target="_blank">{{route($place->slug)}}</a>
                                        </small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">


                            <place-edit
                                    form-action="{{ route('control:places.update', $place->id) }}"
                                    files-action="{{route('control:media.uploader')}}"
                                    files-delete="{{route('control:media.delete', ':id')}}"
                                    :localization="{{json_encode(trans('cabinet/places'))}}"
                            ></place-edit>


                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        window.place = @json($place);
        window.placesGroup = @json($placesGroup);
        window.languages = @json($languages);
        window.default_language = @json($defaultLang);
    </script>
@endpush