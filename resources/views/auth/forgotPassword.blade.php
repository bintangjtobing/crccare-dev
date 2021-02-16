@extends('auth/layout')

@section('title', 'Forgot Password')

@section('content')
    <div class="cont-forgot">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Recover Success!</strong>{{session('success')}}
            </div>
        @endif
        @if (session('error'))
            <div class="form">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <a href="/forgot-password">Request</a>
                </div>
            </div>
        @endif

        <form action="{{route('login.forgotPassword')}}" method="POST">
            @csrf
            <div class="form sign-in">
                <label>
                    <span>Input Your Email</span>
                    <input type="email" name="email">
                </label>
                <button type="submit" class="submit">Recover my data</button>
                <p class="forgot-pass"><a href="/">Home</a></p>
            </div>
        </form>
        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <img src="{!!asset('assets/images/logo_crc-white.png')!!}" alt="">
                    <h2>Lost your password?</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
