<h3>Hi {{ $user->name }},</h3>

<p style="font-size: 12px;">You recently requested to reset your password for your CRC CARE account. Click the button below to reset it.</p>

<div style="font-size: 12px;"><a href="{{ route('login.resetPasswordView', ['token' => $user->resetPasswordToken]) }}" target="_blank" type="button">Reset</a></div>

<p style="font-size: 12px;">If you did not request a password reset, please ignore this email or reply to let us know. This password reset is only valid for the next 60 minutes.</p>

<p style="font-size: 12px;">
Thanks,<br />
CRC CARE team
</p>

<p style="font-size: 10px;">If you are having trouble clicking the reset button, copy and paste the URL below into your web browser.</p>
<p style="font-size: 10px;">{{ route('login.resetPasswordView', ['token' => $user->resetPasswordToken]) }}</p>
