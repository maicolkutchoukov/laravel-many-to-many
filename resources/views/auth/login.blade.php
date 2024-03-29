@extends('layouts.guest')

@section('main-content')
    {{-- <div class="row justify-content-center align-items-center mt-5 p-4"> --}}
        <div class="login-form-container">
            <form method="POST" action="{{ route('login') }}" class="login-form p-4">
                @csrf
        
                <!-- Email Address -->
                <div>
                    <label for="email" class="me-5">
                        Email
                    </label>
                    <input type="email" id="email" name="email">
                </div>
        
                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="me-3">
                        Password
                    </label>
                    <input type="password" id="password" name="password">
                </div>
        
                <!-- Remember Me -->
                <div class="mt-4">
                    <label for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>
                <button type="submit" class="mt-3">
                    Log in
                </button>
                <div class="mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
        
                    
                </div>
            </form>
        </div>
    {{-- </div> --}}
@endsection
