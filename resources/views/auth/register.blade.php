@extends('site.layouts.app')

@section('content')
    <!--main-->
    <main class="page-main bg-white">
        <div class="container">
            <div class="row justify-content-md-center ">

                <div class="col col-lg-5 col-sm-12 col-md-8">
                    <br>
                    <h1 class="text-center">{{trans('main.login.Registration')}}</h1>
                    <user-registration
                            :localization="{{json_encode(trans('main.registration'))}}"
                            email-check-route="{{route('xhr.user.email_check')}}"
                            post-registration="{{route('register.soft')}}"
                            :countries-codes="{{ json_encode($composer_countries_codes)}}"
                            default-code="DK"
                    ></user-registration>
                </div>
            </div>
        </div>
    </main>
    <!--end main-->
@endsection
