<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use DateTime;
use Mail;
use Ramsey\Uuid\Uuid;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function processLogin(Request $request)
    {
        $request->merge(['status' => '1']);

        if (Auth::attempt($request->only('email', 'password', 'status'))) {
            $user = User::where(['email' => $request->email])->first();
            Auth::loginUsingId($user->id, TRUE);
            return redirect('/');
        }
        return back()->with('failed', ' Please check your auth status or your input!');
    }

    public function getLoggedInUser()
    {
        $findId = Auth::id();
        return User::find($findId);
    }

    public function registerNewUser(Request $req)
    {
        $newUser = new User;
        $newUser->name = $req->fullname;
        $newUser->role = User::ROLES['USER'];
        $newUser->organisation = $req->organisation;
        $newUser->email = $req->email;
        $newUser->phone = $req->phone;
        $newUser->password = Hash::make($req->password);
        $newUser->save();

        Mail::send('emails.registration-admin', ['user' => $newUser], function ($mail) use ($newUser) {
            $email = env('PLATFORM_EMAIL', 'hello@crccaretools.com.au');
            $emailName = env('PLATFORM_EMAIL_NAME', 'CRC CARE Tools');
            $adminEmail = env('ADMIN_EMAIL', '');
            $mail->from($email, $emailName);
            $mail->to($adminEmail)->subject("[{$newUser->email}] New User Registration");
        });

        return back()->with('success', ' We will send an email confirmation once your account has been activated.');
    }

    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }

    public function processForgotPassword(Request $req)
    {
        $email = $req->email;
        $user = User::where(['email' => $email])->first();
        if (!$user) return back()->with('error', 'User not found, please request your reset link again.');

        // create a reset password token
        $user->resetPasswordToken = Uuid::uuid4();
        $user->resetPasswordTokenCreatedAt = (new DateTime())->getTimestamp();
        $user->save();

        Mail::send('emails.forgotPassword', ['user' => $user], function ($mail) use ($user) {
            $email = env('PLATFORM_EMAIL', 'hello@crccaretools.com.au');
            $emailName = env('PLATFORM_EMAIL_NAME', 'CRC CARE Tools');
            $mail->from($email, $emailName);
            $mail->to($user->email)->subject("[{$user->email}] Reset Password");
        });

        return back()->with('success', ' We will send an email with the reset password link to you shortly.');
    }

    public function resetPasswordView($token)
    {
        $user = User::where(['resetPasswordToken' => $token])->first();
        if (!$user) {
            return view('auth.resetPassword', ['token' => $token])->with('error', 'Token not found, please request your reset link again.');
        }
        if (strtotime($user->resetPasswordTokenCreatedAt) + 86400 > (new DateTime())->getTimestamp()) {
            return view('auth.resetPassword', ['token' => $token])->with('error', 'Token expired, please request your reset link again. ');
        }

        return view('auth.resetPassword', ['token' => $token]);
    }

    public function processResetPassword(Request $req)
    {
        $data = $req->only(['password', 'resetPasswordToken']);
        $user = User::where(['resetPasswordToken' => $data['resetPasswordToken']])->first();
        if (!$user) {
            return back()->with('error', 'Token not found, please request your reset link again.');
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('login.show')->with('success', 'Your password has been reset.');
    }
}
