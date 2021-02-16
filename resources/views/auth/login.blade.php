@extends('auth/layout')

@section('title', 'Authentication')

@section('content')
    <div class="cont">
        @if (session('failed'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Auth failed! </strong>{{session('failed')}}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
            </div>
        @endif

        <form action="{{route('login.process')}}" method="POST">
            @csrf
            <div class="form sign-in">
                <h2>Welcome to CRC CARE</h2>
                <label>
                    <span>Email</span>
                    <input type="email" name="email">
                </label>
                <label>
                    <span>Password</span>
                    <input type="password" name="password">
                </label>
                <p class="forgot-pass"><a href="/forgot-password">Forgot password?</a></p>
                <button type="submit" class="submit">Sign In</button>
            </div>
        </form>
        <div class="sub-cont">
            <div class="img">
                <div class="img__text m--up">
                    <img src="{!!asset('assets/images/logo_crc-white.png')!!}" alt="">
                    <h2>New user?</h2>
                    <p>Click SIGN UP, fill in your details and start your journey with us.</p>
                </div>
                <div class="img__text m--in">
                    <img src="{!!asset('assets/images/logo_crc-white.png')!!}" alt="">
                    <h2>One of us?</h2>
                    <p>If you already have an account, just sign in below.</p>
                </div>
                <div class="img__btn">
                    <span class="m--up">Sign Up</span>
                    <span class="m--in">Sign In</span>
                </div>
            </div>
            <div class="form sign-up">
                <h2>Request for CRC CARE</h2>
                <form class="register-form" action="/register-new-user" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label>
                                <span>Full Name</span>
                                <input type="text" required autofocus name="fullname" />
                                <p class="text-danger error-name"></p>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label>
                                <span>Organisation</span>
                                <input type="text" required name="organisation" />
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>
                                <span>Email Address</span>
                                <input type="email" required name="email" />
                                <p class="text-danger error-email"></p>
                            </label>
                        </div>
                        <label>
                            <span>Phone</span>
                            <input type="number" required name="phone" />
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label>
                                <span>Password</span>
                                <input type="password" name="password" id="password" />
                                <p class="text-danger error-password"></p>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label>
                                <span>Verify Password</span>
                                <input type="password" name="verify_password" id="confirm-password" />
                                <p class="text-danger error-confirm-password"></p>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="submit">Sign Up</button>
                </form>
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

  $('.register-form .submit').on('click', () => {
    event.preventDefault();
    const passwordEl = $('.register-form').find('input[name="password"]');
    const confirmPasswordEl = $('.register-form').find('input[name="verify_password"]');
    const isValid = validate(passwordEl, confirmPasswordEl);
    if (!isValid) return false;

    // also check the email and name to make sure they're unique
    $.ajax({
      url: '/api/users/check-user-data',
      method: 'POST',
      data: {
        _token: "{{ csrf_token() }}",
        email: $('.register-form').find('input[name="email"]').val(),
        name: $('.register-form').find('input[name="fullname"]').val(),
      },
      dataType: 'json',
      success: ({ existingEmail, existingName }) => {
        if (existingEmail) {
          $('.error-email').html('Email already exists!');
        } else {
          $('.error-email').html('');
        }
        if (existingName) {
          $('.error-name').html('Name already exists!');
        } else {
          $('.error-name').html('');
        }

        if (!existingEmail && !existingName) {
          $('.register-form').submit();
        }
      },
    });

    return false;
  });
});
</script>
@endsection
