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
                                      action="{{route('cabinet:partner:tours.store.step3', $tour->id)}}"
                                >
                                    {!! csrf_field() !!}
                                    <div class="m-portlet__body">

                                        <div class="form-group m-form__group row">
                                            <div class="col-10 ml-auto">
                                                <h3 class="m-form__section">
                                                    2. Tour Options
                                                </h3>
                                            </div>
                                        </div>

                                        @foreach($optionGroups as $optionGroup)
                                            <div class="m-form__group form-group row">
                                                <label class="col-3 col-form-label">
                                                    {{$optionGroup->title}}
                                                </label>
                                                <div class="col-4">
                                                    <div class="m-checkbox-list">
                                                        @foreach($optionGroup->options as $option)
                                                            <label class="m-checkbox">
                                                                <input type="checkbox"
                                                                       name="options[{{$option->id}}]" {{old('options.'.$option->id) ? 'checked' : ''}}>
                                                                {{$option->title}}
                                                                <span></span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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