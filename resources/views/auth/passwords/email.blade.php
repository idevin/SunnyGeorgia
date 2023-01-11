@extends('site.layouts.app')

@section('content')
    <main class="page-main flex-full-center">
        <form class="form-full-center" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="form-group">
                <h1 class="text-center text-center-title">Forgot Password</h1>
            </div>
            <div class="form-group">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="forgotEmail">E-Mail Address</label>
                <input id="forgotEmail" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Send Password Reset Link</button>
            </div>
        </form>
    </main>
@endsection
