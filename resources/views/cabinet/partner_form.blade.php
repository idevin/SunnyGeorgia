@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Become a partner')}}
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
                                      action="{{route('cabinet:profile.become_partner')}}">
                                    {!! csrf_field() !!}
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group row">
                                            <div class="col-10 ml-auto">
                                                <h3 class="m-form__section">
                                                    1. {{trans('cabinet/index.Owner Details')}}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('first_name') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('cabinet/index.First Name')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text" name="first_name"
                                                       value="{{old('first_name', $user->first_name)}}">
                                                @if ($errors->has('first_name'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row {{$errors->has('last_name') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Last Name')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text" name="last_name"
                                                       value="{{old('last_name', $user->last_name)}}">
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
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Company legal name')}} <span style="color: red">*</span>
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text" name="llc"
                                                       value="{{old('llc')}}" required>
                                                @if ($errors->has('llc'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('llc') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row  {{$errors->has('name') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Company name')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text" name="name"
                                                       value="{{old('name')}}">
                                                @if ($errors->has('name'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row  {{$errors->has('number') ? 'has-danger' : ''}}">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Registration number')}} <span style="color: red">*</span>
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text" name="number"
                                                       value="{{old('number')}}" required>
                                                @if ($errors->has('number'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('number') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="reg_type" class="col-2 col-form-label">
                                                {{trans('cabinet/index.Registration type')}}
                                            </label>
                                            <div class="col-7">
                                                <select name="reg_type" id="reg_type" class="form-control">
                                                    @foreach($regTypes as $rType)
                                                        <option value="{{$rType}}">{{$rType}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="m-form__group fm-form__group row">
                                            <label for="example-text-input" class="col-2">
                                                {{trans('cabinet/index.Tax')}}
                                            </label>
                                            <div class="m-checkbox-list col-7">
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="vat" >
                                                    {{trans('cabinet/index.VAT')}}
                                                    <span></span>
                                                </label>

                                            </div>
                                        </div>
                                        <div class="m-form__group fm-form__group row">
                                            <label for="example-text-input" class="col-2">
                                                {{trans('cabinet/index.Offer')}}
                                                <span style="color: red">*</span>
                                            </label>
                                            <div class="m-checkbox-list col-7">
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="agree" required>
                                                    {{trans('cabinet/index.I agree with')}}
                                                    {{trans('cabinet/index.the Treaty of public offer for the provision of travel services')}}
                                                    &nbsp;<a href="{{route('cabinet:offers.tours.ru')}}" target="_blank">Русский</a>
                                                    &nbsp;<a href="{{route('cabinet:offers.tours.ka')}}" target="_blank">ქართული</a>
                                                    <span></span>
                                                </label>

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
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                Email
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="email"
                                                       name="email"
                                                       value="{{old('email', $user->email)}}">
                                                @if ($errors->has('email'))
                                                    <div class="form-control-feedback">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('main.Phone')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text"
                                                       name="phone"
                                                       value="{{old('phone', $user->mobile_number)}}">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                FAX
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text"
                                                       name="fax"
                                                       value="{{old('fax')}}">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                Website URL
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text"
                                                       name="website"
                                                       value="{{old('website')}}">
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
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('main.Address')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text"
                                                       name="address1"
                                                       value="{{old('address1')}}">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('main.City')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text"
                                                       name="city"
                                                       value="{{old('city')}}">
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('main.Country')}}
                                            </label>
                                            <div class="col-7">
                                                {{--<input class="form-control m-input" type="text"--}}
                                                       {{--name="country"--}}
{{--                                                       value="{{old('country', $partner->country)}}">--}}
                                                <input class="form-control m-input" type="text" name="country"
                                                       value="Georgia" readonly disabled>
                                            </div>
                                        </div>
                                        <div class="form-group m-form__group row">
                                            <label for="example-text-input" class="col-2 col-form-label">
                                                {{trans('main.Postcode')}}
                                            </label>
                                            <div class="col-7">
                                                <input class="form-control m-input" type="text"
                                                       name="postcode"
                                                       value="{{old('postcode')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions">
                                            <div class="row">
                                                <div class="col-2"></div>
                                                <div class="col-7">
                                                    <button type="submit"
                                                            class="btn btn-primary m-btn m-btn--air m-btn--custom">
                                                        {{trans('cabinet/index.Become a partner')}}
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