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
                    @include('control.tours.block_buttons')
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <form action="{{route('control:tours.update-moderator-data', $tour->id)}}" method="post">
                    {!! csrf_field() !!}
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <h3 class="m-portlet__head-title">
                                Оператор тура
                            </h3>
                        </div>
                        <div class="m-portlet__head-tools">
                            <select name="user_id" class="m-select2">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" {{$user->id == $tour->user->id ? 'selected':''}}>{{$user->id}} {{$user->email}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-4">
                                <label for="input_reviewed">
                                    Review:
                                </label>
                                <select name="reviewed" id="input_reviewed"
                                        class="custom-select form-control m-input m-input--square">
                                    <option value="true" {{$tour->reviewed ? 'selected' :''}}>Разрешено отображать
                                    </option>
                                    <option value="false" {{$tour->reviewed ? '' :'selected'}}>Не одобрено</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="input_score">
                                    Score:
                                </label>
                                <input id="input_score" class="form-control m-input" type="number" name="score"
                                       value="{{$tour->score}}">
                            </div>
                            <div class="col-lg-4">
                                <label for="ribbon_id">
                                    Ribbon:
                                </label>

                                <select name="ribbon_id" id="ribbon_id"
                                        class="custom-select form-control m-input m-input--square">
                                    <option value="">--- no ribbon ---</option>
                                    @foreach($composer_ribbons as $ribbon)
                                        <option value="{{$ribbon->id}}" {{$tour->ribbon_id === $ribbon->id ? 'selected' : ''}}>{{$ribbon->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-12">
                                <h5>При смене адреса url все старые ссылки будут недоступны!!!</h5>
                            </div>
                            @foreach($tour->translations as $translation)
                                <div class="col-4">
                                    <label for="input_slug_{{$translation->locale}}">

                                        @if($translation->locale === 'ru')
                                            <span style="color: red;"> *</span>
                                        @endif
                                        URL {{$translation->locale}}:
                                    </label>
                                    <input id="input_slug_{{$translation->locale}}"
                                           class="form-control m-input"
                                           name="slug:{{$translation->locale}}"
                                           value="{{ $translation->slug }}"
                                           @if($translation->locale === 'ru')
                                           required
                                            @endif
                                    >
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-12">
                                <h5>Не индексировать (NOINDEX FOLLOW)</h5>
                            </div>
                            @foreach($tour->translations as $translation)
                                <div class="col-4">
                                    <label class="m-checkbox m-checkbox--brand">
                                        <input type="checkbox"
                                               @if($tour->{'noindex_'.$translation->locale}) checked @endif
                                               value="true"
                                               name="noindex_{{$translation->locale}}"
                                        >
                                        {{$translation->locale}}
                                        <span></span>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <input type="submit" class="btn btn-primary" value="{{trans('cabinet/index.Update')}}">
                    </div>
                </form>
            </div>
            <tour-edit
                    form-role="edit"
                    user-role="admin"
                    :permissions="{{json_encode(\Auth::user()->allPermissions())}}"
                    previous-url="{{ url()->previous() }}"
                    files-action-many="{{route('control:media.uploader')}}"
                    files-delete="{{route('control:media.delete', ':id')}}"
                    form-action="{{route('control:tours.update', $tour->id)}}"
                    user-currency="{{currency()->getUserCurrency()}}"
                    default-currency="{{currency()->getUserCurrency()}}"
                    default-language="{{$defaultLang}}"
                    :data-languages="{{json_encode($languages)}}"
                    :localization="{{json_encode(trans('cabinet/tours'))}}"
                    :composer-currencies="{{json_encode($composer_currencies)}}"
                    :languages="{{json_encode($languages)}}"
                    :partner="{{$tour->partner}}"
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
        jQuery(document).ready(function () {
            $('.m-select2').select2({
                placeholder: 'Select owner'
            });
        });
    </script>
@endpush
