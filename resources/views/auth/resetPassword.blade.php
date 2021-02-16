@extends('auth/layout')

@section('title', 'Forgot Password')

@section('content')
    <div class="cont">
        @if(session('success'))
            <div class="form">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Successful! </strong>{{session('success')}}
                </div>
            </div>
        @elseif(session('error'))
            <div class="form">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ session('error') }}</strong>
                    <a href="/forgot-password">Request</a>
                </div>
            </div>
        @else
            <form class="reset-password-form" action="{{route('login.resetPassword')}}" method="POST">
                @csrf
                <input type="hidden" name="resetPasswordToken" value="{{ $token }}" />
                <div class="form">
                    <label for="password">
                        <span>New Password</span>
                        <input id="password" type="password" name="password" />
                        <p class="text-danger error-password"></p>
                    </label>
                    <label for="confirm-password">
                        <span>Confirm Password</span>
                        <input id="confirm-password" type="password" name="confirmPassword" />
                        <p class="text-danger error-confirm-password"></p>
                    </label>
                    <button type="submit" class="submit">Recover my data</button>
                    <p class="forgot-pass"><a href="/">Home</a></p>
                </div>
            </form>
        @endif

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

@section('scripts')
<script type="text/javascript">
$(document).ready(() => {
  const validate = (passwordEl, confirmPasswordEl) => {
    const password = passwordEl.val();
    const confirmPassword = confirmPasswordEl.val();

    if (password.length < 8) {
      $('.error-password').html('Min have 8 characters or more.');
      return false;
    } else {
      $('.error-password').html('');
    }
    if (confirmPassword.length < 8) {
      $('.error-confirm-password').html('Min have 8 characters or more.');
      return false;
    } else {
      $('.error-confirm-password').html('');
    }
    if (password !== confirmPassword) {
      $('.error-confirm-password').html('Password does not match!');
      return false;
    } else {
      $('.error-confirm-password').html('');
    }

    return true;
  };

  $('.reset-password-form .submit').on('click', () => {
    event.preventDefault();
    const passwordEl = $('.reset-password-form').find('input[name="password"]');
    const confirmPasswordEl = $('.reset-password-form').find('input[name="confirmPassword"]');
    const isValid = validate(passwordEl, confirmPasswordEl);
    if (!isValid) return false;

    $('.reset-password-form').submit();
  });
});
</script>
@endsection
