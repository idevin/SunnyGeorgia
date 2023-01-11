@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Partner Billing Account')}}
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
                                      action="{{route('cabinet:partner:billing.update')}}">
                                    {!! csrf_field() !!}
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group m--margin-top-10 m--hide">
                                            <div class="alert m-alert m-alert--default" role="alert">
                                                The example form below demonstrates common HTML form elements that
                                                receive updated styles from Bootstrap with additional classes.
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-10 ml-auto">
                                                <h3 class="m-form__section">
                                                    {{trans('cabinet/index.Partner Billing Account')}}


                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('bank_name') ? 'has-danger' : ''}}">
                                            <label for="bank_name" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Bank Name')}} <span style="color: red">*</span>
                                            </label>
                                            <div class="col-7">
                                                <div class="m-typeahead">
                                                    <input class="form-control m-input bank-select2" id="m_typeahead_1"
                                                           name="bank_name" type="text"
                                                           required
                                                           {{--placeholder="{{trans('cabinet/index.Bank Name')}}"--}}
                                                           value="{{old('bank_name', $partner->bank_name)}}">
                                                </div>

                                                @if ($errors->has('bank_name'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('bank_name') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('bank_number') ? 'has-danger' : ''}}">
                                            <label for="bank_name" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Account Number')}} <span style="color: red">*</span>
                                            </label>
                                            <div class="col-7">
                                                <div class="m-typeahead">
                                                    <input class="form-control m-input" id="m_typeahead_1"
                                                           name="bank_number" type="text"
                                                           required
                                                           {{--placeholder="{{trans('cabinet/index.Bank Name')}}"--}}
                                                           value="{{old('bank_number', $partner->bank_number)}}">
                                                </div>

                                                @if ($errors->has('bank_number'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('bank_number') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('bank_recipient') ? 'has-danger' : ''}}">
                                            <label for="bank_recipient" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Beneficiary')}} <span style="color: red">*</span>
                                            </label>
                                            <div class="col-7">
                                                <div class="m-typeahead">
                                                    <input class="form-control m-input" id="m_typeahead_1"
                                                           name="bank_recipient" type="text"
                                                           required
                                                           {{--placeholder="{{trans('cabinet/index.Bank Name')}}"--}}
                                                           value="{{old('bank_recipient', $partner->bank_recipient)}}">
                                                </div>

                                                @if ($errors->has('bank_recipient'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('bank_recipient') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @foreach($fields as $key => $name)
                                            <div class="form-group m-form__group row {{$errors->has($key) ? 'has-danger' : ''}}">
                                                <label for="bank_name" class="col-2 col-form-label">
                                                    {{trans('cabinet/index.'.$name)}}
                                                </label>
                                                <div class="col-7">
                                                    <input class="form-control m-input" type="text" name="{{$key}}"
                                                           value="{{old($key, $partner->$key)}}">
                                                    @if ($errors->has($key))
                                                        <div class="form-control-feedback">
                                                            <strong>{{ $errors->first($key) }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="form-group m-form__group row {{$errors->has($key) ? 'has-danger' : ''}}">
                                            <label for="bank_name" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Country')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text" name="bank_country"
                                                       value="Georgia" readonly disabled>
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
                                                        {{trans('main.Save changes')}}
                                                    </button>
                                                    &nbsp;&nbsp;
                                                    <button type="reset"
                                                            class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                                        {{trans('main.Cancel')}}

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane active" id="m_user_profile_tab_2"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function () {

            var e = [
                @foreach(trans('banks') as $bankName)
                // {
                {{--id: '{{$bankName}}',--}}
                    '{{$bankName}}',
                // },
                @endforeach
            ];
            // $('.bank-select2').select2({
            //     data: data,
            // });
            $('.bank-select2').typeahead({
                    minLength: 0,
                    highlight: true
                },
                {
                    limit: 50,
                    source: function (e) {
                        return function (a, n) {
                            var o;
                            o = [], substrRegex = new RegExp(a, "i"), $.each(e, function (e, a) {
                                substrRegex.test(a) && o.push(a)
                            }), n(o)
                        }
                    }(e)
                });
        });
    </script>
@endpush