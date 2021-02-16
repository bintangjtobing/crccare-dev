<?php

namespace App\Http\Controllers;

use Mail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers()
    {
        return User::all();
    }

    public function addUser(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = User::ROLES['USER'];
        $user->organisation = $request->organisation;
        $user->phone = $request->phone;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
        $user->createdBy = Auth::id();
        $user->save();

        return response()->json($user, 201);
    }

    /**
     * only if current user is admin
     * if current user is not an admin, just return 204
     */
    public function deleteUser($id)
    {
        $currentUser = User::find(Auth::id());
        if ($currentUser->role === 'admin') {
            $user = User::find($id);
            $user->delete();
        }
        return response()->json([], 204);
    }

    public function getUserById($id)
    {
        $currentUser = User::find(Auth::id());
        if ($currentUser && $currentUser->id == $id) {
            return response()->json($currentUser);
        }

        if (!$currentUser || $currentUser->role !== 'admin') {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(User::find($id));
    }

    public function updateUser($id, Request $request)
    {
        $user = User::find($id);

        $shouldSendEmail = ($request->status === User::STATUSES['ACTIVE']) && ($user->status === User::STATUSES['INACTIVE']);

        foreach (['name', 'organisation', 'email', 'phone', 'status'] as $field) {
            if (isset($request->{$field})) {
                $user->{$field} = $request->{$field};
            }
        }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // sending email if status change from inactive to active
        if ($shouldSendEmail) {
            Mail::send('emails.registration-user', [], function ($mail) use ($user) {
                $email = env('PLATFORM_EMAIL', 'hello@crccaretools.com.au');
                $emailName = env('PLATFORM_EMAIL_NAME', 'CRC CARE Tools');
                $mail->from($email, $emailName);
                $mail->to($user->email)->subject('Your Mine Care user account has been activated');
            });
        }

        return response()->json($user);
    }

    /**
     * check if email and full name is duplicated
     */
    public function checkUserData(Request $req)
    {
        $data = $req->all();
        $userId = isset($data['id']) ? $data['id'] : null;
        $sameEmailUser = User::where(['email' => $data['email']])->first();
        $sameNameUser = User::where(['name' => $data['name']])->first();

        return response()->json([
            'existingEmail' => isset($sameEmailUser) && $sameEmailUser->id != $userId,
            'existingName' => isset($sameNameUser) && $sameNameUser->id != $userId,
        ]);
    }
}
