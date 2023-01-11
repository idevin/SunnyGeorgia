@extends('site.layouts.app')

@section('content')
    <main class="page-main flex-full-center">
        <form class="form-full-center" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <h1 class="text-center text-center-title">Reset Password</h1>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="resetEmail">E-Mail Address</label>
                <input id="resetEmail" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="resetPassword">Password</label>
                <input id="resetPassword" type="password" class="form-control" name="password" required>
                @if ($errors->has('password'))
                    <small class="form-text text-danger">{{ $errors->first('password') }}</small>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="resetPasswordConfirm">Confirm Password</label>
                <input id="resetPasswordConfirm" type="password" class="form-control" name="password_confirmation" required>
                @if ($errors->has('password_confirmation'))
                    <small class="form-text text-danger">{{ $errors->first('password_confirmation') }}</small>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
            </div>
        </form>
    </main>
@endsection
