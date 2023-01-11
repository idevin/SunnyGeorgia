@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Profile')}}
                        @if ($partner->verified)
                            <span><i class="fa fa-check m--font-success"></i></span>
                        @else
                            <span><i class="fa fa-times"></i></span>
                        @endif
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
                                      action="{{route('cabinet:partner:profile.update')}}">
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
                                                    1. {{trans('cabinet/index.Owner Details')}}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('first_name') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.First Name')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text" name="first_name"
                                                       value="{{old('first_name', $partner->first_name)}}">
                                                @if ($errors->has('first_name'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('last_name') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.Last Name')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text" name="last_name"
                                                       value="{{old('last_name', $partner->last_name)}}">
                                                @if ($errors->has('last_name'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-10 ml-auto">
                                                <h3 class="m-form__section">
                                                    2. {{trans('cabinet/index.Company Details')}}
                                                </h3>
                                            </div>
                                        </div>

                                        <div class="form-group m-form__group row {{$errors->has('llc') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.Company legal name')}}
                                                <span style="color: red">*</span>
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text" name="llc"
                                                       value="{{old('llc', $partner->llc)}}" required>
                                                @if ($errors->has('llc'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('llc') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row  {{$errors->has('name') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.Company name')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text" name="name"
                                                       value="{{old('name', $partner->name)}}">
                                                @if ($errors->has('name'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row  {{$errors->has('number') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.Registration number')}} <span style="color: red">*</span>
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text" name="number"
                                                       value="{{old('number', $partner->number)}}" required>
                                                @if ($errors->has('number'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('number') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="reg_type" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.Registration type')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <select name="reg_type" id="reg_type" class="form-control">
                                                    @foreach($regTypes as $rType)
                                                        <option value="{{$rType}}" {{$partner->reg_type == $rType ? 'selected' : ''}}>{{$rType}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group m-form__group row">
                                            <label for="bank_name" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.Bank Name')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <div class="m-typeahead">
                                                    <input
                                                            class="form-control m-input bank-select2"
                                                            id="m_typeahead_1"
                                                            name="bank_name"
                                                            type="text"
                                                            {{--placeholder="{{trans('cabinet/index.Bank Name')}}"--}}
                                                            value="{{old('bank_name', $partner->bank_name)}}"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('bank_number') ? 'has-danger' : ''}}">
                                            <label for="bank_name" class="col-sm-2 col-form-label">
                                                {{trans('cabinet/index.Account Number')}} <span
                                                        style="color: red">*</span>
                                            </label>
                                            <div class="col-sm-7">
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


                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2">
                                                {{trans('cabinet/index.Tax')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <label class="m-checkbox">
                                                    <input type="checkbox" class="form-control"
                                                           name="vat" {{$partner->vat ?'checked' : ''}}>
                                                    {{trans('cabinet/index.VAT')}}
                                                    <span></span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2">
                                                {{trans('cabinet/index.Offer')}}
                                            </label>
                                            <div class="col-sm-7">
                                                {{trans('cabinet/index.the Treaty of public offer for the provision of travel services')}}
                                                &nbsp;<a href="{{route('cabinet:offers.tours.ru')}}" target="_blank">Русский</a>
                                                &nbsp;<a href="{{route('cabinet:offers.tours.ka')}}" target="_blank">ქართული</a>

                                            </div>
                                        </div>
                                        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-10 ml-auto">
                                                <h3 class="m-form__section">
                                                    3. {{trans('main.Contacts')}}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                Email
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="email"
                                                       name="email"
                                                       value="{{old('email', $partner->email)}}">
                                                @if ($errors->has('email'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('main.Phone')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text"
                                                       name="phone"
                                                       value="{{old('phone', $partner->phone)}}">
                                            </div>
                                        </div>

                                        {{-- Start: Messengers contacts--}}
                                        @include("cabinet.profile_messengers", ['msg'=> $partner->messengers_arr(), 'phone' => $partner->phone])
                                        {{-- END: Messengers contacts--}}


                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                FAX
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text"
                                                       name="fax"
                                                       value="{{old('fax', $partner->fax)}}">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                Website URL
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text"
                                                       name="website"
                                                       value="{{old('website', $partner->website)}}">
                                            </div>
                                        </div>
                                        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                                        <div class="form-group m-form__group row">
                                            <div class="col-10 ml-auto">
                                                <h3 class="m-form__section">
                                                    4. {{trans('main.Address')}}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('main.Address')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text"
                                                       name="address1"
                                                       value="{{old('address1', $partner->address1)}}">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('main.City')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text"
                                                       name="city"
                                                       value="{{old('city', $partner->city)}}">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('main.Country')}}
                                            </label>
                                            <div class="col-sm-7">
                                                {{--<input class="form-control m-input" type="text"--}}
                                                {{--name="country"--}}
                                                {{--                                                       value="{{old('country', $partner->country)}}">--}}
                                                <input class="form-control m-input" type="text" name="country"
                                                       value="Georgia" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">
                                                {{trans('main.Postcode')}}
                                            </label>
                                            <div class="col-sm-7">
                                                <input class="form-control m-input" type="text"
                                                       name="postcode"
                                                       value="{{old('postcode', $partner->postcode)}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            <div class="row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-7">
                                                    <button type="reset"
                                                            class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                                        {{trans('main.Cancel')}}
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary m-btn m-btn--air m-btn--custom">
                                                        {{trans('main.Save')}}
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

        window.partner = {!! json_encode($partner) !!};

        function checkVerification() {
            var verified;
            if (window.partner) {
                verified = window.partner.verified
            } else {
                verified = false
            }
            if (verified) {
                $('.form-control').each((index, element) => {
                    $(element).attr('disabled', true)
                })
            }
        }

        jQuery(document).ready(function () {

            // Set readonly if partner verification
            checkVerification()
        });
    </script>
@endpush
