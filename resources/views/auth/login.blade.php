@extends('site.layouts.new-app')
@push('header')
    <meta name="robots" content="noindex, follow">
    <link rel="preload" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    {{--  @foreach ($cssChunks as $filename)--}}
    {{--    <link rel="preload" href="{{ URL::asset($filename) }}" as="style">--}}
    {{--  @endforeach--}}
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">

    <style>
        body {
            height: 100vh;
        }
        #app {
            display: flex;
            flex-flow: column;
            height: 100%;
            overflow: hidden;
        }
        .form-group {
            display: flex;
            flex-flow: column;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
    <!--main-->
    <main
            class="page-main bg-white"
            style="flex: 1; display: flex; align-items: center; justify-content: center"
    >
        <div class="container">
            <div class="row justify-content-md-center ">

                <div class="col col-lg-5 col-sm-12 col-md-8">

                    <br>
                    <h1 class="text-center">{{trans('main.login.Login')}}</h1>

                    <form class="" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="loginEmail">Email:</label>
                            <input id="loginEmail" type="email"
                                   class="form-control {{$errors->has('email') ?'is-invalid':''}}" name="email"
                                   value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="loginPassword">{{trans('main.login.Password')}}:</label>
                            <input id="loginPassword" type="password"
                                   class="form-control {{$errors->has('password') ? 'is-invalid':''}}" name="password"
                                   required>

                            @if ($errors->has('password'))
                                <small class="form-text text-danger">{{ $errors->first('password')}}</small>
                            @endif
                        </div>
                        {{--<div class="form-group form-check">--}}
                        {{--<input class="form-check-input" id="loginRemember" type="checkbox"--}}
                        {{--name="remember" {{ old('remember') ? 'checked' : '' }}>--}}
                        {{--<label class="form-check-label" for="loginRemember">{{trans('main.login.Remember me')}}</label>--}}
                        {{--</div>--}}

                        <div class="form-group ">

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"
                                       name="remember"
                                       id="login-remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                       for="login-remember">{{trans('main.login.Remember me')}}</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-outline-primary"
                                    type="submit">{{trans('main.login.Login')}}</button>
                            <a href="{{ route('password.request') }}"
                               class="modal-link pull-right">{{trans('main.login.Forgot password?')}}</a>
                        </div>

                        {{--<div class="form-group d-flex justify-content-between">--}}
                        {{--<button type="submit" class="btn btn-primary btn-lg">--}}
                        {{--Login--}}
                        {{--</button>--}}

                        {{--<a class="btn btn-link btn-lg" href="{{ route('password.request') }}">--}}
                        {{--Forgot Your Password?--}}
                        {{--</a>--}}
                        {{--</div>--}}
                    </form>


                </div>
            </div>
        </div>
    </main>
    <!--end main-->
@endsection


@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages-vendors.js')) }}"
            defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages.js')) }}" defer></script>
@endpush
