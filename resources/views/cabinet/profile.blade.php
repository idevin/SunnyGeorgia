@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        {{trans('cabinet/index.Profile')}}
                    </h3>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="form-group m-form__group m--margin-top-10 m--hide">
                <div class="alert m-alert m-alert--default" role="alert">
                    The example form below demonstrates common HTML form elements that
                    receive updated styles from Bootstrap with additional classes.
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <avatar-component
                            user-avatar="{{ $user->avatar ? $user->avatar->url : '' }}"
                            header-text="{{trans('cabinet/index.Profile picture')}}"
                            upload-url="{{route('cabinet:media.upload_avatar')}}"
                            user-id="{{$user->id}}"
                    ></avatar-component>
                </div>
                <div class="col-xl-8">
                    <form class="m-form m-form--fit m-form--label-align-right" method="POST"
                          action="{{route('cabinet:profile.update_public')}}"
                    >
                        {!! csrf_field() !!}
                        <div class="m-portlet">
                            <div class="m-portlet__head">
                                <div class="m-portlet__head-caption">
                                    <h3 class="m-portlet__head-title">
                                        {{trans('cabinet/index.Public Details')}}
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__body">
                                <div class="m-section__content">
                                    <div class="form-group m-form__group row">
                                        <label for="example-text-input" class="col-3 col-form-label">
                                            {{trans('cabinet/index.Display name')}}
                                        </label>
                                        <div class="col-9">
                                            <input class="form-control m-input" type="text" name="display_name"
                                                   value="{{$user->display_name}}">
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        <label for="country_list" class="col-3 col-form-label">
                                            {{trans('main.Country')}}
                                        </label>
                                        <div class="col-9">
                                            <select name="country" id="country_list" class="form-control m-select2">
                                                <option disabled="disabled" {{empty($user->country) ? 'selected="selected"' : ''}}>
                                                    {{trans('main.Select country')}}
                                                </option>
                                                @foreach($composer_countries as $countryName)
                                                    <option value="{{$countryName}}" {{$countryName === $user->country ? 'selected="selected"' : ''}}>{{$countryName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot">
                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary">
                                            {{trans('main.Save')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="m-portlet">
                <form class="m-form m-form--fit m-form--label-align-right" method="POST"
                      action="{{route('cabinet:profile.update')}}">
                    {!! csrf_field() !!}
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <h3 class="m-portlet__head-title">
                                {{trans('cabinet/index.Private information')}}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-section__content">
                                <!-- START: Name -->
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        {{trans('cabinet/index.First Name')}}
                                        <span style="color: red;">*</span>
                                    </label>

                                    <div class="col-4">
                                        <input class="form-control m-input" type="text" name="first_name"
                                               value="{{$user->first_name}}" required>
                                    </div>
                                    <label for="locale" class="col-2 col-form-label">
                                        {{trans('main.Language')}}
                                    </label>
                                    <div class="col-4">
                                        <select name="locale" id="locale" class="form-control m-select2">
                                            @foreach($languages as $lang)
                                                <option value="{{$lang->locale}}" {{$lang->locale === $user->locale ? 'selected="selected"' : ''}}>{{$lang->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- END: Name -->
                                <!-- START: Language Currency -->
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        {{trans('cabinet/index.Last Name')}}
                                        <span style="color: red;">*</span>
                                    </label>
                                    <div class="col-4">
                                        <input class="form-control m-input" type="text" name="last_name"
                                               value="{{$user->last_name}}" required>
                                    </div>

                                    <label for="currency" class="col-2 col-form-label">
                                        {{trans('main.Currency')}}
                                    </label>
                                    <div class="col-4">
                                        <select name="currency" id="currency" class="form-control m-select2">
                                            @foreach($composer_currencies as $cur)
                                                <option value="{{$cur->code}}" {{$cur->code === $user->currency ? 'selected="selected"' : ''}}>{{$cur->name}} {{$cur->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- END: Language Currency -->
                                <!-- START: Mobile -->
                                <div class="form-group m-form__group row">
                                    @if($user->mobile_number)
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        {{trans('main.Mobile phone')}}
                                    </label>
                                    <div class="col-4">
                                        <input class="form-control m-input mobile_phone_input_mask" type="text"
                                               name="mobile_number"
                                               value="{{$user->mobile_number}}"
                                               disabled
                                        >
                                        <div id="confirmation_block" class="profile__confirmation-block">
                                            @if($user->mobile_confirmed)
                                                <button type="button" class="btn btn-success disabled"
                                                        disabled="disabled"
                                                        style="width: 100%"
                                                >{{trans('cabinet/index.Verified')}}</button>
{{--                                                todo доделать валидацию телефона в профиле--}}
{{--                                            @elseif(!$user->mobile_confirmed && !empty($user->mobileVerificationCodes()) && $user->mobile_number)--}}
{{--                                                <input class="form-control m-input" type="text" name="code"--}}
{{--                                                       placeholder="enter code here" id="confirm_code"--}}
{{--                                                >--}}
{{--                                                <button onclick="confirmMobile(this); return false;"--}}
{{--                                                        class="btn btn-success"--}}
{{--                                                        style="width: 100%"--}}
{{--                                                >{{trans('cabinet/index.Verify')}}</button>--}}
{{--                                                <a href="{{route('cabinet:profile.mobile.send_sms')}}">--}}
{{--                                                    Resend code--}}
{{--                                                </a>--}}
{{--                                            @elseif(!empty($user->mobile_number))--}}
{{--                                                <a href="{{route('cabinet:profile.mobile.send_sms')}}"--}}
{{--                                                   class="btn btn-info"--}}
{{--                                                >{{trans('cabinet/index.Verify')}}</a>--}}
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        Email
                                    </label>
                                    <div class="col-4">
                                        <input class="form-control m-input" type="text" name="last_name"
                                               value="{{$user->email}}" disabled
                                        >
                                        <div class="profile__confirmation-block">
                                            @if($user->email_verified)
                                                <button type="button" class="btn btn-success disabled"
                                                        disabled="disabled"
                                                        style="width: 100%"
                                                >
                                                    {{trans('cabinet/index.Verified')}}
                                                </button>
                                            @else
                                                <a href="{{route('cabinet:profile.activate_email_link')}}"
                                                   class="btn btn-info"
                                                   style="width: 100%"
                                                >
                                                    {{trans('cabinet/index.Verify')}}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Mobile -->
                                <!-- START: Email -->
                                <!-- END: Email -->

                            </div>
                    </div>
                    <div class="m-portlet__foot">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('main.Save')}}
                                </button>
                                <button class="btn btn-secondary" type="button" data-toggle="modal"
                                        data-target="#user_password_change">{{trans('cabinet/index.Change password')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('cabinet.layouts.change_password_modal')
@endsection
@push('scripts')
    <script>
        function confirmMobile(button) {
            var code = $('#confirm_code').val();
            var url = '{{ route('cabinet:profile.mobile.confirm') }}';
            $(button).addClass('m-loader m-loader--light m-loader--right');
            $.ajax({
                url: url,
                data: {code: code},
                success: function () {
                    $('#confirmation_block').html('<span class="btn btn-success disabled">Verified</span>');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    var response = $.parseJSON(jqXHR.responseText);
                    alert('Wrong code!');
                },
                complete: function () {
                    $(button).removeClass('m-loader m-loader--light m-loader--right');
                }
            });
        }

        $(".mobile_phone_input_mask").inputmask({
            mask: "+999999999999999",
            placeholder: ""
        });

        jQuery(document).ready(function () {
            $('.m-select2').select2({
                placeholder: 'Select country',
                allowClear: true
            });
        });
    </script>
@endpush
